<?php
 if(!isset($_SESSION)){ session_start(); }
 //Arquivo de conexão GERAL
 require_once("../../includes/autentica.php");
 
 
 //recuperação de variáveis do GET e SESSÃO
 foreach($_GET as $indice => $valor){
	if(($indice=="amp;tipo")||($indice=="tipo")){ $tipo=$valor; }
	if(($indice=="amp;tagInput")||($indice=="tagInput")){ $tagInput=$valor; }
	if(($indice=="amp;tagIcone")||($indice=="tagIcone")){ $tagIcone=$valor; }
 }
 $bbh_usu_codigo	= $_SESSION['usuCod'];
 
require_once("functions.php");
//= SELEÇÃO POR NOME DE ARQUIVO - TODOS OS ARQUIVOS COMPARTILHADOS E OS MEUS
if($tipo=="bbh_arq_nome_logico"){
	$group		= " GROUP BY bbh_arq_nome_logico ";
	$sqlDinamico 	= $compartilhadoArquivos;
}
//==================================================================================================

// SELEÇÃO POR TITULO DO ARQUIVO - TODOS OS ARQUIVOS COMPARTILHADOS E OS MEUS
if($tipo=="bbh_arq_titulo"){
	$group		= " GROUP BY bbh_arq_titulo ";
	$sqlDinamico 	= $compartilhadoArquivos;
}
//==================================================================================================

// SELEÇÃO POR AUTORES - TODOS OS ARQUIVOS COMPARTILHADOS E OS MEUS
if($tipo=="bbh_arq_autor"){
	$group		= " GROUP BY bbh_arq_autor ";
	$sqlDinamico 	= $compartilhadoArquivos;
}
//==================================================================================================

// SELEÇÃO POR FLUXOS
if($tipo=="bbh_flu_titulo"){
	$group		= " GROUP BY bbh_flu_titulo ";
	$sqlDinamico 	= $compartilhadoArquivos;
}
//==================================================================================================
list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $database_bbhive, $sqlDinamico);
//==================================================================================================

$combo = "&nbsp;N&atilde;o h&aacute; conte&uacute;do a ser exibido. A busca n&atilde;o retornar&aacute; resultados.";
$combo .= "<input type='hidden' name='$tipo' id='$tipo' value=''>";

if($totalRows_arquivos>0){
	$combo  = "&nbsp;<select name='".$tipo."' id=$'".$tipo."' class='formulario2' />";
	do{
		$combo .= "<option value='".$row_arquivos[$tipo]."'>".$row_arquivos[$tipo]."</option>";
	} while($row_arquivos = mysqli_fetch_assoc($arquivos));
	$combo .= "</select>";
}

echo "<var style='display:none'>criaInput('$tipo','$tagInput','$tagIcone')</var>";
echo $combo;
?>