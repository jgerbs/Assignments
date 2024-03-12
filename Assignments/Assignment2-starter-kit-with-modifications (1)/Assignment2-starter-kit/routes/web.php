<?php

use core\Router;

use src\Controllers\ArticleController;
use src\Controllers\LoginController;
use src\Controllers\LogoutController;
use src\Controllers\RegistrationController;
use src\Controllers\SettingsController;

Router::get('/', [ArticleController::class, 'renderIndexPage']); // the root/index page

Router::get('/about', [ArticleController::class, 'about']);

// User/Auth related

Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'login']);

Router::get('/register', [RegistrationController::class, 'index']); // show registration form.
Router::post('/register', [RegistrationController::class, 'register']); // process a registration req.

Router::post('/logout', [LogoutController::class, 'logout']);

Router::post('/upload_image', [SettingsController::class, 'uploadImage']);

// Article

Router::get('/articles/create', [ArticleController::class, 'create']);

Router::get('/articles/store', [ArticleController::class, 'index']);
Router::post('/articles/store', [ArticleController::class, 'store']);

// Show the form for editing an article
Router::get('/articles/edit', [ArticleController::class, 'edit']);

// Process the editing of an article
Router::post('/articles/update', [ArticleController::class, 'update']);

// Process the deleting of an article
Router::get('/articles/delete', [ArticleController::class, 'delete']);

// Settings

// Show the user settings page
Router::get('/settings', [SettingsController::class, 'index']);

// Process the update of user settings
Router::post('/settings/update', [SettingsController::class, 'update']);;