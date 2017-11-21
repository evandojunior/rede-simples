<?php

$global = (object) [
    "connection" => (object)[
        "host" => "mysqlhost",
        "port" => "3306",
        "default_database" => "project_rede_simples",
        "username" => "root",
        "password" => "root",
        "charset" => "utf8"
    ],
    "project" => (object)[
        "host" => "http://redesimples.prod/",
        "debug" => true,
        "home" => "/corporativo/servicos/bbhive/index.php",
        "rootPath" => __DIR__ . "/.."
    ]
];

ini_set("display_errors", $global->project->debug);

if (!isset($_SESSION)) { 
	session_start();
}