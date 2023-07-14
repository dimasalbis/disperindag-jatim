<?php

namespace PHPMaker2021\project1;

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
$sideMenu->addMenuItem(1, "mi_pendataan", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "pendataanlist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}pendataan'), false, false, "", "", false);
$sideMenu->addMenuItem(2, "mi_model_has_roles", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "modelhasroleslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}model_has_roles'), false, false, "", "", false);
$sideMenu->addMenuItem(3, "mi_password_reset_tokens", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "passwordresettokenslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}password_reset_tokens'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_password_resets", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "passwordresetslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}password_resets'), false, false, "", "", false);
$sideMenu->addMenuItem(5, "mi_permissions2", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "permissions2list", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}permissions'), false, false, "", "", false);
$sideMenu->addMenuItem(6, "mi_personal_access_tokens", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "personalaccesstokenslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}personal_access_tokens'), false, false, "", "", false);
$sideMenu->addMenuItem(7, "mi_roles", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "roleslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}roles'), false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_userlevelpermissions", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "userlevelpermissionslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}userlevelpermissions'), false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_userlevels", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "userlevelslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}userlevels'), false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_users", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "userslist", -1, "", AllowListMenu('{89A2677C-3121-41A6-AB3E-41476028C07D}users'), false, false, "", "", false);
echo $sideMenu->toScript();
