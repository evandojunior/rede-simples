<?php
// Config global
include(__DIR__ . "/../../database/globalConfig.php");

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bbpass = sprintf("%s:%s", $global->connection->host, $global->connection->port);
$database_bbpass = $global->connection->default_database;
$username_bbpass = $global->connection->username;
$password_bbpass = $global->connection->password;

$bbpass = mysqli_connect($global->connection->host, $global->connection->username, $global->connection->password, $global->connection->default_database, $global->connection->port);
mysqli_set_charset($bbpass, $global->connection->charset);

if (mysqli_connect_errno()) {
    exit(printf("Connect failed: %s\n", mysqli_connect_error()));
}

//Código do lock Login e Senha, utilizado no console público SOMENTE NO BBPASS
$_SESSION['idLockLoginSenha'] = "11";

//ID da aplicação que esta sendo monitorada pelo policy
$_SESSION['IdAplic'] = "10";

//gerenciamento geral padrão para pacote Blackbee
include("setup.php");
?>
