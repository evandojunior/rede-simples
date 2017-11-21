<?php if(!isset($_SESSION)){session_start();}
require_once("../../../includes/autentica.php");
require_once("../includes/functions.php");
$finalizado = relatorioFinalizado($database_bbhive, $bbhive, $_GET['bbh_ati_codigo']);
?>
<link href="/corporativo/servicos/bbhive/includes/relatorio.css" rel="stylesheet" type="text/css">
<table width="182" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="26"  height="25" align="center" bgcolor="#F5F9FD"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16" /></td>
    <td bgcolor="#F5F9FD"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/paragrafos/executaParagrafos.php','carregaTudo','adicionaQuebra','Atualizando dados...','carregaTudo','1','2');"<?php } ?>>Adicionar quebra de p&aacute;gina</a></td>
  </tr>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#FFFFFF"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16" /></td>
    <td bgcolor="#FFFFFF"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&pag=/fotos/regra.php','...','carregaTudo','2','2')"<?php } ?>>Adicionar fotos</a></td>
  </tr>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#F5F9FD"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16"></td>
    <td width="174" bgcolor="#F5F9FD"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&pag=/editor/regra.php','...','carregaTudo','2','2')"<?php } ?>>Texto com editor</a></td>
  </tr>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#FFFFFF"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16"></td>
    <td bgcolor="#FFFFFF"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&pag=/paragrafos/index.php','...','carregaTudo','2','2')"<?php } ?>>Textos pr&eacute;-definidos</a></td>
  </tr>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#F5F9FD"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16"></td>
    <td bgcolor="#F5F9FD"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&pag=/anexos/regra.php','...','carregaTudo','2','2')"<?php } ?>>Adicionar arquivos</a></td>
  </tr>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#FFFFFF"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16"></td>
    <td bgcolor="#FFFFFF"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&pag=/anexos_repositorio/index.php','...','carregaTudo','2','2')"<?php } ?>>Anexos do reposit&oacute;rio</a></td>
  </tr>
  <?php if($_SESSION['exibeIndicios'] == 88){ ?>
  <tr>
    <td width="26" height="25" align="center" bgcolor="#F5F9FD"><img src="../../../images/painel/<?php echo $finalizado > 0 ? "acaoOFF.gif" : "acao.gif"; ?>" width="16" height="16" /></td>
    <td bgcolor="#F5F9FD"><a href="#@" <?php if($finalizado == 0){ ?>onclick="window.top.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/backroundJanela.php','carregaTudo','?bbh_ati_codigo=<?php echo $_GET['bbh_ati_codigo']; ?>&amp;bbh_rel_codigo=<?php echo $_GET['bbh_rel_codigo']; ?>&amp;bbh_flu_codigo=<?php echo $_GET['bbh_flu_codigo']; ?>&amp;pag=/anexos_repositorio/indicios.php','...','carregaTudo','2','2')"<?php } ?>>Resultado de an&aacute;lise dos ind&iacute;cios</a></td>
  </tr>
  <?php } ?>
</table>
