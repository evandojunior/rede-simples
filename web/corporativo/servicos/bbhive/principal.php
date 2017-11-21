<?php 

if(!isset($_SESSION)){ session_start(); }

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//apaga busca avançada
if(isset($_SESSION['consultaAvancada'])){ unset($_SESSION['consultaAvancada']); };

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página principal do sistema - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  
if(!isset($_SESSION)){ session_start(); } 
 if($_SESSION['acesso']==1){
	$query_Procedimentos = "select bbh_perfil.bbh_per_codigo, bbh_usu_codigo, 
      round(sum(bbh_per_fluxo)) as bbh_per_fluxo, 
      round(sum(bbh_per_mensagem)) as bbh_per_mensagem,
      round(sum(bbh_per_arquivos)) as bbh_per_arquivos,
      round(sum(bbh_per_equipe)) as bbh_per_equipe,
      round(sum(bbh_per_tarefas)) as bbh_per_tarefas,
      round(sum(bbh_per_relatorios)) as bbh_per_relatorios,
      round(sum(bbh_per_protocolos)) as bbh_per_protocolos
    from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                     group by bbh_usu_codigo";
     list($Procedimentos, $row_Procedimentos, $totalRows_Procedimentos) = executeQuery($bbhive, $database_bbhive, $query_Procedimentos);
	
	//PERMISSÃO DE PROTOCOLOS
	$Protocolo="";
	if($row_Procedimentos['bbh_per_protocolos']>=1){
		$Protocolo = 1;
	} else {
		$Protocolo = 0;
	}
	//barra personalizada
	require_once('includes/barra_personalizada.php');
} ?>