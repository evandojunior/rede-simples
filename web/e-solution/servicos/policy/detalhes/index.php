<?php
		require_once("../includes/autentica.php");
	require_once("../includes/functions.php");
if (!isset($_SESSION)) {
  session_start();
}

//Auditoria do próprio Policy
/*$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
EnviaPolicy("Acessou a página inicial do sistema");*/

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

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
      <tr>
        <td height="75" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="85%" align="left" bgcolor="#FFFFFF" class="verdana_12"><strong>&nbsp;&nbsp;<img src="/e-solution/servicos/policy/images/icon_lado.gif" alt=" " align="absmiddle"/>&nbsp;Gerenciamento da Aplica&ccedil;&atilde;o</strong></td>
            <td width="15%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
            <td width="15%" colspan="-2" align="center" valign="middle" class="verdana_11">&nbsp;</td>
          </tr>
        </table>
          <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100%"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td height="32" class="verdana_11"><?php require_once('../includes/cabecalhoapl.php'); ?></td>
                  </tr>
                  <tr>
                    <td align="center" class="verdana_11">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" class="verdana_11" width="100%"><fieldset style="width:94%; text-align:center;"><legend class="verdana_12" style="font-weight:bold; color:#006600;">Ferramentas Administrativas</legend><table width="100%" align="center" cellpadding="2" cellspacing="0">
                      <tr>
                        <td height="7"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td align="center">&nbsp;</td>
                        <td align="center" class="ferramentasUsuarioOFF" id="quem" style="cursor:pointer;" onmouseover="TrocaFundo('quem');" onmouseout="TrocaFundo('quem');"><a style="display:block;" href="regra.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>&quem=true" class="tipbalao"><img src="/e-solution/servicos/policy/images/quem.gif" width="48" height="48" border="0" /><br />
                          Quem<span class="tooltip"><span class="topo"></span><span class="meio">Veja quais s&atilde;o os usu&aacute;rios utilizando a aplica&ccedil;&atilde;o.</span><span class="base"></span></span></a></td>
                        <td id="quando" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('quando');" onmouseout="TrocaFundo('quando');" style="cursor:pointer;"><a style="display:block;" href="regra.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>&quando=true" class="tipbalao"><img src="/e-solution/servicos/policy/images/quando.gif" alt="" width="48" height="48" border="0" /><br />
                          Quando<span class="tooltip"><span class="topo"></span><span class="meio">Veja os momentos em que a aplica&ccedil;&atilde;o &eacute; acessada.</span><span class="base"></span></span></a></td>
                        <td id="onde" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('onde');" onmouseout="TrocaFundo('onde');" style="cursor:pointer;"><a style="display:block;" href="regra.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>&onde=true" class="tipbalao"><img src="/e-solution/servicos/policy/images/onde.gif" alt="" width="48" height="48" border="0" /><br />
                          Onde<span class="tooltip"><span class="topo"></span><span class="meio">Veja de onde vem os acessos.</span><span class="base"></span></span></a></td>
                        <td id="oque" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('oque');" onmouseout="TrocaFundo('oque');" style="cursor:pointer;"><a style="display:block;" href="regra.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>&oquefez=true" class="tipbalao"><img src="/e-solution/servicos/policy/images/oque.gif" alt="" width="48" height="48" border="0" /><br />
                          O qu&ecirc;<span class="tooltip"><span class="topo"></span><span class="meio">Relat&oacute;rio do que foi feito na aplica&ccedil;&atilde;o.</span><span class="base"></span></span></a></td>
                      </tr>
                      <tr>
                        <td height="10" colspan="5" align="center"></td>
                        </tr>
                      <tr>
                        <td width="12" align="center">&nbsp;</td>
                        <td id="relevancia" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('relevancia');" onmouseout="TrocaFundo('relevancia');" style="cursor:pointer;"><a style="display:block;" href="regra.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>&relevancia=true" class="tipbalao"><img src="/e-solution/servicos/policy/images/relevancia.gif" alt="" width="48" height="48" border="0" /><br />
                          Relev&acirc;ncia<span class="tooltip"><span class="topo"></span><span class="meio">Veja a relev&acirc;ncia do que foi feito na aplica&ccedil;&atilde;o.</span><span class="base"></span></span></a></td>
                        <td id="filtros" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('filtros');" onmouseout="TrocaFundo('filtros');" style="cursor:pointer;"><a style="display:block;" href="/e-solution/servicos/policy/filtros/index.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>" class="tipbalao"><img src="/e-solution/servicos/policy/images/filtro.gif" alt="" width="48" height="48" border="0" /><br />
                          Filtros<span class="tooltip"><span class="topo"></span><span class="meio">Crie seu filtro de pesquisa e otimize sua busca.</span><span class="base"></span></span></a></td>
                        <td id="politicas" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('politicas');" onmouseout="TrocaFundo('politicas');" style="cursor:pointer;"><a style="display:block;" href="/e-solution/servicos/policy/politicas/index.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>" class="tipbalao"><img src="/e-solution/servicos/policy/images/politica_on.gif" alt="" width="48" height="48" border="0" /><br />
                          Pol&iacute;ticas<span class="tooltip"><span class="topo"></span><span class="meio">Crie e veja as pol&iacute;ticas de acesso &agrave; aplica&ccedil;&atilde;o.</span><span class="base"></span></span></a></td>
                        <td id="graficos" align="center" class="ferramentasUsuarioOFF" onmouseover="TrocaFundo('graficos');" onmouseout="TrocaFundo('graficos');"><a style="display:block;" href="/e-solution/servicos/policy/grafico/index.php?pol_apl_codigo=<?php echo $colname_aplicacoes;?>" class="tipbalao"><img src="/e-solution/servicos/policy/images/graphic_on.gif" alt="" width="48" height="48" border="0" /><br />
                          Gr&aacute;ficos<span class="tooltip"><span class="topo"></span><span class="meio"> Veja os gr&aacute;ficos de acesso.</span><span class="base"></span></span></a></td>
                      </tr>
                    </table>
                    </fieldset></td>
                  </tr>
                  <tr>
                    <td height="90" align="right" class="verdana_11">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="1" align="right" background="/e-solution/servicos/policy/images/separador.gif" class="verdana_11"></td>
                  </tr>
                  <tr>
                    <td height="1" align="right" class="verdana_11"></td>
                  </tr>
              </table></td>
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
      	<td bgcolor="#FFFFFF"><?php require_once('../includes/rodape.php'); ?></td>
      </tr>

    </table></td>
  </tr>
</table>
</body>
</html>