<?php

// Force error display before Laravel boots
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// Load Laravel through the public entry point
// __DIR__ inside public/index.php will still resolve to public/ so all relative paths work
require __DIR__.'/public/index.php';
