<?php
// Config global
include(__DIR__ . "/../../database/globalConfig.php");

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_policy = sprintf("%s:%s", $global->connection->host, $global->connection->port);
$database_policy = $global->connection->default_database;
$username_policy = $global->connection->username;
$password_policy = $global->connection->password;

$policy = mysqli_connect($global->connection->host, $global->connection->username, $global->connection->password, $global->connection->default_database, $global->connection->port);
mysqli_set_charset($policy, $global->connection->charset);

if (mysqli_connect_errno()) {
    exit(printf("Connect failed: %s\n", mysqli_connect_error()));
}

//ID DA APLICAÇÃO CADASTRADA NO BBPASS, VARIÁVEL INDIVIDUAL
$idAplicacaoBBPASS = "13";

//gerenciamento geral padrão para pacote Blackbee
include("setup.php");
?>
