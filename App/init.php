<?php

use Dotenv\Dotenv;

//CARREGA ARQUIVO ENV
$dotenv = Dotenv::createUnsafeImmutable(__DIR__.'\\..\\');
$dotenv->load();

/* CONSTANTES DO SISTEMA */
define('PREFIX_DASHBOARD', '/admin');
define('URL_SITE', getenv('URL_SITE'));

define('URL_DEFAULT_TEMPLATE_SISTEMA', '/templates/admin/AdminLTE');
define('URL_DEFAULT_VIEW_SISTEMA', '');
define('URL_DEFAULT_TEMPLATE_SITE', '');
define('URL_DEFAULT_SITE', 'http://' . $_SERVER['HTTP_HOST'] . '/');
define('CHAVE_ONESIGNAL', getenv('CHAVE_ONESIGNAL'));
define('API_REST_ONESIGNAL', getenv('API_REST_ONESIGNAL'));
define('MAPSKEY', getenv('MAPSKEY'));
define('EXCECOES_PAGES', [
    'home',
    'dashboard',
    'index',
    'perfil',
    'uploads'
]);

define('TITULO_SISTEMA', getenv('TITULO_SISTEMA'));
define('LOGO_SISTEMA', getenv('LOGO_SISTEMA'));
define('APP_ENV', getenv('APP_ENV'));

define('HOST', getenv('HOST'));
define('DRIVER', getenv('DRIVER'));
define('DATABASE', getenv('DATABASE'));
define('USERNAME', getenv('USER_DB'));
define('PASSWORD', getenv('PASS_DB'));
define('PORT', getenv('PORT'));

define('EMAIL_SMTP', getenv('EMAIL_SMTP'));
define('EMAIL_USER', getenv('EMAIL_USER'));
define('EMAIL_SENHA', getenv('EMAIL_SENHA'));
define('EMAIL_SSL', getenv('EMAIL_SSL'));
define('EMAIL_PORT', getenv('EMAIL_PORT'));
