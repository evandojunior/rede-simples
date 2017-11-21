<?php 	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
	require_once("includes/gerencia_politicas.php");
	require_once("includes/gerencia_xml.php");
	

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

/*============================================DELETE==============================================*/
if ((isset($_POST["MM_delete"])) && ($_POST["MM_delete"] == "form1")) {
  //recupera o XML
  $xml 	= new gerenciaXML();
  $conteudo = $xml->leFormatoString($_POST['id_file']);

  //grava os dados no banco
  $deleteSQL = sprintf("DELETE FROM pol_politica WHERE pol_pol_codigo=%s",
                       GetSQLValueString($_POST['pol_pol_codigo'], "int"));

  mysql_select_db($database_policy, $policy);
  $Result1 = mysql_query($deleteSQL, $policy) or die(mysql_error());

	//apaga arquivo
	$xml->removeArquivo($_POST['id_file']);
	
	//altera sessão
	session_regenerate_id();
	
  $insertGoTo = "/e-solution/servicos/policy/politicas/index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

//RECUPERA DADOS DO GET OU SESSÃO
//recupera objeto XML

//XML
$xml 	= new gerenciaXML();
$nmFile = $_GET['id_file'];

if($xml->verificaExiste($nmFile)==0){//só redireciona se não existir
	header("Location: index.php?pol_apl_codigo=".$_GET['pol_apl_codigo']);
	
} else { //leitura
	$doc = $xml->leituraXML($nmFile);
}
//$xml->exibeTela($doc);
//exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="../includes/boxover.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
<script type="text/javascript">
function Popula(valor){
		document.getElementById(valor).className = "ativo";
}

function Desativa(valor){
		document.getElementById(valor).className = "comum";
}
</script>
</head>

<body >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:25px;">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><?php require_once('../includes/cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="20" bgcolor="#FFFFFF"><?php require_once('../includes/menu_horizontal.php'); ?></td>
      </tr>
      <tr>
        <td height="22" align="right" valign="top" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
      </tr>
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Cadastro de Pol&iacute;ticas</strong></td>
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11"><span class="verdana_11_bold"><a href='#' onclick="javascript:history.go(-1);">.: Voltar :.</a></span></td>
          </tr>
          </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
              
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="21%" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;"><?php require_once("../includes/cabecalhoaplvert.php"); ?></td>
                    <td width="78%" height="400" align="left" valign="top" class="verdana_11">
   <?php 
   
	//le arquivo xml do banco e cria sessão temporária
	mysql_select_db($database_policy, $policy);
	$query_politica = "SELECT * FROM pol_politica WHERE pol_pol_codigo =".$_GET['pol_pol_codigo'];
	$politica = mysql_query($query_politica, $policy) or die(mysql_error());
	$row_politica = mysql_fetch_assoc($politica);
	$totalRows_politica = mysql_num_rows($politica);
   ?>
                   <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
                   <?php require_once("includes/cabeca.php"); ?>
                          <input type="hidden" name="MM_delete" value="form1" />
                   </form> 

                    <table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                      <tr>
                        <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Campos selecionados</strong></td>
                      </tr>
                      <?php 
//varre XML
$xml 		= $doc->getElementsByTagName('politica')->item(0);
$condicoes	= $xml->getElementsByTagName('condicao')->item(0);
$contador	= 0;

	 foreach($condicoes->childNodes as $Condicao){
	   if($Condicao->getAttribute("publicado")=="1"){ 
     	  $contador++;
		  
		   $valor = utf8_decode($Condicao->getAttribute("valor"));
		   
			 if($Condicao->getAttribute("campoData")=="1"){
				 $valor = explode("|",$valor);
				 $valor = $valor[0]." &agrave; ".$valor[1];
			 }
?>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><strong><?php echo utf8_decode($Condicao->getAttribute("nome")); ?></strong>&nbsp;:&nbsp;</td>
                        <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $valor; ?></td>
                      </tr>
                      <?php } 
	 }
     if($contador==0){ ?>
                      <tr>
                        <td height="20" colspan="2" align="center" bgcolor="#FFFFFF">Todos os campos adicionados</td>
                      </tr>
                      <?php } ?>
                    </table>
                    <br />
                    
          
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
                      <tr>
                        <td height="25" colspan="2" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Ordena&ccedil;&atilde;o dos campos</strong></td>
                      </tr>
                      <?php 
//varre XML
$ordenacao	= $xml->getElementsByTagName('ordenacao')->item(0);
$cont	= 0;

	 foreach($ordenacao->childNodes as $Ordena){
	   if($Ordena->getAttribute("publicado")=="1"){ 
     	  $cont++;
		  
			$valor = "Decrescente";
			if($Ordena->getAttribute("valor")=="ASC"){
				$valor = "Crescente";
			}
?>
                      <tr>
                        <td height="20" align="right" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><strong><?php echo utf8_decode($Ordena->getAttribute("nome")); ?></strong>&nbsp;:&nbsp;</td>
                        <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><?php echo $valor; ?></td>
                      </tr>
                      <?php } 
	 }
     if($cont==0){ ?>
                      <tr>
                        <td height="20" colspan="2" align="center" bgcolor="#FFFFFF">Nenhum campo adicionado para ordena&ccedil;&atilde;o</td>
                      </tr>
                      <?php } ?>
                    </table><br />
                    </td>
                  </tr>
                  
                  <tr>
                    <td align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                    <td height="1" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                  </tr>
                  <tr>
                    <td align="right" class="verdana_11"></td>
                    <td height="1" align="right" class="verdana_11"></td>
                  </tr>
              </table>
              
              
              </td>
            </tr>
<tr class="verdana_11_bold">
              <td valign="top"></td>
            </tr>
          </table></td>
      </tr>
      
      <tr>
        <td height="1" bgcolor="#FFFFFF"></td>
      </tr>
            <tr>
      	<td height="0" bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>