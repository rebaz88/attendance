<?php

Route::get('', 'Cp\IndexController@index')->name('control_panel_home');

Route::match(['get', 'post'], 'settings', function () {
    return view('cp.settings.index');
});

// Activity log
Route::get('/activities', 'Cp\ActivityController@index');
Route::get('/activities/list', 'Cp\ActivityController@list');
Route::get('/activities/list/model-activity-name', 'Cp\ActivityController@listModelActivityNames');

// Roles
Route::get('/roles', 'Cp\RoleController@index');
Route::get('/roles/list', 'Cp\RoleController@list');
Route::post('/roles/insert', 'Cp\RoleController@insert');
Route::post('/roles/update', 'Cp\RoleController@update');
Route::post('/roles/destroy', 'Cp\RoleController@destroy');
Route::get('/roles/permissions/show', 'Cp\RoleController@showPermissions');
Route::get('/roles/permissions/list', 'Cp\RoleController@listRolePermissions');
Route::post('/roles/permissions/set', 'Cp\RoleController@setPermission');

// Permissions
Route::get('permissions', 'Cp\PermissionController@index');
Route::get('permissions/{role_id}/list', 'Cp\PermissionController@list');
Route::post('permissions/{role_id}/save', 'Cp\PermissionController@save');

// User
Route::get('/users', 'Cp\UserController@index');
Route::get('/users/list', 'Cp\UserController@list');
Route::post('/users/create', 'Cp\UserController@create');
Route::post('/users/update', 'Cp\UserController@update');
Route::post('/users/destroy', 'Cp\UserController@destroy');
Route::post('/users/toggle-status', 'Cp\UserController@toggleStatus');
Route::post('/users/reset-password', 'Cp\UserController@resetPassword');
Route::post('/users/switch-current-agent', 'Cp\UserController@switchCurrentAgent');

Route::get('/chgpwd', 'Cp\IndexController@showChgpwdForm');
Route::post('/chgpwd', 'Cp\IndexController@chgpwd')->name('cp_chgpwd');

Route::get('login', 'Cp\LoginController@showLoginForm')->name('cp_login');
Route::post('login', 'Cp\LoginController@login');
Route::get('logout', 'Cp\LoginController@logout')->name('cp_logout');

// Log
Route::get('/logs', 'Cp\LogController@index');
Route::get('/logs/list', 'Cp\LogController@list');
Route::get('/logs/import', 'Cp\LogController@import');