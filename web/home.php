<?php
$homeFile = __DIR__ . "/datafiles/home.html";

if (!file_exists($homeFile)) {
    exit("Home do projeto não configurada, verifique se existe o arquivo 'home.html' em '/datafiles'");
}

echo file_get_contents($homeFile);