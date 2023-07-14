<?php

namespace PHPMaker2021\project1;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;

// Handle Routes
return function (App $app) {
    // pendataan
    $app->any('/pendataanlist[/{id}]', PendataanController::class . ':list')->add(PermissionMiddleware::class)->setName('pendataanlist-pendataan-list'); // list
    $app->any('/pendataanadd[/{id}]', PendataanController::class . ':add')->add(PermissionMiddleware::class)->setName('pendataanadd-pendataan-add'); // add
    $app->any('/pendataanview[/{id}]', PendataanController::class . ':view')->add(PermissionMiddleware::class)->setName('pendataanview-pendataan-view'); // view
    $app->any('/pendataanedit[/{id}]', PendataanController::class . ':edit')->add(PermissionMiddleware::class)->setName('pendataanedit-pendataan-edit'); // edit
    $app->any('/pendataandelete[/{id}]', PendataanController::class . ':delete')->add(PermissionMiddleware::class)->setName('pendataandelete-pendataan-delete'); // delete
    $app->group(
        '/pendataan',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', PendataanController::class . ':list')->add(PermissionMiddleware::class)->setName('pendataan/list-pendataan-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', PendataanController::class . ':add')->add(PermissionMiddleware::class)->setName('pendataan/add-pendataan-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', PendataanController::class . ':view')->add(PermissionMiddleware::class)->setName('pendataan/view-pendataan-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', PendataanController::class . ':edit')->add(PermissionMiddleware::class)->setName('pendataan/edit-pendataan-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', PendataanController::class . ':delete')->add(PermissionMiddleware::class)->setName('pendataan/delete-pendataan-delete-2'); // delete
        }
    );

    // model_has_roles
    $app->any('/modelhasroleslist[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':list')->add(PermissionMiddleware::class)->setName('modelhasroleslist-model_has_roles-list'); // list
    $app->any('/modelhasrolesadd[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':add')->add(PermissionMiddleware::class)->setName('modelhasrolesadd-model_has_roles-add'); // add
    $app->any('/modelhasrolesview[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':view')->add(PermissionMiddleware::class)->setName('modelhasrolesview-model_has_roles-view'); // view
    $app->any('/modelhasrolesedit[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':edit')->add(PermissionMiddleware::class)->setName('modelhasrolesedit-model_has_roles-edit'); // edit
    $app->any('/modelhasrolesdelete[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':delete')->add(PermissionMiddleware::class)->setName('modelhasrolesdelete-model_has_roles-delete'); // delete
    $app->group(
        '/model_has_roles',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':list')->add(PermissionMiddleware::class)->setName('model_has_roles/list-model_has_roles-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':add')->add(PermissionMiddleware::class)->setName('model_has_roles/add-model_has_roles-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':view')->add(PermissionMiddleware::class)->setName('model_has_roles/view-model_has_roles-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':edit')->add(PermissionMiddleware::class)->setName('model_has_roles/edit-model_has_roles-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{role_id}/{model_type}/{model_id}]', ModelHasRolesController::class . ':delete')->add(PermissionMiddleware::class)->setName('model_has_roles/delete-model_has_roles-delete-2'); // delete
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

    // roles
    $app->any('/roleslist[/{id}]', RolesController::class . ':list')->add(PermissionMiddleware::class)->setName('roleslist-roles-list'); // list
    $app->any('/rolesadd[/{id}]', RolesController::class . ':add')->add(PermissionMiddleware::class)->setName('rolesadd-roles-add'); // add
    $app->any('/rolesview[/{id}]', RolesController::class . ':view')->add(PermissionMiddleware::class)->setName('rolesview-roles-view'); // view
    $app->any('/rolesedit[/{id}]', RolesController::class . ':edit')->add(PermissionMiddleware::class)->setName('rolesedit-roles-edit'); // edit
    $app->any('/rolesdelete[/{id}]', RolesController::class . ':delete')->add(PermissionMiddleware::class)->setName('rolesdelete-roles-delete'); // delete
    $app->group(
        '/roles',
        function (RouteCollectorProxy $group) {
            $group->any('/' . Config("LIST_ACTION") . '[/{id}]', RolesController::class . ':list')->add(PermissionMiddleware::class)->setName('roles/list-roles-list-2'); // list
            $group->any('/' . Config("ADD_ACTION") . '[/{id}]', RolesController::class . ':add')->add(PermissionMiddleware::class)->setName('roles/add-roles-add-2'); // add
            $group->any('/' . Config("VIEW_ACTION") . '[/{id}]', RolesController::class . ':view')->add(PermissionMiddleware::class)->setName('roles/view-roles-view-2'); // view
            $group->any('/' . Config("EDIT_ACTION") . '[/{id}]', RolesController::class . ':edit')->add(PermissionMiddleware::class)->setName('roles/edit-roles-edit-2'); // edit
            $group->any('/' . Config("DELETE_ACTION") . '[/{id}]', RolesController::class . ':delete')->add(PermissionMiddleware::class)->setName('roles/delete-roles-delete-2'); // delete
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
