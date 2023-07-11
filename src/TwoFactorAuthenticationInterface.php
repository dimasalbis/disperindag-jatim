<?php

namespace PHPMaker2023\pembuatan_mesin;

/**
 * Two Factor Authentication interface
 */
interface TwoFactorAuthenticationInterface
{
    /**
     * Check code
     *
     * @param string $secret Secret / One time password
     * @param string $code Code
     * @return bool
     */
    public static function checkCode($secret, $code): bool;

    /**
     * Generate secret
     *
     * @return string
     */
    public static function generateSecret(): string;

    /**
     * Show (API action)
     *
     * @return void
     */
    public function show();

    /**
     * Generate backup codes
     *
     * @return array
     */
    public static function generateBackupCodes(): array;

    /**
     * Get backup codes (API action)
     *
     * @return void
     */
    public function getBackupCodes();

    /**
     * Get new backup codes (API action)
     *
     * @return void
     */
    public function getNewBackupCodes();

    /**
     * Verify (API action)
     *
     * @param string $code
     * @return void
     */
    public function verify($code);

    /**
     * Reset (API action)
     *
     * @param string $user
     * @return void
     */
    public function reset($user);
}
