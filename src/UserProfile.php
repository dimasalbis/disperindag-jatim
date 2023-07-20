<?php

namespace PHPMaker2021\buat_mesin;

/**
 * User Profile Class
 */
class UserProfile
{
    public $Profile = [];
    public $Provider = "";
    public $Auth = "";
    public $TimeoutTime;
    public $MaxRetryCount;
    public $RetryLockoutTime;

    // Constructor
    public function __construct()
    {
        $this->TimeoutTime = Config("USER_PROFILE_SESSION_TIMEOUT");
        $this->MaxRetryCount = Config("USER_PROFILE_MAX_RETRY");
        $this->RetryLockoutTime = Config("USER_PROFILE_RETRY_LOCKOUT");
        $this->load();

        // Concurrent login checking
        $this->Profile[Config("USER_PROFILE_SESSION_ID")] = "";
        $this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")] = "";

        // Max login retry
        $this->Profile[Config("USER_PROFILE_LOGIN_RETRY_COUNT")] = 0;
        $this->Profile[Config("USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME")] = "";
    }

    // Has value
    public function has($name)
    {
        return array_key_exists($name, $this->Profile);
    }

    // Get value
    public function getValue($name)
    {
        if ($this->has($name)) {
            return $this->Profile[$name];
        }
        return null;
    }

    // Get all values
    public function getValues()
    {
        return $this->Profile;
    }

    // Get value (alias)
    public function get($name)
    {
        return $this->getValue($name);
    }

    // Set value
    public function setValue($name, $value)
    {
        $this->Profile[$name] = $value;
    }

    // Set value (alias)
    public function set($name, $value)
    {
        $this->setValue($name, $value);
    }

    // Set property // PHP
    public function __set($name, $value)
    {
        $this->setValue($name, $value);
    }

    // Get property // PHP
    public function __get($name)
    {
        return $this->getValue($name);
    }

    // Delete property
    public function delete($name)
    {
        if (array_key_exists($name, $this->Profile)) {
            unset($this->Profile[$name]);
        }
    }

    // Assign properties
    public function assign($input)
    {
        if (is_object($input)) {
            $this->assign(get_object_vars($input));
        } elseif (is_array($input)) {
            foreach ($input as $key => $value) { // Remove integer keys
                if (is_int($key)) {
                    unset($input[$key]);
                }
            }
            $input = array_filter($input, function ($val) {
                if (is_bool($val) || is_float($val) || is_int($val) || $val === null || is_string($val) && strlen($val) <= Config("DATA_STRING_MAX_LENGTH")) {
                    return true;
                }
                return false;
            });
            $this->Profile = array_merge($this->Profile, $input);
        }
    }

    // Check if System Admin
    protected function isSystemAdmin($usr)
    {
        global $Language;
        $adminUserName = Config("ENCRYPTION_ENABLED") ? PhpDecrypt(Config("ADMIN_USER_NAME"), Config("ENCRYPTION_KEY")) : Config("ADMIN_USER_NAME");
        return $usr == "" || $usr == $adminUserName || $usr == $Language->phrase("UserAdministrator");
    }

    // Get language id
    public function getLanguageId($usr)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $langid = @$this->Profile[Config("USER_PROFILE_LANGUAGE_ID")];
                $this->Profile = $p; // Restore current profile
                return $langid;
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return "";
            }
        }
        return "";
    }

    // Set language id
    public function setLanguageId($usr, $langid)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $this->Profile[Config("USER_PROFILE_LANGUAGE_ID")] = $langid;
                $this->saveProfileToDatabase($usr);
                $this->Profile = $p; // Restore current profile
                return true;
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return false;
            }
        }
        return false;
    }

    // Get search filters
    public function getSearchFilters($usr, $pageid)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $allfilters = @unserialize($this->Profile[Config("USER_PROFILE_SEARCH_FILTERS")]);
                $this->Profile = $p; // Restore current profile
                return @$allfilters[$pageid];
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return "";
            }
        }
        return "";
    }

    // Set search filters
    public function setSearchFilters($usr, $pageid, $filters)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $allfilters = @unserialize($this->Profile[Config("USER_PROFILE_SEARCH_FILTERS")]);
                if (!is_array($allfilters)) {
                    $allfilters = [];
                }
                $allfilters[$pageid] = $filters;
                $this->Profile[Config("USER_PROFILE_SEARCH_FILTERS")] = serialize($allfilters);
                $this->saveProfileToDatabase($usr);
                $this->Profile = $p; // Restore current profile
                return true;
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return false;
            }
        }
        return false;
    }

    // Load profile from database
    public function loadProfileFromDatabase($usr)
    {
        global $UserTable;
        if ($this->isSystemAdmin($usr)) { // Ignore system admin
            return false;
        }
        $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
        // Get SQL from getSql() method in <UserTable> class
        $sql = $UserTable->getSql($filter);
        if ($row = Conn($UserTable->Dbid)->fetchAssoc($sql)) {
            $this->loadProfile(HtmlDecode($row[Config("USER_PROFILE_FIELD_NAME")]));
            return true;
        }
        return false;
    }

    // Save profile to database
    public function saveProfileToDatabase($usr)
    {
        global $UserTable;
        if ($this->isSystemAdmin($usr)) { // Ignore system admin
            return false;
        }
        $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
        $rs = [Config("USER_PROFILE_FIELD_NAME") => $this->profileToString()];
        $UserTable->update($rs, $filter);
    }

    // Load profile from session
    public function load()
    {
        if (isset($_SESSION[SESSION_USER_PROFILE])) {
            $this->loadProfile($_SESSION[SESSION_USER_PROFILE]);
        }
    }

    // Save profile to session
    public function save()
    {
        $_SESSION[SESSION_USER_PROFILE] = $this->profileToString();
    }

    // Load profile from string
    protected function loadProfile($profile)
    {
        $ar = unserialize(strval($profile));
        if (is_array($ar)) {
            $this->Profile = array_merge($this->Profile, $ar);
        }
    }

    // Write (var_dump) profile
    public function writeProfile()
    {
        var_dump($this->Profile);
    }

    // Clear profile
    protected function clearProfile()
    {
        $this->Profile = [];
    }

    // Clear profile (alias)
    public function clear()
    {
        $this->clearProfile();
    }

    // Profile to string
    protected function profileToString()
    {
        return serialize($this->Profile);
    }

    // Is valid user
    public function isValidUser($usr, $sessionID)
    {
        if ($this->isSystemAdmin($usr) || IsApi()) { // Ignore system admin / API
            return true;
        }
        $this->loadProfileFromDatabase($usr);
        $sessid = strval(@$this->Profile[Config("USER_PROFILE_SESSION_ID")]);
        $dt = strval(@$this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")]);
        $valid = false;
        if ($sessid == "" || $sessid == $sessionID || $dt == "") {
            $sessid = $sessionID;
            $dt = StdCurrentDateTime();
            $valid = true;
        } elseif ($sessid != "" && $dt != "") {
            $ars = explode(",", $sessid);
            $ard = explode(",", $dt);
            $cnt = (count($ars) <= count($ard)) ? count($ars) : count($ard);
            $ars = array_slice($ars, 0, $cnt);
            $ard = array_slice($ard, 0, $cnt);
            for ($i = 0; $i < $cnt; $i++) {
                $sessid = $ars[$i];
                $dt = $ard[$i];
                if ($sessid == "" || $sessid == $sessionID || $dt == "" || DateDiff($dt, StdCurrentDateTime(), "n") > $this->TimeoutTime) {
                    $valid = true;
                    $ars[$i] = $sessionID;
                    $ard[$i] = StdCurrentDateTime();
                    break;
                }
            }
            if (!$valid && $cnt < Config("USER_PROFILE_CONCURRENT_SESSION_COUNT")) {
                $valid = true;
                $ars[] = $sessionID;
                $ard[] = StdCurrentDateTime();
            }
            $sessid = implode(",", $ars);
            $dt = implode(",", $ard);
        }
        if ($valid) {
            $this->Profile[Config("USER_PROFILE_SESSION_ID")] = $sessid;
            $this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")] = $dt;
            $this->saveProfileToDatabase($usr);
        }
        return $valid;
    }

    // Remove user
    public function removeUser($usr, $sessionID)
    {
        if ($this->isSystemAdmin($usr)) { // Ignore system admin
            return true;
        }
        $this->loadProfileFromDatabase($usr);
        $sessid = strval(@$this->Profile[Config("USER_PROFILE_SESSION_ID")]);
        $dt = strval(@$this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")]);
        if ($sessid == $sessionID) {
            $this->Profile[Config("USER_PROFILE_SESSION_ID")] = "";
            $this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")] = "";
            $this->saveProfileToDatabase($usr);
            return true;
        } elseif ($sessid != "" && $dt != "") {
            $ars = explode(",", $sessid);
            $ard = explode(",", $dt);
            $cnt = (count($ars) <= count($ard)) ? count($ars) : count($ard);
            $ars = array_slice($ars, 0, $cnt);
            $ard = array_slice($ard, 0, $cnt);
            for ($i = 0; $i < $cnt; $i++) {
                $sessid = $ars[$i];
                $dt = $ard[$i];
                if ($sessid == $sessionID) {
                    unset($ars[$i]);
                    unset($ard[$i]);
                    $this->Profile[Config("USER_PROFILE_SESSION_ID")] = implode(",", $ars);
                    $this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")] = implode(",", $ard);
                    $this->saveProfileToDatabase($usr);
                    return true;
                }
            }
        }
        return false;
    }

    // Reset concurrent user
    public function resetConcurrentUser($usr)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $this->Profile[Config("USER_PROFILE_SESSION_ID")] = "";
                $this->Profile[Config("USER_PROFILE_LAST_ACCESSED_DATE_TIME")] = "";
                $this->saveProfileToDatabase($usr);
                $this->Profile = $p; // Restore current profile
                return true;
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return false;
            }
        }
        return false;
    }

    // Exceed login retry
    public function exceedLoginRetry($usr)
    {
        if ($this->isSystemAdmin($usr)) { // Ignore system admin
            return false;
        }
        $this->loadProfileFromDatabase($usr);
        $retrycount = @$this->Profile[Config("USER_PROFILE_LOGIN_RETRY_COUNT")];
        $dt = @$this->Profile[Config("USER_PROFILE_LAST_BAD_LOGIN_DATE_TIME")];
        if ((int)$retrycount >= (int)$this->MaxRetryCount) {
            if (DateDiff($dt, StdCurrentDateTime(), "n") < $this->RetryLockoutTime) {
                $exceed = true;
            } else {
                $exceed = false;
                $this->Profile[Config("USER_PROFILE_LOGIN_RETRY_COUNT")] = 0;
                $this->saveProfileToDatabase($usr);
            }
        } else {
            $exceed = false;
        }
        return $exceed;
    }

    // Reset login retry
    public function resetLoginRetry($usr)
    {
        $p = $this->Profile; // Backup current profile
        if ($this->loadProfileFromDatabase($usr)) {
            try {
                $this->Profile[Config("USER_PROFILE_LOGIN_RETRY_COUNT")] = 0;
                $this->saveProfileToDatabase($usr);
                $this->Profile = $p; // Restore current profile
                return true;
            } catch (\Throwable $e) {
                if (Config("DEBUG")) {
                    throw $e;
                }
                $this->Profile = $p; // Restore current profile
                return false;
            }
        }
        return false;
    }
}
