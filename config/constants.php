<?php
// config/constants.php

// Application setup
define('APP_NAME', 'Selling.');
define('BASE_URL', 'http://localhost:8000'); // Will run on PHP dev server

// Directories
define('ROOT_DIR', dirname(__DIR__));
define('VIEWS_DIR', ROOT_DIR . '/views');
define('MODELS_DIR', ROOT_DIR . '/models');
define('CONTROLLERS_DIR', ROOT_DIR . '/controllers');
define('UPLOAD_DIR', ROOT_DIR . '/uploads');

// Create upload directory if it doesn't exist
if (!file_exists(UPLOAD_DIR . '/products')) {
    mkdir(UPLOAD_DIR . '/products', 0777, true);
}
