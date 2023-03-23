<?php


/**
 * @var $router FluentPlugin\Framework\Http\Router\Router
 */

// $router->get('/welcome', 'WelcomeController@index');

$router->post('/create-vault', 'VaultController@store');
$router->get('/get-all-vault/{type}', 'VaultController@getVaultItems');
$router->post('/create-folder', 'FolderController@store');
$router->get('/get-folder', 'FolderController@allFolder');
$router->get('/get-item/{id}', 'VaultController@getItemById');
$router->put('/update-vault', 'VaultController@update');
$router->delete('/delete-selected-vault-item/{itemId}', 'VaultController@destroy');
$router->put('/move-folder', 'VaultController@moveFolder');
$router->get('/search/{searchInp}', 'VaultController@search');
$router->get('/export', 'VaultController@export');
$router->post('/import', 'VaultController@import');









