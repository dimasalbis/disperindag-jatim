<?php

namespace PHPMaker2021\buat_mesin;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // failed_jobs
    $app->any('/failedjobslist[/{id}]', FailedJobsController::class . ':list')->add(PermissionMiddleware::class)->setName('failedjobslist-failed_jobs-list'); // list
    $app->any('/failedjobsadd[/{id}]', FailedJobsController::class . ':add')->add(PermissionMiddleware::class)->setName('failedjobsadd-failed_jobs-add'); // add
    $app->any('/failedjobsview[/{id}]', FailedJobsController::class . ':view')->add(PermissionMiddleware::class)->setName('failedjobsview-failed_jobs-view'); // view
    $app->any('/failedjobsedit[/{id}]', FailedJobsController::class . ':edit')->add(PermissionMiddleware::class)->setName('failedjobsedit-failed_jobs-edit'); // edit
    $app->any('/failedjobsdelete[/{id}]', FailedJobsController::class . ':delete')->add(PermissionMiddleware::class)->setName('failedjobsdelete-failed_jobs-delete'); // delete
    $app->group(
        '/failed_jobs',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', FailedJobsController::class . ':list')->add(PermissionMiddleware::class)->setName('failed_jobs/list-failed_jobs-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', FailedJobsController::class . ':add')->add(PermissionMiddleware::class)->setName('failed_jobs/add-failed_jobs-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', FailedJobsController::class . ':view')->add(PermissionMiddleware::class)->setName('failed_jobs/view-failed_jobs-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', FailedJobsController::class . ':edit')->add(PermissionMiddleware::class)->setName('failed_jobs/edit-failed_jobs-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', FailedJobsController::class . ':delete')->add(PermissionMiddleware::class)->setName('failed_jobs/delete-failed_jobs-delete-2'); // delete
        }
    );

    // migrations
    $app->any('/migrationslist[/{id}]', MigrationsController::class . ':list')->add(PermissionMiddleware::class)->setName('migrationslist-migrations-list'); // list
    $app->any('/migrationsadd[/{id}]', MigrationsController::class . ':add')->add(PermissionMiddleware::class)->setName('migrationsadd-migrations-add'); // add
    $app->any('/migrationsview[/{id}]', MigrationsController::class . ':view')->add(PermissionMiddleware::class)->setName('migrationsview-migrations-view'); // view
    $app->any('/migrationsedit[/{id}]', MigrationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('migrationsedit-migrations-edit'); // edit
    $app->any('/migrationsdelete[/{id}]', MigrationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('migrationsdelete-migrations-delete'); // delete
    $app->group(
        '/migrations',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MigrationsController::class . ':list')->add(PermissionMiddleware::class)->setName('migrations/list-migrations-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MigrationsController::class . ':add')->add(PermissionMiddleware::class)->setName('migrations/add-migrations-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MigrationsController::class . ':view')->add(PermissionMiddleware::class)->setName('migrations/view-migrations-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MigrationsController::class . ':edit')->add(PermissionMiddleware::class)->setName('migrations/edit-migrations-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MigrationsController::class . ':delete')->add(PermissionMiddleware::class)->setName('migrations/delete-migrations-delete-2'); // delete
        }
    );

    // password_reset_tokens
    $app->any('/passwordresettokenslist[/{_email}]', PasswordResetTokensController::class . ':list')->add(PermissionMiddleware::class)->setName('passwordresettokenslist-password_reset_tokens-list'); // list
    $app->any('/passwordresettokensadd[/{_email}]', PasswordResetTokensController::class . ':add')->add(PermissionMiddleware::class)->setName('passwordresettokensadd-password_reset_tokens-add'); // add
    $app->any('/passwordresettokensview[/{_email}]', PasswordResetTokensController::class . ':view')->add(PermissionMiddleware::class)->setName('passwordresettokensview-password_reset_tokens-view'); // view
    $app->any('/passwordresettokensedit[/{_email}]', PasswordResetTokensController::class . ':edit')->add(PermissionMiddleware::class)->setName('passwordresettokensedit-password_reset_tokens-edit'); // edit
    $app->any('/passwordresettokensdelete[/{_email}]', PasswordResetTokensController::class . ':delete')->add(PermissionMiddleware::class)->setName('passwordresettokensdelete-password_reset_tokens-delete'); // delete
    $app->group(
        '/password_reset_tokens',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{_email}]', PasswordResetTokensController::class . ':list')->add(PermissionMiddleware::class)->setName('password_reset_tokens/list-password_reset_tokens-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{_email}]', PasswordResetTokensController::class . ':add')->add(PermissionMiddleware::class)->setName('password_reset_tokens/add-password_reset_tokens-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{_email}]', PasswordResetTokensController::class . ':view')->add(PermissionMiddleware::class)->setName('password_reset_tokens/view-password_reset_tokens-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{_email}]', PasswordResetTokensController::class . ':edit')->add(PermissionMiddleware::class)->setName('password_reset_tokens/edit-password_reset_tokens-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{_email}]', PasswordResetTokensController::class . ':delete')->add(PermissionMiddleware::class)->setName('password_reset_tokens/delete-password_reset_tokens-delete-2'); // delete
        }
    );

    // password_resets
    $app->any('/passwordresetslist', PasswordResetsController::class . ':list')->add(PermissionMiddleware::class)->setName('passwordresetslist-password_resets-list'); // list
    $app->group(
        '/password_resets',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '', PasswordResetsController::class . ':list')->add(PermissionMiddleware::class)->setName('password_resets/list-password_resets-list-2'); // list
        }
    );

    // penyewaan_mesin
    $app->any('/penyewaanmesinlist[/{id}]', PenyewaanMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('penyewaanmesinlist-penyewaan_mesin-list'); // list
    $app->any('/penyewaanmesinadd[/{id}]', PenyewaanMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('penyewaanmesinadd-penyewaan_mesin-add'); // add
    $app->any('/penyewaanmesinview[/{id}]', PenyewaanMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('penyewaanmesinview-penyewaan_mesin-view'); // view
    $app->any('/penyewaanmesinedit[/{id}]', PenyewaanMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('penyewaanmesinedit-penyewaan_mesin-edit'); // edit
    $app->any('/penyewaanmesindelete[/{id}]', PenyewaanMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('penyewaanmesindelete-penyewaan_mesin-delete'); // delete
    $app->group(
        '/penyewaan_mesin',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PenyewaanMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('penyewaan_mesin/list-penyewaan_mesin-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PenyewaanMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('penyewaan_mesin/add-penyewaan_mesin-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PenyewaanMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('penyewaan_mesin/view-penyewaan_mesin-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PenyewaanMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('penyewaan_mesin/edit-penyewaan_mesin-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PenyewaanMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('penyewaan_mesin/delete-penyewaan_mesin-delete-2'); // delete
        }
    );

    // pembuatan_mesin
    $app->any('/pembuatanmesinlist[/{id}]', PembuatanMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('pembuatanmesinlist-pembuatan_mesin-list'); // list
    $app->any('/pembuatanmesinadd[/{id}]', PembuatanMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('pembuatanmesinadd-pembuatan_mesin-add'); // add
    $app->any('/pembuatanmesinview[/{id}]', PembuatanMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('pembuatanmesinview-pembuatan_mesin-view'); // view
    $app->any('/pembuatanmesinedit[/{id}]', PembuatanMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('pembuatanmesinedit-pembuatan_mesin-edit'); // edit
    $app->any('/pembuatanmesindelete[/{id}]', PembuatanMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('pembuatanmesindelete-pembuatan_mesin-delete'); // delete
    $app->group(
        '/pembuatan_mesin',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PembuatanMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('pembuatan_mesin/list-pembuatan_mesin-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PembuatanMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('pembuatan_mesin/add-pembuatan_mesin-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PembuatanMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('pembuatan_mesin/view-pembuatan_mesin-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PembuatanMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('pembuatan_mesin/edit-pembuatan_mesin-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PembuatanMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('pembuatan_mesin/delete-pembuatan_mesin-delete-2'); // delete
        }
    );

    // permissions2
    $app->any('/permissions2list[/{id}]', Permissions2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('permissions2list-permissions2-list'); // list
    $app->any('/permissions2add[/{id}]', Permissions2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('permissions2add-permissions2-add'); // add
    $app->any('/permissions2view[/{id}]', Permissions2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('permissions2view-permissions2-view'); // view
    $app->any('/permissions2edit[/{id}]', Permissions2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('permissions2edit-permissions2-edit'); // edit
    $app->any('/permissions2delete[/{id}]', Permissions2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('permissions2delete-permissions2-delete'); // delete
    $app->group(
        '/permissions2',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', Permissions2Controller::class . ':list')->add(PermissionMiddleware::class)->setName('permissions2/list-permissions2-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', Permissions2Controller::class . ':add')->add(PermissionMiddleware::class)->setName('permissions2/add-permissions2-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', Permissions2Controller::class . ':view')->add(PermissionMiddleware::class)->setName('permissions2/view-permissions2-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', Permissions2Controller::class . ':edit')->add(PermissionMiddleware::class)->setName('permissions2/edit-permissions2-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', Permissions2Controller::class . ':delete')->add(PermissionMiddleware::class)->setName('permissions2/delete-permissions2-delete-2'); // delete
        }
    );

    // personal_access_tokens
    $app->any('/personalaccesstokenslist[/{id}]', PersonalAccessTokensController::class . ':list')->add(PermissionMiddleware::class)->setName('personalaccesstokenslist-personal_access_tokens-list'); // list
    $app->any('/personalaccesstokensadd[/{id}]', PersonalAccessTokensController::class . ':add')->add(PermissionMiddleware::class)->setName('personalaccesstokensadd-personal_access_tokens-add'); // add
    $app->any('/personalaccesstokensview[/{id}]', PersonalAccessTokensController::class . ':view')->add(PermissionMiddleware::class)->setName('personalaccesstokensview-personal_access_tokens-view'); // view
    $app->any('/personalaccesstokensedit[/{id}]', PersonalAccessTokensController::class . ':edit')->add(PermissionMiddleware::class)->setName('personalaccesstokensedit-personal_access_tokens-edit'); // edit
    $app->any('/personalaccesstokensdelete[/{id}]', PersonalAccessTokensController::class . ':delete')->add(PermissionMiddleware::class)->setName('personalaccesstokensdelete-personal_access_tokens-delete'); // delete
    $app->group(
        '/personal_access_tokens',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PersonalAccessTokensController::class . ':list')->add(PermissionMiddleware::class)->setName('personal_access_tokens/list-personal_access_tokens-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PersonalAccessTokensController::class . ':add')->add(PermissionMiddleware::class)->setName('personal_access_tokens/add-personal_access_tokens-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PersonalAccessTokensController::class . ':view')->add(PermissionMiddleware::class)->setName('personal_access_tokens/view-personal_access_tokens-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PersonalAccessTokensController::class . ':edit')->add(PermissionMiddleware::class)->setName('personal_access_tokens/edit-personal_access_tokens-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PersonalAccessTokensController::class . ':delete')->add(PermissionMiddleware::class)->setName('personal_access_tokens/delete-personal_access_tokens-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->any('/userlevelpermissionslist[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissionslist-userlevelpermissions-list'); // list
    $app->any('/userlevelpermissionsadd[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissionsadd-userlevelpermissions-add'); // add
    $app->any('/userlevelpermissionsview[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissionsview-userlevelpermissions-view'); // view
    $app->any('/userlevelpermissionsedit[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissionsedit-userlevelpermissions-edit'); // edit
    $app->any('/userlevelpermissionsdelete[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissionsdelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}/{_tablename}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->any('/userlevelslist[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelslist-userlevels-list'); // list
    $app->any('/userlevelsadd[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelsadd-userlevels-add'); // add
    $app->any('/userlevelsview[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelsview-userlevels-view'); // view
    $app->any('/userlevelsedit[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelsedit-userlevels-edit'); // edit
    $app->any('/userlevelsdelete[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelsdelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{userlevelid}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // users
    $app->any('/userslist[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('userslist-users-list'); // list
    $app->any('/usersadd[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('usersadd-users-add'); // add
    $app->any('/usersview[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('usersview-users-view'); // view
    $app->any('/usersedit[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('usersedit-users-edit'); // edit
    $app->any('/usersdelete[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('usersdelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // m_mesin
    $app->any('/mmesinlist[/{id}]', MMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('mmesinlist-m_mesin-list'); // list
    $app->any('/mmesinadd[/{id}]', MMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('mmesinadd-m_mesin-add'); // add
    $app->any('/mmesinview[/{id}]', MMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('mmesinview-m_mesin-view'); // view
    $app->any('/mmesinedit[/{id}]', MMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('mmesinedit-m_mesin-edit'); // edit
    $app->any('/mmesindelete[/{id}]', MMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('mmesindelete-m_mesin-delete'); // delete
    $app->group(
        '/m_mesin',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', MMesinController::class . ':list')->add(PermissionMiddleware::class)->setName('m_mesin/list-m_mesin-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', MMesinController::class . ':add')->add(PermissionMiddleware::class)->setName('m_mesin/add-m_mesin-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', MMesinController::class . ':view')->add(PermissionMiddleware::class)->setName('m_mesin/view-m_mesin-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', MMesinController::class . ':edit')->add(PermissionMiddleware::class)->setName('m_mesin/edit-m_mesin-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', MMesinController::class . ':delete')->add(PermissionMiddleware::class)->setName('m_mesin/delete-m_mesin-delete-2'); // delete
        }
    );

    // perusahaan_penampung
    $app->any('/perusahaanpenampunglist[/{id}]', PerusahaanPenampungController::class . ':list')->add(PermissionMiddleware::class)->setName('perusahaanpenampunglist-perusahaan_penampung-list'); // list
    $app->any('/perusahaanpenampungadd[/{id}]', PerusahaanPenampungController::class . ':add')->add(PermissionMiddleware::class)->setName('perusahaanpenampungadd-perusahaan_penampung-add'); // add
    $app->any('/perusahaanpenampungview[/{id}]', PerusahaanPenampungController::class . ':view')->add(PermissionMiddleware::class)->setName('perusahaanpenampungview-perusahaan_penampung-view'); // view
    $app->any('/perusahaanpenampungedit[/{id}]', PerusahaanPenampungController::class . ':edit')->add(PermissionMiddleware::class)->setName('perusahaanpenampungedit-perusahaan_penampung-edit'); // edit
    $app->any('/perusahaanpenampungdelete[/{id}]', PerusahaanPenampungController::class . ':delete')->add(PermissionMiddleware::class)->setName('perusahaanpenampungdelete-perusahaan_penampung-delete'); // delete
    $app->group(
        '/perusahaan_penampung',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PerusahaanPenampungController::class . ':list')->add(PermissionMiddleware::class)->setName('perusahaan_penampung/list-perusahaan_penampung-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PerusahaanPenampungController::class . ':add')->add(PermissionMiddleware::class)->setName('perusahaan_penampung/add-perusahaan_penampung-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PerusahaanPenampungController::class . ':view')->add(PermissionMiddleware::class)->setName('perusahaan_penampung/view-perusahaan_penampung-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PerusahaanPenampungController::class . ':edit')->add(PermissionMiddleware::class)->setName('perusahaan_penampung/edit-perusahaan_penampung-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PerusahaanPenampungController::class . ':delete')->add(PermissionMiddleware::class)->setName('perusahaan_penampung/delete-perusahaan_penampung-delete-2'); // delete
        }
    );

    // error
    $app->any('/error', OthersController::class . ':error')->add(PermissionMiddleware::class)->setName('error');

    // personal_data
    $app->any('/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->any('/login', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // userpriv
    $app->any('/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->any('/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->any('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        Route_Action($app);
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            $error = [
                "statusCode" => "404",
                "error" => [
                    "class" => "text-warning",
                    "type" => Container("language")->phrase("Error"),
                    "description" => str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")),
                ],
            ];
            Container("flash")->addMessage("error", $error);
            return $response->withStatus(302)->withHeader("Location", GetUrl("error")); // Redirect to error page
        }
    );
};
