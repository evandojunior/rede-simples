<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


$query_departamentos = "SELECT d.*,
  (
   select count(t.bbh_dep_codigo) from bbh_tipo_indicio t where d.bbh_dep_codigo = t.bbh_dep_codigo
   ) as totalInd,
  (
   select count(u.bbh_dep_codigo) from bbh_usuario u where d.bbh_dep_codigo = u.bbh_dep_codigo
   ) as totalUsu   
    FROM bbh_departamento d ORDER BY bbh_dep_nome ASC";
list($departamentos, $row_departamentos, $totalRows_departamentos) = executeQuery($bbhive, $database_bbhive, $query_departamentos);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_deptoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img 

src="/e-solution/servicos/bbhive/images/ger-departamento-16px.gif" width="16" height="16" align="absmiddle" /> 
      
      Gerenciamento de <?php echo $_SESSION['adm_deptoNome']; ?></td>
    <td height="26" colspan="4" align="right" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold">
	<div style="float:right"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral')"><span 
class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
    </tr>
  <tr>
    <td height="8" colspan="6"></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="34%" height="22">Nome</td>
    <td colspan="2" style="border-bottom:1px solid #000000;">Descri&ccedil;&atilde;o</td>
    <td colspan="3" align="center" style="border-bottom:1px solid #000000;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=2&menuEsquerda=1|departamentos/novo.php','menuEsquerda|colCentro');"><img 

src="/e-solution/servicos/bbhive/images/novo.gif" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
<?php if ($totalRows_departamentos > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  <tr class="verdana_10">    
      <td style="border-bottom:1px dotted #999999;" height="22">
	  <?php
	  if(strlen($row_departamentos['bbh_dep_nome'])>40){	  
	      echo substr($row_departamentos['bbh_dep_nome'],0,37)."...";
	  }else{
		  echo $row_departamentos['bbh_dep_nome'];	  	
	  }
	  ?>      </td>
      <td colspan="2" style="border-bottom:1px dotted #999999;">
	  <?php
		if(strlen($row_departamentos['bbh_dep_obs'])==0){
			echo "<span style='color:#fff'>.</span>";
		}
		elseif(strlen($row_departamentos['bbh_dep_obs'])>65){
			echo substr($row_departamentos['bbh_dep_obs'],0,62)."...";
		}else{
			echo $row_departamentos['bbh_dep_obs'];
		}
      ?>
      </td>
      <td width="4%" align="left" valign="middle" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/campos_indicios/regra.php?bbh_dep_codigo=<?php echo $row_departamentos['bbh_dep_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/detalhes.gif" title="Clique para gerenciar os campos adicionais deste departamento" width="16" height="16" border="0" align="absmiddle" />&nbsp;<?php echo $a=$row_departamentos['totalInd'];?></a></td>
      <td width="3%" align="center" valign="middle" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/editar.php?bbh_dep_codigo=<?php echo $row_departamentos['bbh_dep_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/editar.gif" width="17" height="17" border="0" align="absmiddle" /></a></td>
      <td width="4%" align="center" valign="middle" style="border-bottom:1px dotted #999999;"><?php if($row_departamentos['totalInd'] == 0 && $row_departamentos['totalUsu'] == 0){?>
      <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/excluir.php?bbh_dep_codigo=<?php echo $row_departamentos['bbh_dep_codigo']; ?>','menuEsquerda|colCentro');"><img 

src="/e-solution/servicos/bbhive/images/excluir.gif" width="17" height="17" border="0" align="absmiddle" /></a>
        <?php } else { ?>
        <img src="/e-solution/servicos/bbhive/images/excluir-negado.gif" width="17" height="17" align="absmiddle" title="Este registro não pode ser excluído">
        <?php } ?></td>
  </tr>
  <?php } while ($row_departamentos = mysqli_fetch_assoc($departamentos)); ?>
      <?php }else{ // Show if recordset not empty ?>
      <tr>
        <td class="color" colspan="6">Voc&ecirc; n&atilde;o possui nenhum departamento cadastrado. <a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/novo.php','menuEsquerda|colCentro');">Clique aqui</a> para cadastrar um novo.</td>
      </tr>
      <?php } ?>

  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($departamentos);
?>
