<?php

namespace PHPMaker2023\pembuatan_mesin;

/**
 * Two Factor Authentication class (Email Authentication only)
 */
class EmailTwoFactorAuthentication extends AbstractTwoFactorAuthentication implements TwoFactorAuthenticationInterface
{
    /**
     * Send one time password
     *
     * @param string $usr User
     */
    public static function sendOneTimePassword($usr, $account = null)
    {
        global $UserProfile, $Language;

        // Get email address
        $oldAccount = self::getAccount($usr);
        $emailAddress = $account ?? $oldAccount;
        if (EmptyValue($emailAddress) || !CheckEmail($emailAddress)) { // Check if valid email address
            return str_replace(["%a", "%u"], [$emailAddress, $usr], $Language->phrase("SendOTPSkipped")); // Return error message
        }

        // Create OTP and save in user profile
        $secret = $UserProfile->getUserSecret($usr); // Get user secret
        $code = Random(Config("TWO_FACTOR_AUTHENTICATION_PASS_CODE_LENGTH")); // Generate OTP
        $encryptedCode = Encrypt($code, $secret); // Encrypt OTP
        $otpAccount = $oldAccount == $emailAddress ? "" : $emailAddress; // Save email address if changed
        $UserProfile->setOneTimePassword($usr, $otpAccount, $encryptedCode);

        // Send OTP email
        $email = new Email();
        $email->load(Config("EMAIL_ONE_TIME_PASSWORD_TEMPLATE"));
        $email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
        $email->replaceRecipient($emailAddress); // Replace Recipient
        $email->replaceContent("<!--code-->", $code);
        $email->replaceContent("<!--account-->", PartialHideValue($usr));

        // Call Otp_Sending event
        if (Otp_Sending($usr, $email)) {
            $res = $email->send();
            return $res ? $res : $email->SendErrDescription; // Return success / error description
        } else {
            return $email->SendErrDescription ?: $Language->phrase("SendOTPCancelled"); // User cancel
        }
    }

    /**
     * Get account (email address)
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

        // Check email field name not defined
        if (EmptyValue(Config("USER_EMAIL_FIELD_NAME"))) {
            return "";
        }

        // Load email address
        $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
        $sql = "SELECT " . QuotedName(Config("USER_EMAIL_FIELD_NAME"), Config("USER_TABLE_DBID")) . " FROM " . Config("USER_TABLE") . " WHERE " . $filter;
        $row = $UserTable->getConnection()->fetchAssociative($sql);
        if ($row !== false) {
            return strval(GetUserInfo(Config("USER_EMAIL_FIELD_NAME"), $row));
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
     * Show User Email
     *
     * @return void
     */
    public function show()
    {
        $user = CurrentUserName(); // Must be current user
        $profile = Container("profile");
        $emailAddress = self::getAccount($user); // Get email address
        WriteJson(["account" => $emailAddress, "success" => true, "verified" => $profile->hasUserSecret($user, true)]);
    }
}
