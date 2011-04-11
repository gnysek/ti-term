<?php
error_reporting(E_ALL | E_STRICT);

// stałe wykorzystywane przez
define('DS', DIRECTORY_SEPARATOR);
define('EXT', '.php');
define('CORE', realpath(dirname(__FILE__)) . DS);
define('APP', CORE . 'app' . DS);
define('MEDIA', CORE . 'media' . DS);

// załaduj cały silnik
include_once APP . 'kernel.php';
// i nie rób nic wiecej...