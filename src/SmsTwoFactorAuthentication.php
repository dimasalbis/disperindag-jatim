<?php

namespace PHPMaker2023\pembuatan_mesin;

/**
 * Two Factor Authentication class (SMS Authentication only)
 */
class SmsTwoFactorAuthentication extends AbstractTwoFactorAuthentication implements TwoFactorAuthenticationInterface
{
    /**
     * Send one time password
     *
     * @param string $usr User
     */
    public static function sendOneTimePassword($usr, $account = null)
    {
        global $UserProfile, $Language;

        // Get mobile number
        $oldAccount = self::getAccount($usr);
        $mobileNumber = $account ?? $oldAccount;
        if (EmptyValue($mobileNumber)) { // Check if empty, cannot use CheckPhone due to possible different phone number formats
            return str_replace(["%a", "%u"], [$mobileNumber, $usr], $Language->phrase("SendOTPSkipped")); // Return error message
        }

        // Create OTP and save in user profile
        $secret = $UserProfile->getUserSecret($usr); // Get user secret
        $code = Random(Config("TWO_FACTOR_AUTHENTICATION_PASS_CODE_LENGTH")); // Generate OTP
        $encryptedCode = Encrypt($code, $secret); // Encrypt OTP
        $otpAccount = $oldAccount == $mobileNumber ? "" : $mobileNumber; // Save mobile number if changed
        $UserProfile->setOneTimePassword($usr, $otpAccount, $encryptedCode);

        // Send OTP
        $smsClass = Config("SMS_CLASS");
        $sms = new $smsClass();
        $sms->load(Config("SMS_ONE_TIME_PASSWORD_TEMPLATE"));
        $sms->replaceContent("<!--code-->", $code);
        $sms->replaceContent("<!--account-->", PartialHideValue($usr));
        $sms->Recipient = FormatPhoneNumber($mobileNumber);

        // Call Otp_Sending event
        if (Otp_Sending($usr, $sms)) {
            $res = $sms->send();
            return $res ? $res : $sms->SendErrDescription; // Return success / error description
        } else {
            return $sms->SendErrDescription ?: $Language->phrase("SendOTPCancelled"); // User cancel
        }
    }

    /**
     * Get account (mobile number)
     *
     * @param string $usr User
     */
    public static function getAccount($usr): string
    {
        global $UserTable;

        // Check if empty user
        if (EmptyValue($usr)) {
            return "";
        }

        // Check if phone field name is defined
        if (EmptyValue(Config("USER_PHONE_FIELD_NAME"))) {
            return "";
        }

        // Load phone number
        $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
        $sql = "SELECT " . QuotedName(Config("USER_PHONE_FIELD_NAME"), Config("USER_TABLE_DBID")) . " FROM " . Config("USER_TABLE") . " WHERE " . $filter;
        $row = $UserTable->getConnection()->fetchAssociative($sql);
        if ($row !== false) {
            return strval(GetUserInfo(Config("USER_PHONE_FIELD_NAME"), $row));
        }
        return "";
    }

    /**
     * Check code
     *
     * @param string $otp One time password
     * @param string $code Code
     */
    public static function checkCode($otp, $code): bool
    {
        return $otp == $code;
    }

    /**
     * Generate secret
     */
    public static function generateSecret(): string
    {
        return Random(); // Generate a radom number for secret, used for encrypting OTP
    }

    /**
     * Show User Phone
     *
     * @return void
     */
    public function show()
    {
        $user = CurrentUserName(); // Must be current user
        $profile = Container("profile");
        $mobileNumber = self::getAccount($user); // Get mobile number
        WriteJson(["account" => $mobileNumber, "success" => true, "verified" => $profile->hasUserSecret($user, true)]);
    }
}
