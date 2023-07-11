<?php

namespace PHPMaker2023\pembuatan_mesin;

use PragmaRX\Google2FA\Google2FA;
use Com\Tecnick\Barcode\Barcode;

/**
 * Two Factor Authentication class (Google Authenticator only)
 */
class PragmaRxTwoFactorAuthentication extends AbstractTwoFactorAuthentication implements TwoFactorAuthenticationInterface
{
    /**
     * Get Google2FA
     *
     * @return Google2FA
     */
    public static function getGoogle2FA()
    {
        $g = new Google2FA();
        $g->setWindow(Config("TWO_FACTOR_AUTHENTICATION_DISCREPANCY"));
        $g->setOneTimePasswordLength(Config("TWO_FACTOR_AUTHENTICATION_PASS_CODE_LENGTH"));
        $g->setEnforceGoogleAuthenticatorCompatibility(true);
        return $g;
    }

    /**
     * Get QR Code URL
     *
     * @param string $usr User
     * @param string $secret Secret
     * @param string|null $issuer Issuer
     * @param int $size Size
     * @return string URL
     */
    public static function getQrCodeUrl($usr, $secret, $issuer = null, $size = 0)
    {
        $issuer ??= Config("TWO_FACTOR_AUTHENTICATION_ISSUER");
        $size = $size ?: Config("TWO_FACTOR_AUTHENTICATION_QRCODE_SIZE");
        $g = self::getGoogle2FA();
        $url = $g->getQRCodeUrl($issuer, $usr, $secret);
        $barcode = new Barcode();
        $bobj = $barcode->getBarcodeObj(
            "QRCODE,H", // Barcode type and additional comma-separated parameters
            $url, // Data string to encode
            $size, // Width (use absolute or negative value as multiplication factor)
            $size, // Height (use absolute or negative value as multiplication factor)
            "black", // Foreground color
            [-2, -2, -2, -2] // Padding (use absolute or negative values as multiplication factors)
        )->setBackgroundColor("white"); // Background color
        return "data:image/png;base64," . base64_encode($bobj->getPngData());
    }

    /**
     * Check code
     *
     * @param string $secret Secret
     * @param string $code Code
     */
    public static function checkCode($secret, $code): bool
    {
        $g = self::getGoogle2FA();
        return $g->verifyKey($secret, $code);
    }

    /**
     * Generate secret
     */
    public static function generateSecret(): string
    {
        $g = self::getGoogle2FA();
        return $g->generateSecretKey();
    }

    /**
     * Show QR Code URL (API action)
     *
     * @return void
     */
    public function show($size = 0)
    {
        $user = CurrentUserName(); // Must be current user
        $profile = Container("profile");
        if (!$profile->hasUserSecret($user, true)) {
            $secret = $profile->getUserSecret($user); // Get Secret
            WriteJson(["url" => self::getQrCodeUrl($user, $secret, null, $size), "success" => true]);
            return;
        }
        WriteJson(["success" => false]);
    }
}
