<?php
/**
 * PHPMaker 2021 user level settings
 */
namespace PHPMaker2021\buat_mesin;

// User level info
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"],
    ["1","karyawan"]];
// User level priv info
$USER_LEVEL_PRIVS = [["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}failed_jobs","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}failed_jobs","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}failed_jobs","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}migrations","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}migrations","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}migrations","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_reset_tokens","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_reset_tokens","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_reset_tokens","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_resets","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_resets","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}password_resets","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}penyewaan_mesin","-2","72"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}penyewaan_mesin","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}penyewaan_mesin","1","8"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pembuatan_mesin","-2","72"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pembuatan_mesin","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}pembuatan_mesin","1","8"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}permissions","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}permissions","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}permissions","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}personal_access_tokens","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}personal_access_tokens","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}personal_access_tokens","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevelpermissions","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevelpermissions","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevelpermissions","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevels","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevels","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}userlevels","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}users","-2","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}users","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}users","1","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}m_mesin","-2","72"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}m_mesin","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}m_mesin","1","15"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}perusahaan_penampung","-2","72"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}perusahaan_penampung","0","0"],
    ["{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}perusahaan_penampung","1","8"]];
// User level table info
$USER_LEVEL_TABLES = [["failed_jobs","failed_jobs","failed jobs",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","failedjobslist"],
    ["migrations","migrations","migrations",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","migrationslist"],
    ["password_reset_tokens","password_reset_tokens","password reset tokens",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","passwordresettokenslist"],
    ["password_resets","password_resets","password resets",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","passwordresetslist"],
    ["penyewaan_mesin","penyewaan_mesin","penyewaan mesin",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","penyewaanmesinlist"],
    ["pembuatan_mesin","pembuatan_mesin","pembuatan mesin",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","pembuatanmesinlist"],
    ["permissions","permissions2","permissions",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","permissions2list"],
    ["personal_access_tokens","personal_access_tokens","personal access tokens",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","personalaccesstokenslist"],
    ["userlevelpermissions","userlevelpermissions","userlevelpermissions",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","userlevelpermissionslist"],
    ["userlevels","userlevels","userlevels",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","userlevelslist"],
    ["users","users","users",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","userslist"],
    ["m_mesin","m_mesin","mesin",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","mmesinlist"],
    ["perusahaan_penampung","perusahaan_penampung","perusahaan penampung",true,"{FA6619F7-C8CD-4441-9BD7-5BA29B100C00}","perusahaanpenampunglist"]];
