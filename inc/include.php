<?php

use Inc\Auth;
use Inc\DBConnection;

require_once __DIR__ . '/class.db.php';
require_once __DIR__ . '/class.auth.php';
require_once __DIR__ . '/class.xss.php';
require_once __DIR__ . '/class.template.php';
require_once __DIR__ . '/class.validate.php';

# Database Initializaition
# Change with the required credentials
$hostname = 'localhost';
$username = 'root';
$password = 'cakadi1902';
$database = 'db_siperpus';

$db   = new DBConnection($hostname, $username, $password, $database);
$auth = new Auth($db->getConnection());