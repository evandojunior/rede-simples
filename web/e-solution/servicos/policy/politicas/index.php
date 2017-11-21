<?php
		require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

mysqli_select_db($policy, $database_policy);
$query_strPolitica = "select * from pol_politica 
WHERE pol_apl_codigo = " .$_GET['pol_apl_codigo'] . " 
 order by pol_pol_criacao DESC, pol_pol_titulo ASC ";
$strPolitica = mysqli_query($policy, $query_strPolitica) or die(mysql_error());
$row_strPolitica = mysqli_fetch_assoc($strPolitica);
$totalRows_strPolitica = mysqli_num_rows($strPolitica);

//altera sessão
session_regenerate_id();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Pol&iacute;ticas</strong></td>
            <td style="border-bottom:1px solid #CCCCCC;" width="15%" colspan="-2" align="center" valign="middle" class="verdana_11"><span class="verdana_11_bold"><a href='javascript:history.go(-1);'>.: Voltar :.</a></span></td>
          </tr>
          </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%">
              
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="21%" valign="top" class="verdana_11" style="border-right:dashed 1px #999999;"><?php require_once("../includes/cabecalhoaplvert.php"); ?></td>
                    <td width="78%" height="400" align="left" valign="top" class="verdana_11">
                    
<table width="590" border="0" align="center" cellpadding="6" cellspacing="0">
<tr class="verdana_11_bold">
                <td width="278" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">T&iacute;tulo da pol&iacute;tica</td>
    <td width="130" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Autor da pol&iacute;tica</td>
    <td width="60" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">Criado em</td>
    <td colspan="3" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><a href="regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>">.: <img src="../images/novo.gif" alt="Cadastrar uma nova pol&iacute;tica" width="12" height="15" border="0" align="absmiddle" /> Nova  :.</a></td>
  </tr>
 <?php if($totalRows_strPolitica>0){ ?>
   <?php do{ ?>
                <tr>

			<td align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $tp = $row_strPolitica['pol_pol_titulo'] ?></td>

			<td align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $ap = $row_strPolitica['pol_usu_identificacao'] ?></td>

                  <td align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $dc = arrumaDate(substr($row_strPolitica['pol_pol_criacao'],0,10)); ?></td>
                  <td width="12" align="center" style="border-bottom:dotted 1px #333333;"><a href="../detalhes/regra.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&pol_pol_codigo=<?php echo $row_strPolitica['pol_pol_codigo']; ?>"><img src="../images/pink_eye.gif" alt="Visualizar pol&iacute;tica" width="16" height="16" border="0" /></a></td>
                  <td width="18" align="center" style="border-bottom:dotted 1px #333333;"><a href="edita.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&pol_pol_codigo=<?php echo $row_strPolitica['pol_pol_codigo']; ?>"><img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar politica" width="17" height="17" border="0" /></a></td>
                  <td width="20" align="center" style="border-bottom:dotted 1px #333333;"><a href="edita.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>&pol_pol_codigo=<?php echo $row_strPolitica['pol_pol_codigo']; ?>&exclui=true"><img src="/e-solution/servicos/policy/images/excluir.gif" alt="Excluir politica" width="17" height="17" border="0" /></a></td>
                  </tr>
    <?php } while ($row_strPolitica = mysqli_fetch_assoc($strPolitica)); ?>
 <?php }else{ ?>
                <tr class="verdana_11">
                  <td colspan="6" align="left">N&atilde;o h&aacute; informa&ccedil;&otilde;es cadastradas</td>
                  </tr>
 <?php } ?>                 
</table>
                    
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