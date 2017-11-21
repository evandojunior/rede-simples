<?php
	require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

 // SELECT DO GRÁFICO

mysqli_select_db($policy, $database_policy);
$query_grafico = "select * from pol_grafico 
WHERE pol_apl_codigo = " .$_GET['pol_apl_codigo'] . "   
 order by pol_graf_titulo ASC";
$grafico = mysqli_query($policy, $query_grafico) or die(mysql_error());
$row_grafico = mysqli_fetch_assoc($grafico);
$totalRows_grafico = mysqli_num_rows($grafico);

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
            <td style="border-bottom:1px solid #CCCCCC;" width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt="Gr&aacute;ficos de Estat&iacute;sticas" align="absmiddle"/>&nbsp;Gr&aacute;ficos</strong></td>
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
                <td width="278" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">T&iacute;tulo do gr&aacute;fico</td>
                <td width="130" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="69" height="0" align="left" background="/e-solution/servicos/policy/images/barra_horizontal.jpg">&nbsp;</td>
    <td colspan="3" align="center" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><a href="/e-solution/servicos/policy/grafico/passo1.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>">.: <img src="../images/novo.gif" alt="Cadastrar um novo gr&aacute;fico" width="12" height="15" border="0" align="absmiddle" /> Novo  :.</a></td>
  </tr>
 <?php  if($totalRows_grafico>0){ ?>
   <?php  do{ ?>
                <tr>

			<td height="20" align="left" style="border-bottom:dotted 1px #333333;">&nbsp;<?php echo $tg = $row_grafico['pol_graf_titulo'] ?></td>

			<td height="20" align="left" style="border-bottom:dotted 1px #333333;">&nbsp;</td>

                  <td height="20" align="left" style="border-bottom:dotted 1px #333333;">&nbsp;</td>
                  <td width="26" height="20" align="right" style="border-bottom:dotted 1px #333333;">
                  <?php if ($row_grafico['pol_graf_tipo'] == 'pizza') { ?>
                  <a href="/e-solution/servicos/policy/grafico/pizza/final.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>" target="_blank"> <img src="/e-solution/servicos/policy/images/pizza_mini.gif" alt="Visualizar gr&aacute;fico" width="16" height="16" border="0" /></a>
                  <?php } else if ($row_grafico['pol_graf_tipo'] == 'barra') { ?>
                  <a href="/e-solution/servicos/policy/grafico/barra/final.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>" target="_blank">
                  <img src="/e-solution/servicos/policy/images/grafico.gif" alt="Visualizar gr&aacute;fico" width="16" height="15" border="0" /></a>
                  <?php } else if ($row_grafico['pol_graf_tipo'] == 'linha') { ?>
                  <a href="/e-solution/servicos/policy/grafico/linha/final.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>" target="_blank">
                  <img src="/e-solution/servicos/policy/images/linha_mini.gif" alt="Visualizar gr&aacute;fico" width="21" height="16" border="0" /></a>
                  <?php } ?>                  </td>
                  <td width="13" height="20" align="center" style="border-bottom:dotted 1px #333333;">
                  
                  <?php if ($row_grafico['pol_graf_tipo'] == 'pizza') { ?>
                  <a href="/e-solution/servicos/policy/grafico/pizza/editar.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>&pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>" > <img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar gr&aacute;fico" width="17" height="17" border="0" /></a>
                  <?php } else if ($row_grafico['pol_graf_tipo'] == 'barra') { ?>
                  <a href="/e-solution/servicos/policy/grafico/barra/editar.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>&pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>" >
                  <img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar gr&aacute;fico" width="17" height="17" border="0" /></a>
                  <?php } else if ($row_grafico['pol_graf_tipo'] == 'linha') { ?>
                  <a href="/e-solution/servicos/policy/grafico/linha/editar.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>&pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>" >
                  <img src="/e-solution/servicos/policy/images/editar.gif" alt="Editar gr&aacute;fico" width="17" height="17" border="0" /></a>
                  <?php } ?>                 </td>
                  <td width="14" height="20" align="center" style="border-bottom:dotted 1px #333333;" onclick="if(confirm('Tem certeza que deseja excluir este gráfico?!\n\Clique em Ok em caso de confirmação.')){return true; } else { return false; }">
                  <a href="/e-solution/servicos/policy/grafico/excluir.php?pol_graf_codigo=<?php echo $row_grafico['pol_graf_codigo']; ?>&pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>">
                  <img src="/e-solution/servicos/policy/images/excluir.gif" alt="Excluir gr&aacute;fico" width="17" height="17" border="0" /></a></td>
                </tr>
    <?php  } while ($row_grafico = mysqli_fetch_assoc($grafico)); ?>
 <?php  }else{ ?>
                <tr class="verdana_11">
                  <td colspan="6" align="left">N&atilde;o h&aacute; gr&aacute;ficos cadastrados</td>
                  </tr>
 <?php  } ?>                 
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