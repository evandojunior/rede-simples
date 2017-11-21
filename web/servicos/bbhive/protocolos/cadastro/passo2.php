<?php if(!isset($_SESSION)){ session_start(); } 
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");
	include($_SESSION['caminhoFisico']."/servicos/bbhive/protocolos/cadastro/detalhamento/includes/functions.php");
	
	foreach($_GET as $indice=>$valor){
		//Digitalização
		if(($indice=="amp;confirmaDigitalizacao")||($indice=="confirmaDigitalizacao")){	$confirmaDigitalizacao= $valor; } 
		if(($indice=="amp;naoDigitalizacao")||($indice=="naoDigitalizacao")){	$naoDigitalizacao= $valor; } 
		//--
		
		//Indicios
		if(($indice=="amp;confirmaCadastroIndicios")||($indice=="confirmaCadastroIndicios")){	$confirmaCadastroIndicios= $valor; } 
		if(($indice=="amp;naoCadastroIndicios")||($indice=="naoCadastroIndicios")){	$naoCadastroIndicios= $valor; } 
		//--
		
		//Impressão
		if(($indice=="amp;confirmaImpressao")||($indice=="confirmaImpressao")){	$confirmaImpressao= $valor; } 
		if(($indice=="amp;naoImpressao")||($indice=="naoImpressao")){	$naoImpressao= $valor; } 
		//--
		if(($indice=="amp;edita")||($indice=="edita")){	$edita= $valor; } 
	}

	//****VERIFICO DE O XML EXISTE, CASO O MESMO NÃO EXISTA CRIO ELE NO ADMINISTRATIVO, 
	//POIS VOU REDIRECIONAR PARA O OK.PHP
	$arquivo = "../../../../datafiles/servicos/bbhive/setup/config.xml";
	
		if(!file_exists($arquivo)){
			header("ok.php");
			exit;
		}
	//SEGUINDO A SEQUÊNCIA DAS INFORMAÇÕES
		$doc = new DOMDocument("1.0", "iso-8859-1"); 
		$doc->preserveWhiteSpace = false; //descartar espacos em branco    
		$doc->formatOutput = false; //gerar um codigo bem legivel   
		$doc->load($arquivo);
		//-----	
		$root = $doc->getElementsByTagName("config")->item(0);
		$prot = $root->getElementsByTagName("protocolo")->item(0);
		//-----
		$digitalizar 	= $prot->getAttribute("digitalizar");
		$indicios 		= $prot->getAttribute("indicios");
		$imprimir 		= $prot->getAttribute("imprimir");
		//$detalhamento 	= $prot->getAttribute("detalhamento");
		//$detalhamento_co= $prot->getAttribute("detalhamento_central_objetos");
		
			/*if($digitalizar=="dig_sempre" && (!isset($naoDigitalizacao) && !isset($naoCadastroIndicios) && !isset($naoImpressao))){
				$confirmaDigitalizacao=true;
			}
			if($indicios=="ind_sempre" && (!isset($naoDigitalizacao) && !isset($naoCadastroIndicios) && !isset($naoImpressao))){
				$confirmaCadastroIndicios=true;
			}
			if($imprimir=="imp_sempre" && (!isset($naoDigitalizacao) && !isset($naoCadastroIndicios) && !isset($naoImpressao))){
				$confirmaImpressao=true;
			}*/

?>
<?php require_once("../includes/cabecaProtocolo.php"); ?>
<br>
<?php
if($codSta=="1"){
	//PRIMEIRO VERIFICAR DADOS DE DIGITALIZAÇÃO===============================================
	if($digitalizar != "dig_nunca"){
		if(!isset($confirmaDigitalizacao) && !isset($naoDigitalizacao) && $digitalizar == "dig_perguntar" && !isset($confirmaCadastroIndicios) && !isset($naoCadastroIndicios) && !isset($confirmaImpressao) && !isset($naoImpressao)){
			require_once("../digitalizar/pergunta.php");
			exit;	
		} elseif((isset($confirmaDigitalizacao) || $digitalizar == "dig_sempre") && !isset($naoDigitalizacao) && !isset($naoCadastroIndicios) && !isset($confirmaImpressao) && !isset($naoImpressao)){
			require_once("../digitalizar/digitalizar.php");
			exit;
		}
	}
	//SEGUNDO VERIFICAR DADOS DE INDÍCIOS======================================================
	if($indicios != "ind_nunca"){
		if(!isset($confirmaCadastroIndicios) && !isset($naoCadastroIndicios) && $indicios == "ind_perguntar" && !isset($confirmaImpressao) && !isset($naoImpressao) && !isset($confirmaImpressao) && !isset($naoImpressao)){
			require_once("../indicios/pergunta.php");
			exit;	
		} elseif((isset($confirmaCadastroIndicios) || $indicios == "ind_sempre") && !isset($naoCadastroIndicios) && !isset($confirmaImpressao) && !isset($naoImpressao)){
			/*echo "Aguarde redirecionando...";
			?>
            <var style="display:none">
            	location.href="/servicos/bbhive/protocolos/gerenciamento_objetos/index.php";
            </var>
            <?php*/
			require_once("../indicios/cadastrar.php");
			exit;
		}
	}
}

	//TERCEIRO VERIFICAR IMPRESSÃO============================================================
	if($imprimir != "imp_nunca"){
		if(!isset($confirmaImpressao) && !isset($naoImpressao) && $imprimir == "imp_perguntar"){
			require_once("../imprime/pergunta.php");
			exit;
		}elseif(isset($confirmaImpressao) || $imprimir == "imp_sempre"){
			require_once("../imprime/imprime.php");
			exit;
		}
	}

	//NÃO ACONTECEU NADA IREI REDIRECIONAR
	if(isset($edita)){
	?>
    <var style="sdisplay:none">LoadSimultaneo('protocolos/regra.php','conteudoGeral');</var>
	<?php } ?>
<input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/voltar.gif);background-repeat:no-repeat;background-position:left;height:23px;width:200px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar2" value="&nbsp;Voltar para p&aacute;gina principal" onClick="LoadSimultaneo('protocolos/regra.php','conteudoGeral')"/>
<input name="cadastrar2" style="background:url(/servicos/bbhive/images/pesquisar.gif);background-repeat:no-repeat;background-position:left;height:23px;width:150px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Visualizar protocolo" onclick="showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/ok.php?consulta=true','colPrincipal')"/>
