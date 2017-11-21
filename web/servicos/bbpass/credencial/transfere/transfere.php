<?php
require_once("../../includes/autenticacao/index.php");

require_once("http/envia.php");
//recupera dados da aplicação
$idAplicacao = $_GET['id'];

//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include("../../aplicacao/gerencia_aplicacao.php");

$aplicacao	= new Aplicacao($database_bbpass, $bbpass);
$aplicacao->dadosAplicacao($database_bbpass, $bbpass, $idAplicacao);

echo transfereLogon($aplicacao->bbp_adm_apl_url);