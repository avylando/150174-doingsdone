<?php

require_once 'config/db.php';
require_once 'functions.php';

session_start();

$db_link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['name']);
mysqli_set_charset($db_link, 'utf-8');
