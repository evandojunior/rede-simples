<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$query_administradores = "SELECT * FROM bbh_administrativo ORDER BY bbh_adm_nome ASC";
list($administradores, $row_administradores, $totalRows_administradores) = executeQuery($bbhive, $database_bbhive, $query_administradores);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_admNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="4" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-administrador-16px.gif" width="16" height="16" align="absmiddle" /> 

Gerenciamento de <?php echo $_SESSION['adm_admNome']; ?>
<div style="float:right;"><a href="#@" 

onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="8" colspan="4"></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="21%" height="22">Nome</td>
    <td style="border-bottom:1px solid #000000;" width="46%">E-Mail</td>
    <td style="border-bottom:1px solid #000000;" width="24%" align="center">&Uacute;ltimo acesso</td>
    <td style="border-bottom:1px solid #000000;" width="9%" align="center"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/novo.php','menuEsquerda|colCentro');"><img 

src="/e-solution/servicos/bbhive/images/novo.gif" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
<?php if ($totalRows_administradores > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr class="verdana_10">    
      <td style="border-bottom:1px dotted #999999;" height="22">
	  <?php
	  if(strlen($row_administradores['bbh_adm_nome'])>40){	  
	      echo substr($row_administradores['bbh_adm_nome'],0,37)."...";
	  }else{
		  echo $row_administradores['bbh_adm_nome'];	  	
	  }
	  ?>      </td>
      <td style="border-bottom:1px dotted #999999;">
	  <?php
		if(strlen($row_administradores['bbh_adm_identificacao'])>65){
			echo substr($row_administradores['bbh_adm_identificacao'],0,62)."...";
		}else{
			echo $row_administradores['bbh_adm_identificacao'];
		}
      ?>      </td>
      <td align="center" style="border-bottom:1px dotted #999999;"><?php
	  if($row_administradores['bbh_adm_ultimoAcesso']===NULL){
	  	echo "---";
	  }else{
	  	echo converteData($row_administradores['bbh_adm_ultimoAcesso']);
	  }
	  ?></td>
      <td align="center" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/editar.php?bbh_adm_codigo=<?php echo $row_administradores['bbh_adm_codigo']; ?>','menuEsquerda|colCentro');"><img 

src="/e-solution/servicos/bbhive/images/editar.gif" width="17" height="17" border="0" align="absmiddle" /></a>&nbsp;&nbsp;<?php
	if($totalRows_administradores>1){
 ?><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/excluir.php?bbh_adm_codigo=<?php echo $row_administradores['bbh_adm_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/excluir.gif" width="17" height="17" border="0" align="absmiddle" /></a><?php
    }else{
			 ?>	
<a href="#@"><img title="N&atilde;o &eacute; poss&iacute;vel excluir o &uacute;nico administrador" src="/e-solution/servicos/bbhive/images/excluir-negado.gif" width="17" height="17" border="0" align="absmiddle" /></a>
<?php } 
 
 ?></td>
  </tr>
  <?php } while ($row_administradores = mysqli_fetch_assoc($administradores)); ?>
      <?php }else{ // Show if recordset not empty ?>
      <tr>
        <td class="color" colspan="4">Voc&ecirc; n&atilde;o possui nenhum administrador cadastrado. <a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/novo.php','menuEsquerda|colCentro');">Clique aqui</a> para cadastrar um novo.</td>
      </tr>
      <?php } ?>

  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($administradores);
?>
