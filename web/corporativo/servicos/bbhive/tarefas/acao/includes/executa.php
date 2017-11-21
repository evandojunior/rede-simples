<?php
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");

require_once('functionsAtividades.php');

//clique da caixa de mensagem
$onClick= "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');";
	
//Adiciona comentários
if(isset($_GET['addComentario'])){
	atualizaXML($_POST['bbh_ati_codigo'], $_POST['bbh_comentario']);
}

//atualiza status
if(isset($_GET['addStatus'])){
	$status 			= explode("|",$_POST['bbh_sta_ati_codigo']);
	$bbh_sta_ati_codigo = $status[0];
	$nmStatus			= $status[1];
	
		$updateSQL = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=$bbh_sta_ati_codigo WHERE bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
	$comentario = "O profissional mudou o status para ".$nmStatus;
	atualizaXML($_POST['bbh_ati_codigo'], $comentario);
	
//atualiza status
	echo "<var style='display:none'>document.getElementById('bbh_sta_ati_codigo').value='".$bbh_sta_ati_codigo."|".$nmStatus."'</var>";
}

//finaliza atividade a partir da sequência
if(isset($_GET['endAtividade'])){
	//descobre qual é o fluxo
	$query_Fluxo = "select f.bbh_flu_codigo, f.bbh_protocolo_referencia from bbh_atividade as a
                        inner join bbh_fluxo f on a.bbh_flu_codigo = f.bbh_flu_codigo
                     where a.bbh_ati_codigo = ".$_POST['bbh_ati_codigo'];
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	$codFluxo = $row_Fluxo['bbh_flu_codigo'];	
	$codProtocoloReferencia = $row_Fluxo['bbh_protocolo_referencia'];

	//verifico se esta atividade é a atividade final do fluxo
	if($_GET['finalFluxo']==1){
		//atualizo flegando o fluxo para finalizado
		$updateSQL2 = "UPDATE bbh_fluxo SET bbh_flu_finalizado='1' WHERE bbh_flu_codigo = $codFluxo";
        list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL2);

		//----muda status do protocolo
		$updateSQL = "UPDATE bbh_protocolos SET bbh_pro_status='5' WHERE bbh_flu_codigo = $codFluxo";
        list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

        //----muda status do protocolo
        if (!empty($codProtocoloReferencia)) {
            $updateSQL = "UPDATE bbh_protocolos SET bbh_pro_status='5' WHERE bbh_pro_codigo = {$codProtocoloReferencia}";
            list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
        }
	}

	//atualizo todos os relatórios com esta atividade
		$updateSQL2 = "UPDATE bbh_relatorio SET bbh_rel_finalizado='1' WHERE bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
        list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL2);
	//---

	$updateSQL = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=2, bbh_ati_final_real='".date("Y-m-d")."' WHERE bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	$comentario = "Atividade finalizada por decisão do profissional.";
	atualizaXML($_POST['bbh_ati_codigo'], ($comentario));

	//redireciona para página de fluxos
	echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$codFluxo."&exibeAtividade=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$codFluxo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');</var>";
	//==================================

	//redireciona para página inicial das tarefas
	/*$barraTitulo 	= '&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12">&nbsp;&nbsp;&nbsp;Confirma&ccedil;&atilde;o';
	$mensagem		= 'Este procedimento foi finalizado com sucesso!';
	$icone			= "05_.gif";
	$ajustes		= "margin-left:-150px; margin-top:-10px;";
	//chama caixa de mensagens
	require_once('caixaMensagem.php');*/
}

if(isset($_GET['openAtividade'])){
	//descobre qual é o fluxo
	$query_Fluxo = "SELECT bbh_flu_codigo FROM bbh_atividade WHERE bbh_ati_codigo =".$_POST['bbh_ati_codigo'];
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	$codFluxo = $row_Fluxo['bbh_flu_codigo'];	
	

	//atualizo todos os relatórios com esta atividade
		$updateSQL2 = "UPDATE bbh_relatorio SET bbh_rel_finalizado='0' WHERE bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
        list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL2);
	//---

	$updateSQL = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=1, bbh_ati_final_real=NULL WHERE bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	$comentario = "Atividade reaberta por decisão do superior.";
	atualizaXML($_POST['bbh_ati_codigo'], ($comentario));

	//redireciona para página de fluxos
	echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$codFluxo."&exibeAtividade=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$codFluxo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');</var>";
	//==================================
}

//ação de atribuição para outro profissional
if(isset($_GET['atrProf'])){
	//recupera dados do novo profissional
	$dados = explode("|",$_GET['profissional']);
	$nvProf= $dados[0];
	$nmProf= $dados[1];
	$dpProf= $dados[2];

	if($_SESSION['sexoUsuario']=="1"){
		$profissional = "O profissional ";
		$compl		  = " o sr. ";
	} else {
		$profissional = "A profissional ";
		$compl		  = " a srª ";
	}
	//qual departamento sou
	$query_dados = "SELECT bbh_dep_nome FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
    list($dados, $row_dados, $totalRows_dados) = executeQuery($bbhive, $database_bbhive, $query_dados);
	
	$comentario = $profissional.$_SESSION['usuNome']." do departamento ".$row_dados['bbh_dep_nome']." atribuiu esta atividade para ".$compl.$nmProf . " do departamento ".$dpProf;
	
	$updateSQL = "UPDATE bbh_atividade SET bbh_usu_codigo=$nvProf WHERE bbh_ati_codigo=".$_GET['bbh_ati_codigo'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	//efetuo update nos dados
	atualizaXML($_GET['bbh_ati_codigo'], $comentario);
	
	//redireciona para página inicial das tarefas
	$barraTitulo 	= '&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12">&nbsp;&nbsp;&nbsp;Confirma&ccedil;&atilde;o';
	$mensagem		= 'Este procedimento foi finalizado com sucesso!';
	$icone			= "05_.gif";
	$ajustes		= "margin-left:-150px; margin-top:-10px;";
	//chama caixa de mensagens
	require_once('caixaMensagem.php');
}