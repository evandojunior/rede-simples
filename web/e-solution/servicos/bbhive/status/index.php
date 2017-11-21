<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
//include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_status = "SELECT * FROM bbh_status_atividade ORDER BY bbh_sta_ati_peso ASC";
list($status, $row_status, $totalRows_status) = executeQuery($bbhive, $database_bbhive, $query_status);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_statusNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="4" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-status-16px.gif" width="16" height="16" align="absmiddle" /> 

Gerenciamento de <?php echo strtolower($_SESSION['adm_statusNome']); ?>
  <div style="float:right;"><a href="#@" 

onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="8" colspan="4"></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="18%" height="22">Nome</td>
    <td width="20%" align="center" style="border-bottom:1px solid #000000;">Peso</td>
    <td style="border-bottom:1px solid #000000;" width="51%">Descri&ccedil;&atilde;o</td>
    <td style="border-bottom:1px solid #000000;" width="11%" align="center"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/novo.php','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/novo.gif" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
<?php if ($totalRows_status > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr class="verdana_10">
      <td style="border-bottom:1px dotted #999999;" height="22">
        <?php
	  if(strlen($row_status['bbh_sta_ati_nome'])>32){	  
	      echo substr($row_status['bbh_sta_ati_nome'],0,29)."...";
	  }else{
		  echo $row_status['bbh_sta_ati_nome'];	  	
	  }
	  ?>      </td>
      <td align="center" style="border-bottom:1px dotted #999999;"><?php echo $row_status['bbh_sta_ati_peso']; ?></td>
      <td style="border-bottom:1px dotted #999999;">
        <?php
		if(strlen($row_status['bbh_sta_ati_observacao'])==0){
			echo "<span style='color:#fff'>.</span>";
		}
		elseif(strlen($row_status['bbh_sta_ati_observacao'])>59){
			echo substr($row_status['bbh_sta_ati_observacao'],0,56)."...";
		}else{
			echo $row_status['bbh_sta_ati_observacao'];
		}
      ?>      </td>
      <td align="center" style="border-bottom:1px dotted #999999;"><a href="#@" <?php if($row_status['bbh_sta_ati_codigo']>2){ ?>onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/editar.php?bbh_sta_ati_codigo=<?php echo $row_status['bbh_sta_ati_codigo']; ?>','menuEsquerda|colCentro');"<?php } ?>><img src="/e-solution/servicos/bbhive/images/<?php if($row_status['bbh_sta_ati_codigo']>2){ ?>editar.gif<?php }else{ echo "editar-negado.gif"; } ?>" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<a href="#@" <?php if($row_status['bbh_sta_ati_codigo']>5){ ?>onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/excluir.php?bbh_sta_ati_codigo=<?php echo $row_status['bbh_sta_ati_codigo']; ?>','menuEsquerda|colCentro');" <?php } ?>><img src="/e-solution/servicos/bbhive/images/<?php if($row_status['bbh_sta_ati_codigo']>5){ ?>excluir.gif<?php }else{ echo "excluir-negado.gif"; } ?>" width="17" height="17" border="0" align="absmiddle" /></a></td>
</tr>
  <?php } while ($row_status = mysqli_fetch_assoc($status)); ?>
      <?php }else{ // Show if recordset not empty ?>
      <tr>
        <td class="color" colspan="4">Voc&ecirc; n&atilde;o possui nenhum status cadastrado. <a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|status/novo.php','menuEsquerda|colCentro');">Clique aqui</a> para cadastrar um novo.</td>
      </tr>
      <?php } ?>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($status);
?>