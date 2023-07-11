<?php

namespace PHPMaker2023\pembuatan_mesin;

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

/**
 * Two Factor Authentication class (Google Authenticator only)
 */
class SonataTwoFactorAuthentication extends AbstractTwoFactorAuthentication implements TwoFactorAuthenticationInterface
{
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
        return GoogleQrUrl::generate($usr, $secret, $issuer, $size);
    }

    /**
     * Check code
     *
     * @param string $secret Secret
     * @param string $code Code
     */
    public static function checkCode($secret, $code): bool
    {
        $g = new GoogleAuthenticator(Config("TWO_FACTOR_AUTHENTICATION_PASS_CODE_LENGTH"));
        return $g->checkCode($secret, $code, Config("TWO_FACTOR_AUTHENTICATION_DISCREPANCY"));
    }

    /**
     * Generate secret
     */
    public static function generateSecret(): string
    {
        $g = new GoogleAuthenticator(Config("TWO_FACTOR_AUTHENTICATION_PASS_CODE_LENGTH"));
        return $g->generateSecret();
    }

    /**
     * Show QR Code URL (API action)
     *
     * @return void
     */
    public function show()
    {
        $user = CurrentUserName(); // Must be current user
        $profile = Container("profile");
        if (!$profile->hasUserSecret($user, true)) {
            $secret = $profile->getUserSecret($user); // Get Secret
            WriteJson(["url" => self::getQrCodeUrl($user, $secret), "success" => true]);
            return;
        }
        WriteJson(["success" => false]);
    }
}
