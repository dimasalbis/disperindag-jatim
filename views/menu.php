<?php

namespace PHPMaker2021\buat_mesin;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(15, "mci_Master", $MenuLanguage->MenuPhrase("15", "MenuText"), "", -1, "", true, false, true, "fa-home", "", false);
$sideMenu->addMenuItem(17, "mi_pelatihan_siswa", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "pelatihansiswalist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pelatihan_siswa'), false, false, " fa-graduation-cap", "", false);
$sideMenu->addMenuItem(18, "mi_pendataan_lahan", $MenuLanguage->MenuPhrase("18", "MenuText"), $MenuRelativePath . "pendataanlahanlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pendataan_lahan'), false, false, " fa-database", "", false);
$sideMenu->addMenuItem(11, "mi_users", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "userslist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}users'), false, false, "fa-user", "", false);
$sideMenu->addMenuItem(13, "mi_m_mesin", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "mmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}m_mesin'), false, false, " fa-microchip", "", false);
$sideMenu->addMenuItem(6, "mi_pembuatan_mesin", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "pembuatanmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pembuatan_mesin'), false, false, " fa-plus-square", "", false);
$sideMenu->addMenuItem(14, "mi_perusahaan_penampung", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "perusahaanpenampunglist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}perusahaan_penampung'), false, false, "fa-university", "", false);
$sideMenu->addMenuItem(12, "mi_penyewaan_mesin", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "penyewaanmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}penyewaan_mesin'), false, false, "", "", false);
$sideMenu->addMenuItem(43, "mci_Dashboard", $MenuLanguage->MenuPhrase("43", "MenuText"), "", -1, "", true, false, true, " fa-tachometer", "", false);
$sideMenu->addMenuItem(33, "mci_Admin", $MenuLanguage->MenuPhrase("33", "MenuText"), "", -1, "", IsLoggedIn(), false, true, "fa-id-card", "", false);
$sideMenu->addMenuItem(34, "mi_statuslevels", $MenuLanguage->MenuPhrase("34", "MenuText"), $MenuRelativePath . "statuslevelslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}statuslevels'), false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_userlevels", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "userlevelslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevels'), false, false, "", "", false);
$sideMenu->addMenuItem(1, "mi_failed_jobs", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "failedjobslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}failed_jobs'), false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_migrations", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "migrationslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}migrations'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_password_reset_tokens", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "passwordresettokenslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_reset_tokens'), false, false, "", "", false);
$sideMenu->addMenuItem(5, "mi_password_resets", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "passwordresetslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_resets'), false, false, "", "", false);
$sideMenu->addMenuItem(7, "mi_permissions2", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "permissions2list", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}permissions'), false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_personal_access_tokens", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "personalaccesstokenslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}personal_access_tokens'), false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_userlevelpermissions", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "userlevelpermissionslist", 33, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevelpermissions'), false, false, "", "", false);
echo $sideMenu->toScript();
