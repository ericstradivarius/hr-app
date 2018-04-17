<?php

/*
|--------------------------------------------------------------------------
| Common Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for API and WEB in your application.
|
*/


Route::get('/images/{entity}/{path}', 'ImageController@show')->where('path', '.*');
Route::resource('files', 'FileController', [
	'only' => ['store', 'show', 'destroy'],
	'parameters' => ['files' => 'file']
]);

Route::get('candidates/count', 'candidateController@count');
Route::get('candidates/export', 'candidateController@export');
Route::resource('candidates', 'candidateController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'],
	'parameters' => ['candidates' => 'candidate']
]);

Route::get('campaigns-candidates', 'candidateController@campaignCandidates');
Route::get('campaigns/count', 'campaignController@count');
Route::get('campaigns/export', 'campaignController@export');
Route::resource('campaigns', 'campaignController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'],
	'parameters' => ['campaigns' => 'campaign']
]);

Route::get('user-permissions/count', 'UserPermissionController@count');
Route::get('user-permissions/export', 'UserPermissionController@export');
Route::resource('user-permissions', 'UserPermissionController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'],
	'parameters' => ['user-permissions' => 'userPermission']
]);

Route::get('user-types/count', 'UserTypeController@count');
Route::get('user-types/export', 'UserTypeController@export');
Route::resource('user-types', 'UserTypeController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'],
	'parameters' => ['user-types' => 'userType']
]);

Route::get('/user', 'UserController@me');
Route::get('users/count', 'UserController@count');
Route::get('users/export', 'UserController@export');
Route::resource('users', 'UserController', [
	'only' => ['index', 'store', 'show', 'update', 'destroy'],
	'parameters' => ['users' => 'user']
]);

Route::get('/download/{entity}/{path}', 'DownloadController@show')->where('path', '.*');
