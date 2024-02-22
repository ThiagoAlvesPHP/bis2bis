<?php
session_start();
error_reporting(E_ALL);
setlocale(LC_TIME, "pt_BR", "pt_BR.utf-8", "portuguese");
date_default_timezone_set('America/Sao_Paulo');
$config = array();
$define = "development";
ini_set("display_errors", ($define == "development") ? "Off" : "On");
define("BASE", "http://localhost/bis2bis/");
$config['host'] = "localhost";
$config['dbname'] = "bis2bis";
$config['dbuser'] = "root";
$config['dbpass'] = "root";

global $db;

try {
    $options = [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"];
    $db = new PDO("mysql:dbname=" . $config['dbname'] . ";host=" . $config['host'], $config['dbuser'], $config['dbpass'], $options);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Falhou " . $e->getMessage();
    exit;
}