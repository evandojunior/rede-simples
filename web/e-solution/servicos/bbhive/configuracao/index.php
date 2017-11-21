<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
require_once("../fluxos/modelosFluxos/detalhamento/includes/functions.php");

//recuperaÃ§Ã£o de variÃ¡veis do GET e SESSÃO
foreach($_GET as $indice => $valor){
	if(($indice=="amp;aba")||($indice=="aba")){ $aba=$valor; }
}

//se eu nÃ£o tiver o config.xml eu crio
$arquivo = $_SESSION['caminhoFisico']."/datafiles/servicos/bbhive/setup/";
//-------------------------------------------

$dirEt 		= explode("web",str_replace("\\","/", strtolower(dirname(__FILE__))));
$etiquetas 	= $dirEt[0]."database/servicos/bbhive/etiqueta.xml";


if (isset($_GET['testeComunicacaoRedeSimples'])) {
    require_once __DIR__ . "/../../../../servicos/bbhive/protocolos/execucao_automatica/redeSimples/comunicacaoRedeSimples.php";

    $color = $resCommunicacaoRedeSimples === true ? "green" : "red";
    $response = $resCommunicacaoRedeSimples === true ? "Comunicação bem sucedida!" : preg_replace("/\r|\n/", "", str_replace("\"", "`", $resCommunicacaoRedeSimples));
    echo "<var style='display:none'>
			document.getElementById('resComunicacaoRedeSimples').style.color = '".$color."';
			document.getElementById('resComunicacaoRedeSimples').innerHTML = \"".$response."\";
		  </var>";
    exit;
}

if(isset($_POST['updateProtocolo'])){
	//recupera dados de configuraÃ§Ã£o do protocolo
	$digitalizar 		= $_POST['digitalizar'];
	$indicios 			= $_POST['indicios'];
	$imprimir 			= $_POST['imprimir'];
	$mensagens_com_fluxo= $_POST['mensagens_com_fluxo'];
//	$detalhamento		= $_POST['detalhamento'];
	$aposReceber		= $_POST['aposreceber'];
	unlink($arquivo."config.xml");
	//-------------------------------------------
		if(!file_exists($arquivo."config.xml")){
			//crio o primeiro elemento
			$doc = new DOMDocument("1.0", "iso-8859-1"); 
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel    
			$root = $doc->createElement("config"); //cria o 1 no, todos os nos vao ser inseridos nesse
			$doc->appendChild($root);
			
			//crio o nÃ³ contendo a imagem
			$prot =  $doc->createElement('protocolo');
			$prot->setAttribute("digitalizar", $digitalizar);
			$prot->setAttribute("indicios", $indicios);
			$prot->setAttribute("imprimir", $imprimir);
			$prot->setAttribute("mensagens_com_fluxo", $mensagens_com_fluxo);
			//$prot->setAttribute("detalhamento", $detalhamento);
			$prot->setAttribute("aposreceber",$aposReceber);
			$root->appendChild($prot);
			//-----	
			$doc->appendChild($root);
			//salvo o xml
			$doc->save($arquivo."config.xml");
		} else {//atualiza
			$doc = new DOMDocument("1.0", "iso-8859-1"); 
			$doc->preserveWhiteSpace = false; //descartar espacos em branco    
			$doc->formatOutput = false; //gerar um codigo bem legivel   
			$doc->load($arquivo."config.xml");
			//-----	
			$root = $doc->getElementsByTagName("config")->item(0);
			$prot = $root->getElementsByTagName("protocolo")->item(0);
			//-----	
			$prot->setAttribute("digitalizar",$_POST['digitalizar']);
			$prot->setAttribute("indicios",$_POST['indicios']);
			$prot->setAttribute("imprimir",$_POST['imprimir']);
			$prot->setAttribute("mensagens_com_fluxo", $_POST['mensagens_com_fluxo']);
			//$prot->setAttribute("detalhamento", $_POST['detalhamento']);
	 		$prot->setAttribute("aposreceber",$aposReceber);
			$root->appendChild($prot);
			//-----	
			$doc->appendChild($root);
			//salvo o xml
			$doc->save($arquivo."config.xml");
		}
//echo "<var style='display:none'>showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php','menuEsquerda|colCentro');</var>";
exit;
}

if(isset($_POST['updateEtiqueta'])){
	//recupera dados de configuraÃ§Ã£o da etiqueta
	$cabecalho 	= $_POST['cabecalho'];
	$rodape		= $_POST['rodape'];
	//-------------------------------------------
	if(!file_exists($etiquetas)){
		//crio o primeiro elemento
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel    
		$root = $doc->createElement("etiqueta"); //cria o 1 no, todos os nos vao ser inseridos nesse
		$doc->appendChild($root);
		
		//crio o nÃ³ contendo a imagem
		$et =  $doc->createElement('info');
		$et->setAttribute("cabecalho", "");
		$et->setAttribute("rodape", "");
		$et->setAttribute("inicio", "1");
		$root->appendChild($et);
		//-----	
		$doc->appendChild($root);
		//salvo o xml
		$doc->save($etiquetas);
	} else {
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($etiquetas);
		//-----	
		$root = $doc->getElementsByTagName("etiqueta")->item(0);
		$et   = $root->getElementsByTagName("info")->item(0);
		//-----	
		$et->setAttribute("cabecalho",$cabecalho);
		$et->setAttribute("rodape",$rodape);
		$root->appendChild($et);
		//-----	
		$doc->appendChild($root);
		//salvo o xml
		$doc->save($etiquetas);
			
			echo "InformaÃ§Ãµes atualizadas com sucesso!!!";
	}
	
	echo "<var style='display:none'>
			document.getElementById('msgNovo').style.display='none';
			document.getElementById('msgCabeca').style.display='block';
		  </var>";
	exit;
}


$mensagem='Clique nas imagens para ampliar<br>
      <img src="/e-solution/servicos/bbhive/images/alerta.gif">
      Aten&ccedil;&atilde;o: ao trocar qualquer imagem, exclua as imagens armazenadas em seu navegador.';
?>
<var style="display:none">txtSimples('tagPerfil', 'Configura&ccedil;&otilde;es')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Imagens e configura&ccedil;&otilde;es</td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" id="loadMsg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>

<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0"><?php echo $_SESSION['adm_protNome']; ?></li>
    <li class="TabbedPanelsTab" tabindex="0">Lista Din&acirc;mica</li>
    <li class="TabbedPanelsTab" tabindex="0">Detalhamento - <?php echo $_SESSION['adm_protNome']; ?></li>
    <li class="TabbedPanelsTab" tabindex="0">Detalhamento - <?php echo $_SESSION['adm_componentesNome']; ?></li>
    <li class="TabbedPanelsTab" tabindex="0">SMTP</li>
    <li class="TabbedPanelsTab" tabindex="0">Etiquetas</li>
    <li class="TabbedPanelsTab" tabindex="0">Imagens</li>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent"><?php require_once("protocolo.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("lista_dinamica/index.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("detalhamento/index.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("../departamentos/campos_tabela/index.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("dados_smtp.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("etiquetas.php"); ?></div>
    <div class="TabbedPanelsContent"><?php require_once("imagens_sistema.php"); ?></div>
  </div>
</div>

<var style="display:none">
	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</var>


<?php 
if(isset($aba)){
	
	?>
<var style="display:none">
	var Aba = new Spry.Widget.TabbedPanels("TabbedPanels1").showPanel(<?php echo (int)$aba;?>);
</var>
<?php } ?>