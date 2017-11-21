<?php if(!isset($_SESSION)){session_start();}
	require_once("includes/autenticacao/index.php");
	
	//verifica na sessão se o lock está liberado
	include($_SESSION['caminhoFisico']."/servicos/bbpass/credencial/gerencia_credencial/gerencia.php");
	require_once("credencial/gerencia_credencial/verifica_locks.php");
?>
<?php require_once("perfil/index.php"); ?>
<?php require_once("aplicacao/index.php"); ?>

<div id="listaLogs" style="margin-top:-3px;">
<?php require_once("perfil/log.php"); ?>
</div>
<label style="display:none" id="loadMenu"></label>