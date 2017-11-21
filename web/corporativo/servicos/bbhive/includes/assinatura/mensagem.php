<?php 
if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$query_arquivo = "SELECT * FROM bbh_relatorio WHERE bbh_rel_codigo = ".$_GET['id'];
list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $database_bbhive, $query_arquivo);

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

$codigo_usuario = $_SESSION['usuCod'];

$file = $path."database/servicos/bbhive/" . $row_arquivo['bbh_rel_caminho'] ."/". $row_arquivo['bbh_rel_nmArquivo']; 
$nome_arquivo = $row_arquivo['bbh_rel_nmArquivo'];

//origem
//variável ondeAssinatura encontra-se no SETUP.PHP
$origem = $ondeAssinatura."/".$nome_arquivo.".p7s";

//destino
$destino = $path."database/servicos/bbhive/" . $row_arquivo['bbh_rel_caminho'] ."/".$nome_arquivo.".p7s";


//assina o relatório
	$updateSQL = "UPDATE bbh_relatorio SET bbh_rel_ass = '1' WHERE bbh_rel_codigo = ".$_GET['id'];
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

//move para o devido local
copy($origem, $destino);

//muda permissão
@chmod($ondeAssinatura,777);

//remove o arquivo da lista
@unlink($origem);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Central de assinaturas - BBHive</title>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
<script type="text/javascript">
	function acaoFechar(){
		window.opener.location.reload(true); 
		window.close();
	}
</script>
</head>
<body>
<div name="url" id="url" style="display:none;position:absolute; margin-top:-500px;"></div>
<div style="position:absolute;display:none;" id="resultTransp"></div>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:25px;">
      <tr>
        <td align="center" valign="top"><?php require_once('../cabecalho.php'); ?></td>
      </tr>
      
      <tr>
        <td height="22" align="left" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">&nbsp;Central de assinaturas</td>
      </tr>
 
      <tr>
        <td align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="padding-right:10px;" bgcolor="#FFFFFF">
          <tr>
            <td height="300" align="left" valign="top" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">
       <br />     <br /> 
<center>
<h1>Arquivo assinado com sucesso!!!</h1><br>
<br>
<br>
<h3><a href="#" onClick="acaoFechar();" style="color:#33C">Clique aqui para fechar</a></h3>
</center>
            
            </td>
            </tr>
          
          </table>
          
          </td>
      </tr>
      
      <tr>
        <td bgcolor="#FFFFFF"><?php require_once('../rodape.php'); ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>