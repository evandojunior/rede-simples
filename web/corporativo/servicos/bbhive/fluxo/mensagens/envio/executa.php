<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");

//INSERÇÃO
if(isset($_POST['MM_EnviaMensagem'])){
	//recupera dados
	$bbh_men_data_recebida 	= date('Y-m-d H:i:s');//momento do envio
	$bbh_usu_codigo_remet	= $_SESSION['usuCod'];
	$bbh_usu_codigo_destin	= $_POST['bbh_usu_destino'];
	$bbh_men_assunto		= ($_POST['bbh_men_assunto']);
	$bbh_men_mensagem		= ($_POST['bbh_men_mensagem']);
	$codigoFluxo			= $_POST['bbh_flu_codigo'];
	$bbh_flu_codigo			= isset($_POST['bbh_flu_codigo']) ? ",".$_POST['bbh_flu_codigo'] : "";
	$cp_flu_codigo			= isset($_POST['bbh_flu_codigo']) ? ",bbh_flu_codigo" : "";
	
	$insertSQL = "INSERT INTO bbh_mensagens (bbh_men_data_recebida, bbh_usu_codigo_remet, bbh_usu_codigo_destin, bbh_men_assunto, bbh_men_mensagem $cp_flu_codigo) VALUES ('$bbh_men_data_recebida', $bbh_usu_codigo_remet, $bbh_usu_codigo_destin, '$bbh_men_assunto', '$bbh_men_mensagem' $bbh_flu_codigo)";

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

}

//EXCLUSÃO DA CAIXA DE ENTRADA E SAÍDA
if(isset($_POST['MM_exclusao'])){
//Recupera ID da mensagem e ID do destinatário
	$cadaMensagem  = explode(",",$_POST['lixo']);
	$todasMensagem = count($cadaMensagem);
	$codigoFluxo	= $_POST['bbh_flu_codigo'];
	
	$codTodasMensagens = '';
	
	for($x=0; $x<$todasMensagem; $x++){
		$mensagem 	 	 = explode("|",$cadaMensagem[$x]);
		
		$codMensagem 	 = $mensagem[0]; // recupera o código da mensagem
		$codDestinatario = $mensagem[1]; // recupera código do destinatário
		$codRemetente	 = $mensagem[2]; // recupera código do remetente
		
		$codTodasMensagens .= $codMensagem[0] . ',';
		
		if($codDestinatario == $_SESSION['usuCod'] && $codRemetente == $_SESSION['usuCod']){
			//faz update com base no destinatário e remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 1, bbh_men_exclusao_remetente = 1 WHERE bbh_men_codigo = $codMensagem";
		} elseif($codDestinatario == $_SESSION['usuCod']){
			//faz update com base no destinatário
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 1 WHERE bbh_men_codigo = $codMensagem";
		} else {
			//faz update com base no remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_remetente = 1 WHERE bbh_men_codigo = $codMensagem";
		}

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1.1";
	$Evento="Efetuou a exclusão de mensagem(s) (" . substr($codTodasMensagens,0,strlen($codTodasMensagens)-1) . ") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	
}


//EXCLUSÃO PELA MENSAGEM
if(isset($_POST['deleteMessage'])){
	//recupera dados
	$bbh_usu_codigo_destin	= $_POST['bbh_usu_codigo_destin'];
	$bbh_men_codigo			= $_POST['bbh_men_codigo'];
	$bbh_usu_codigo_remet	= $_POST['bbh_usu_codigo_remet'];
	$codigoFluxo			= $_POST['bbh_flu_codigo'];
	
	if($bbh_usu_codigo_destin == $_SESSION['usuCod'] && $bbh_usu_codigo_remet == $_SESSION['usuCod']){
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 1, bbh_men_exclusao_remetente = 1 WHERE bbh_men_codigo = $bbh_men_codigo";
	} elseif($bbh_usu_codigo_destin == $_SESSION['usuCod']){
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 1 WHERE bbh_men_codigo = $bbh_men_codigo";
	} else {
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_remetente = 1 WHERE bbh_men_codigo = $bbh_men_codigo";
	}

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
  
}

//EXCLUSÃO PELA MENSAGEM, QUANDO ELA JÁ ESTÁ NA LIXEIRA
if(isset($_POST['MM_delete2'])){
	//recupera dados
	$bbh_usu_codigo_destin	= $_POST['bbh_usu_codigo_destin'];
	$bbh_men_codigo			= $_POST['bbh_men_codigo'];
	$bbh_usu_codigo_remet	= $_POST['bbh_usu_codigo_remet'];
	$codigoFluxo			= $_POST['bbh_flu_codigo'];
	
	if($bbh_usu_codigo_destin == $_SESSION['usuCod'] && $bbh_usu_codigo_remet == $_SESSION['usuCod']){
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 2, bbh_men_exclusao_remetente = 2 WHERE bbh_men_codigo = $bbh_men_codigo";
	} elseif($bbh_usu_codigo_destin == $_SESSION['usuCod']){
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 2 WHERE bbh_men_codigo = $bbh_men_codigo";
	} else {
		$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_remetente = 2 WHERE bbh_men_codigo = $bbh_men_codigo";
	}

    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
  $Msg = "A mensagem foi removida com sucesso!";
}

//EXCLUSÃO DEFINITIVA
if(isset($_POST['MM_exdefinitivo'])){
//Recupera ID da mensagem e ID do destinatário
	$cadaMensagem  = explode(",",$_POST['lixo']);
	$todasMensagem = count($cadaMensagem);
	$codigoFluxo   = $_POST['bbh_flu_codigo'];
	
	$codTodasMensagens = '';
	
	for($x=0; $x<$todasMensagem; $x++){
		$mensagem 	 	 = explode("|",$cadaMensagem[$x]);
		
		$codMensagem 	 = $mensagem[0]; // recupera o código da mensagem
		$codDestinatario = $mensagem[1]; // recupera código do destinatário
		$codRemetente	 = $mensagem[2]; // recupera código do remetente

		$codTodasMensagens .= $codMensagem[0] . ',';

		if($codDestinatario == $_SESSION['usuCod'] && $codRemetente == $_SESSION['usuCod']){
			//faz update com base no destinatário e remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 2, bbh_men_exclusao_remetente = 2 WHERE bbh_men_codigo = $codMensagem";
		} elseif($codDestinatario == $_SESSION['usuCod']){
			//faz update com base no destinatário
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 2 WHERE bbh_men_codigo = $codMensagem";
		} else {
			//faz update com base no remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_remetente = 2 WHERE bbh_men_codigo = $codMensagem";
		}

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}	

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Efetuou a exclusão definitiva de mensagem(s) (" . substr($codTodasMensagens,0,strlen($codTodasMensagens)-1) . ") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/

  $Msg = "A mensagem foi removida com sucesso!";

}

//RESTAURA MENSAGEM
if(isset($_GET['restaura'])){
//Recupera ID da mensagem e ID do destinatário
	$cadaMensagem   = explode(",",$_POST['lixo']);
	$todasMensagem  = count($cadaMensagem);
	$codigoFluxo	= $_POST['bbh_flu_codigo'];

	for($x=0; $x<$todasMensagem; $x++){
		$mensagem 	 	 = explode("|",$cadaMensagem[$x]);
		
		$codMensagem 	 = $mensagem[0]; // recupera o código da mensagem
		$codDestinatario = $mensagem[1]; // recupera código do destinatário
		$codRemetente	 = $mensagem[2]; // recupera código do remetente
		
		if($codDestinatario == $_SESSION['usuCod'] && $codRemetente == $_SESSION['usuCod']){
			//faz update com base no destinatário e remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 0, bbh_men_exclusao_remetente = 0 WHERE bbh_men_codigo = $codMensagem";
		} elseif($codDestinatario == $_SESSION['usuCod']){
			//faz update com base no destinatário
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_destinatario = 0 WHERE bbh_men_codigo = $codMensagem";
		} else {
			//faz update com base no remetente
			$updateSQL = "UPDATE bbh_mensagens SET bbh_men_exclusao_remetente = 0 WHERE bbh_men_codigo = $codMensagem";
		}

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	}	

  $Msg = "A mensagem foi restaurada com sucesso!";

}
//retorno automático
?>
<var style="display:none">showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $_POST['bbh_flu_codigo']; ?>&exibeMensagem=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $_POST['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
</var>