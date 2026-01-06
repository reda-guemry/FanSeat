<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/database.php';
require_once __DIR__ . '/define.php';
require_once __DIR__ . '/../classes/admine.php';
require_once __DIR__ . '/../classes/user.php';
require_once __DIR__ . '/../classes/organizer.php';
require_once __DIR__ . '/../classes/matchGame.php';
require_once __DIR__ . '/../classes/acheuteur.php';
require_once __DIR__ . '/../classes/autentification.php';
require_once __DIR__ . '/../classes/category.php';
require_once __DIR__ . '/../classes/ticket.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
