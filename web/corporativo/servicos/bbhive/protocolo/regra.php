<?php 
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");


require_once("includes/gerenciaXML.php");

$xml = new XML();//inicia xml

function updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo){
	$updateSQL = "UPDATE bbh_protocolos SET $condicao WHERE bbh_pro_codigo = $bbh_pro_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
}

//RESPONSÁVEL PELA MANIPULAÇÃO DO XML===========================================================================
if(isset($_POST['MM_Update']) && $_POST['MM_Update']=="formProtocolo"){
	$situacao 		= $_POST['acao'];
	$bbh_pro_obs 	= @retiraHTML(apostrofo($_POST['pro_obs']));
	$bbh_pro_codigo	= $_POST['bbh_pro_codigo'];
	$profissional	= ($_SESSION['usuApelido']);
	//abre protocolo pocisionando no campo XML

	$query_strProtocolo = "SELECT bbh_pro_obs from bbh_protocolos Where bbh_pro_codigo = $bbh_pro_codigo";
    list($strProtocolo, $row_strProtocolo, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_strProtocolo);

	$doc = $xml->criaXML();	
	//inicia objeto XML
	if($situacao == "-2"){
		//recupero informações antigas e coloco em única TAG
		$mensagem 	= apostrofo(($row_strProtocolo['bbh_pro_obs']));
		$doc 		= $xml->adicionaDespacho($doc, $profissional, $mensagem);
		$outXML 	= $doc->saveXML();
			//------------------------------------------------------------
			$condicao = "bbh_pro_obs='$outXML'";
			//Grava alteração no XML
			updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
			//------------------------------------------------------------
	} elseif($situacao == "-1"){
		$bbh_flu_codigo = (int)$_POST['bbh_flu_codigo'];
		//verifico se o número existe
			$query_strFluxo = "SELECT bbh_flu_codigo, bbh_flu_finalizado from bbh_fluxo Where bbh_flu_codigo = $bbh_flu_codigo";
            list($strFluxo, $row_strFluxo, $totalRows_strFluxo) = executeQuery($bbhive, $database_bbhive, $query_strFluxo);
				if($totalRows_strFluxo==0){
					echo "<var style='display:none'>alert('Número inexistente.');</var>";
					exit;	
				}
			$mensagem = ("Protocolo anexado a um ".$_SESSION['FluxoNome']." já distribuído");
			//Inicia XML, Grava quem recebeu redireciona para mesma página
			if(!empty($row_strProtocolo['bbh_pro_obs'])){
				$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
				$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
			} else {
				$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
			}
			$outXML = $doc->saveXML();
			$staAcao= $row_strFluxo['bbh_flu_finalizado'] == '1' ? '5' : '4';
			//------------------------------------------------------------
			$condicao = "bbh_pro_status='$staAcao', bbh_flu_codigo=$bbh_flu_codigo, bbh_pro_obs='$outXML'";
			//Grava alteração e novo status para o protocolo, contendo despacho no XML
			updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
			//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']	="0";
		$_SESSION['nivel']		="1";
		$Evento="Anexou protocolo número ($bbh_pro_codigo) ao ".$_SESSION['FluxoNome']." código (".$bbh_flu_codigo.") - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	} elseif($situacao=="0"){
		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $bbh_pro_obs);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $bbh_pro_obs);
		}
		$outXML = $doc->saveXML();
		//------------------------------------------------------------
		$condicao = "bbh_pro_obs='$outXML'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Inseriu despachos no protocolo código (".$bbh_pro_codigo.") - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	} elseif($situacao=="1"){
		$mensagem = ("Protocolo devolvido ao local de origem.");
		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		}
		$outXML = $doc->saveXML();
		//------------------------------------------------------------
		$condicao = "bbh_pro_status='1', bbh_pro_obs='$outXML'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Devolveu protocolo ao local de origem - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
		//REDIRECIONA PARA PÁGINA DE LISTA DE PROTOCOLOS.
		echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');limpaAmbiente()</var>";
		exit;
		//----
	} elseif($situacao=="2"){
		$mensagem = ("Recebeu protocolo com todos os".$_SESSION['componentesNome']." e anexos.");
		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		}
		$outXML = $doc->saveXML();
		//------------------------------------------------------------
		$condicao = "bbh_pro_status='2', bbh_pro_obs='$outXML', bbh_pro_recebido='".$_SESSION['MM_User_email']."', bbh_pro_dt_recebido='".date("Y-m-d H:i:s")."'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Recebeu protocolo com (".$_SESSION['componentesNome'].") e anexos. - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	} elseif($situacao=="5"){
		$mensagem = ("Arquivado.");
        $motivoIndeferimento = isset($bbh_pro_obs) && !empty($bbh_pro_obs) ? $bbh_pro_obs : "Motivo não adicionado";

		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		}
        $doc = $xml->adicionaDespacho($doc, $profissional, $motivoIndeferimento);
		$outXML = $doc->saveXML();
		//------------------------------------------------------------
		$condicao = "bbh_pro_status='5', bbh_pro_obs='$outXML'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Protocolo arquivado código (".$bbh_pro_codigo.") - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	} elseif($situacao=="6"){
		$mensagem = ("Protocolo indeferido.");
		$motivoIndeferimento = isset($bbh_pro_obs) && !empty($bbh_pro_obs) ? $bbh_pro_obs : "Motivo não adicionado";

		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		}
        $doc = $xml->adicionaDespacho($doc, $profissional, $motivoIndeferimento);
		$outXML = $doc->saveXML();

		//------------------------------------------------------------
		$condicao = "bbh_pro_status='6', bbh_pro_obs='$outXML', bbh_pro_recebido='".$_SESSION['MM_User_email']."', bbh_pro_dt_recebido='".date("Y-m-d H:i:s")."'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Inseriu despachos no protocolo código (".$bbh_pro_codigo.") - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
		//REDIRECIONA PARA PÁGINA DE LISTA DE PROTOCOLOS.
		echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');limpaAmbiente()</var>";
		exit;
		//----
	} elseif($situacao=="7"){
		$mensagem = ("Protocolo em situação de aguardando.");
		//Inicia XML, Grava quem recebeu redireciona para mesma página
		if(!empty($row_strProtocolo['bbh_pro_obs'])){
			$doc = $xml->leXML($row_strProtocolo['bbh_pro_obs']);
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		} else {
			$doc = $xml->adicionaDespacho($doc, $profissional, $mensagem);
		}
		$outXML = $doc->saveXML();
		//------------------------------------------------------------
		$condicao = "bbh_pro_status='7', bbh_pro_obs='$outXML'";
		//Grava alteração e novo status para o protocolo, contendo despacho no XML
		updateProtocolo($database_bbhive, $bbhive, $condicao, $bbh_pro_codigo);
		//------------------------------------------------------------
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Protocolo em situação de aguardando para o protocolo código (".$bbh_pro_codigo.") - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	}
	
	//atualiza a página do protocolo
	echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=".$bbh_pro_codigo."','menuEsquerda|conteudoGeral');</var>";
	exit;
}
//**************************************************************************************************************

//recuperação de variáveis do GET e SESSÃO
foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_pro_codigo")||($indice=="bbh_pro_codigo")){ $bbh_pro_codigo = $valor; }
}

	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/protocolo/regra.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'loadForm';
	$infoGet_Post	= 'formProtocolo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	//--
	$gravaDetalhamento = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/detalhamento/grava_dados.php','loadFormDetalhamento','formDetlhamento','".$Mensagem."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;','loadFormDetalhamento','".$Metodo."','".$TpMens."');";

	//--
	$pgProtocolo = true;
	
	//--Verifica se o profissinal logado tem acesso a executar algumas tarefas do protocolo
	$query_permissao = "SELECT bbh_usu_restringir_receb_solicitacao, bbh_usu_restringir_ini_processo FROM bbh_usuario WHERE bbh_usu_codigo =".$_SESSION['usuCod']." limit 1";
    list($permissao, $row_permissao, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_permissao);
	$RestringirSolicitacao = $row_permissao['bbh_usu_restringir_receb_solicitacao'];
	$RestringirProcesso    = $row_permissao['bbh_usu_restringir_ini_processo'];
	//--
?>
<?php require_once("includes/resumo.php"); ?>
<br />
<div id="conteudoDinamico" class="verdana_12">
 <?php require_once("includes/arquivos_digitalizados.php"); ?>
 <br />
 <?php require_once("includes/indicios.php"); ?>
 <br />
 <?php require_once("includes/despacho.php"); ?>
  <br />
 <?php require_once("includes/fluxoRelacionado.php"); ?>
  <br />
 <?php require_once("includes/acao.php"); ?>
</div>