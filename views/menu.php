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
$sideMenu->addMenuItem(15, "mci_Master", $MenuLanguage->MenuPhrase("15", "MenuText"), "", -1, "", true, false, true, "", "", false);
$sideMenu->addMenuItem(11, "mi_users", $MenuLanguage->MenuPhrase("11", "MenuText"), $MenuRelativePath . "userslist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}users'), false, false, "", "", false);
$sideMenu->addMenuItem(13, "mi_m_mesin", $MenuLanguage->MenuPhrase("13", "MenuText"), $MenuRelativePath . "mmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}m_mesin'), false, false, "", "", false);
$sideMenu->addMenuItem(6, "mi_pembuatan_mesin", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "pembuatanmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pembuatan_mesin'), false, false, "", "", false);
$sideMenu->addMenuItem(14, "mi_perusahaan_penampung", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "perusahaanpenampunglist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}perusahaan_penampung'), false, false, "", "", false);
$sideMenu->addMenuItem(12, "mi_penyewaan_mesin", $MenuLanguage->MenuPhrase("12", "MenuText"), $MenuRelativePath . "penyewaanmesinlist", 15, "", AllowListMenu('{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}penyewaan_mesin'), false, false, "", "", false);
echo $sideMenu->toScript();
