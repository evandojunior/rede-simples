<?php
// Config global
include(__DIR__ . "/../../database/globalConfig.php");

# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_bbhive = $global->connection->host;
$database_bbhive = $global->connection->default_database;
$username_bbhive = $global->connection->username;
$password_bbhive = $global->connection->password;

$bbhive = mysqli_connect($global->connection->host, $global->connection->username, $global->connection->password, $global->connection->default_database, $global->connection->port);
mysqli_set_charset($bbhive, $global->connection->charset);

if (mysqli_connect_errno()) {
    exit(printf("Connect failed: %s\n", mysqli_connect_error()));
}

//var_dump(mysqli_character_set_name($bbhive)); die;

//ID DA APLICAÇÃO CADASTRADA NO BBPASS, VARIÁVEL INDIVIDUAL
$idAplicacaoBBPASS_Administrativo 	= "7";
$idAplicacaoBBPASS_Corporativo 		= "8";
$idAplicacaoBBPASS_Servicos	 		= "9";

//ID da aplicação que esta sendo monitorada pelo policy
$_SESSION['IdAplic'] = "7";

//gerenciamento geral padrão para pacote Blackbee
include("setup.php");

//Variável usada para indicar o caminho de onde estão os arquivos miniaturas (mime-types)
$CaminhoIconesMime = "/datafiles/servicos/bbhive/images/mimes/";
?>
