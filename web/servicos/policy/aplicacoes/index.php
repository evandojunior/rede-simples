<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");

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

mysql_select_db($database_policy, $policy);
$query_infoaplicacoes = "
SELECT pol_apl_codigo, pol_apl_nome, pol_apl_descricao, pol_apl_relevancia, pol_apl_url, pol_apl_icone FROM pol_aplicacao ORDER BY pol_apl_nome ASC";
$infoaplicacoes = mysql_query($query_infoaplicacoes, $policy) or die(mysql_error());
$row_infoaplicacoes = mysql_fetch_assoc($infoaplicacoes);
$totalRows_infoaplicacoes = mysql_num_rows($infoaplicacoes);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>POLICY</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/policy/includes/policy.css">

<link type="text/css" rel="stylesheet" href="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.css?random=20051112" media="screen"></LINK>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/formulario_data/dhtmlgoodies_calendar.js"></script>
<script type="text/javascript" src="/e-solution/servicos/policy/includes/functions.js"></script>
</head>

<body onload="coletaDados()">
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
      <?php if($_SESSION['MM_Policy_Group']=="-1"){ ?>
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF" class="verdana_12 aviso" <?php echo 'height="500"';?>>Você não tem perfil criado para o este ambiente, entre em contato com o Administrador!</td>
      </tr>
      <?php } else{ ?>
      <tr>
        <td height="230" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="81%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Aplica&ccedil;&otilde;es monitoradas</strong></td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="19%" colspan="-2" align="center" valign="middle" class="verdana_11"><a href="novo.php">.: <img src="../images/novo.gif" alt="Cadastrar uma nova aplica&ccedil;&atilde;o" width="12" height="15" border="0" align="absmiddle" /> Nova Aplica&ccedil;&atilde;o :.</a></td>
          </tr>
        </table>
          <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
<?php 
$openAjax = "";
if($totalRows_infoaplicacoes>0){ ?>
             <?php 
			 do { 
			 $cd = $row_infoaplicacoes['pol_apl_codigo'];
			 
			 //--AJAX
			 $openAjax.= 'OpenAjaxPostCmd("dados.php","ip_'.$cd.'","?pol_apl_codigo='.$cd.'","Aguarde carregando...","ip_'.$cd.'",2,2);';
			 //--
			 ?>
            <tr bgcolor="#FFFFFF" class="verdana_12" style="cursor:pointer;" onclick="location.href='../detalhes/index.php?pol_apl_codigo=<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>'">
             <td width="89%" height="27" background="../images/barra_horizontal.jpg">&nbsp;<span class="verdana_12"><strong><?php echo $row_infoaplicacoes['pol_apl_nome']; ?></strong></span> - <span class="verdana_11"><?php
			  if (strlen($row_infoaplicacoes['pol_apl_descricao']) > 100) {
			  echo substr($row_infoaplicacoes['pol_apl_descricao'],0,100)."(...)";
			  } else {
			  echo $row_infoaplicacoes['pol_apl_descricao'];
			  }
			   ?></span></td>
              <td width="5%" align="center" background="../images/barra_horizontal.jpg"><a href="editar.php?pol_apl_codigo=<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>"><img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar aplica&ccedil;&atilde;o" width="17" height="17" border="0" /></a></td>
              <td width="6%" align="left" background="../images/barra_horizontal.jpg"><a href="excluir.php?pol_apl_codigo=<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>"><img src="/e-solution/servicos/policy/images/excluir.gif" alt="Excluir aplica&ccedil;&atilde;o" width="17" height="17" border="0" /></a></td>
            </tr>
            <tr>
              <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="5" colspan="3" align="right" class="verdana_11_bold"></td>
                  </tr>
                <tr>
                  <td width="18%" rowspan="4" valign="top" class="verdana_11_cinza"><a href="../detalhes/index.php?pol_apl_codigo=<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>"><img border="0" src="/datafiles/servicos/policy/aplicacoes/<?php echo $row_infoaplicacoes['pol_apl_icone']; ?>" width="130" height="70" /></a></td>
                  <td width="16%" height="21" class="verdana_11_cinza"><strong><span class="verdana_10"><img src="/e-solution/servicos/policy/images/ip.gif" alt="" width="16" height="16" align="absmiddle" /></span> IP da aplica&ccedil;&atilde;o</strong></td>
                  <td width="66%" class="verdana_11_cinza">:&nbsp; <span id="ip_<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
                </tr>
                <tr>
                  <td height="21" class="verdana_11_cinza"><strong><span class="verdana_10"><img src="/e-solution/servicos/policy/images/numeroacessos.gif" alt="" width="16" height="16" align="absmiddle" /></span> N&ordm; de acessos</strong></td>
                  <td  style="color:#00F" class="verdana_11">:&nbsp; <span id="acessos_<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações..</span>.</td>
                </tr>
                <tr>
                  <td height="21" class="verdana_11_cinza"><strong><span class="verdana_10"><img src="/e-solution/servicos/policy/images/ultimoacesso.gif" alt="" width="16" height="16" align="absmiddle" /></span> &Uacute;ltimo acesso</strong></td>
                  <td style="color:#00F" class="verdana_11">:&nbsp; <span id="ultimo_<?php echo $row_infoaplicacoes['pol_apl_codigo']; ?>">Aguarde, carregando informações...</span></td>
                </tr>
                <tr>
                  <td height="21" class="verdana_11_cinza"><img src="/e-solution/servicos/policy/images/url.gif" border="0" align="absmiddle" /> <strong>URL da aplica&ccedil;&atilde;o</strong></td>
                  <td class="verdana_11_cinza">: <a href="<?php echo $row_infoaplicacoes['pol_apl_url']; ?>" target="_blank"><?php echo $row_infoaplicacoes['pol_apl_url']; ?></a></td>
                </tr>
                 <tr>
                  <td height="18" valign="top" class="verdana_11_cinza">&nbsp;</td>
                  <td height="21" align="left" valign="bottom" class="verdana_11_cinza"><img src="/e-solution/servicos/policy/images/relevancia_menor2.gif" border="0" align="absmiddle" /> <strong>Relev&acirc;ncia</strong></td>
                  <td height="18" class="verdana_11_cinza">: <?php if ( $row_infoaplicacoes['pol_apl_relevancia'] == -1 ) { echo 'Não determinada'; } else { echo $row_infoaplicacoes['pol_apl_relevancia']; } ?></td>
                </tr>
               
                
                <tr>
                  <td colspan="3" align="right" class="verdana_11">&nbsp;</td>
                </tr>
                <tr>
                  <td height="1" colspan="3" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                </tr>
                <tr>
                  <td height="1" colspan="3" align="right" class="verdana_11"></td>
                </tr>
              </table></td>
</tr>
              <?php } while ($row_infoaplicacoes = mysql_fetch_assoc($infoaplicacoes)); ?>
<?php } else { ?>
            <tr class="verdana_11_bold">
              <td colspan="3" valign="top">N&atilde;o h&aacute; nenhuma aplica&ccedil;&atilde;o cadastrada, deseja <a style="color:#0066FF" href="novo.php">cadastrar</a> uma? </td>
            </tr>
<?php } ?>
          </table></td>
      </tr>
      
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <?php } ?>
      <tr>
      	<td bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>
    </table></td>
  </tr>
</table>
<script type="text/javascript">
	function coletaDados(){
		<?php echo $openAjax; ?>	
	}
</script>
</body>
</html>
<?php
mysql_free_result($infoaplicacoes);
?>