<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

if(isset($_GET['bbh_dep_codigo'])){
	$bbh_dep_codigo = $_SESSION['idDepto'] = $_GET['bbh_dep_codigo'];
} else {
	$bbh_dep_codigo = $_SESSION['idDepto'];
}

	$query_departamentos = "SELECT d.* FROM bbh_departamento d Where d.bbh_dep_codigo=$bbh_dep_codigo";
    list($departamentos, $row_departamentos, $totalRows_departamentos) = executeQuery($bbhive, $database_bbhive, $query_departamentos);

	$query_campos = "select d.*, 
					(select count(i.bbh_tip_codigo) 
						from bbh_indicio i where i.bbh_tip_codigo = d.bbh_tip_codigo) as total 
							FROM bbh_tipo_indicio d  Where d.bbh_dep_codigo=$bbh_dep_codigo";
    list($campos, $rows, $totalRows_campos) = executeQuery($bbhive, $database_bbhive, $query_campos, $initResult = false);
	//--
	
	//--
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_deptoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="6" 

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/detalhes.gif" width="16" height="16" border="0" align="absmiddle" /> 
      
      Gerenciamento de campos
	<div style="float:right"><a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/index.php?perfil=1','menuEsquerda|colCentro');"><span 
class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
    </tr>
  <tr>
    <td height="25" colspan="6">&nbsp;&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" />&nbsp;<strong><?php echo $row_departamentos['bbh_dep_nome']; ?></strong></td>
  </tr>
  <tr>
    <td height="8" colspan="6"></td>
  </tr>
  <tr class="verdana_11_bold">
    <td style="border-bottom:1px solid #000000;" width="30%" height="22">Nome</td>
    <td width="30%" style="border-bottom:1px solid #000000;">Descri&ccedil;&atilde;o</td>
    <td width="17%" style="border-bottom:1px solid #000000;">Publico</td>
    <td width="17%" style="border-bottom:1px solid #000000;">Corporativo</td>
    <td colspan="2" align="center" style="border-bottom:1px solid #000000;"><a href="#@" onclick="LoadSimultaneo('perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/campos_indicios/novo.php','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/novo.gif" width="12" height="15" border="0" align="absmiddle" /></a></td>
  </tr>
<?php if ($totalRows_campos > 0) { // Show if recordset not empty ?>
  <?php while ($row_campos = mysqli_fetch_assoc($campos)) { ?>
  <tr class="verdana_10">    
      <td style="border-bottom:1px dotted #999999;" height="22">
	  <?php echo $row_campos['bbh_tip_nome']; ?>      </td>
      <td style="border-bottom:1px dotted #999999;">
	  <?php
		if(strlen($row_campos['bbh_tip_descricao'])==0){
			echo "<span style='color:#fff'>.</span>";
		}
		elseif(strlen($row_campos['bbh_tip_descricao'])>65){
			echo substr($row_campos['bbh_tip_descricao'],0,62)."...";
		}else{
			echo $row_campos['bbh_tip_descricao'];
		}
      ?>
      </td>
      <td style="border-bottom:1px dotted #999999;"><?php echo $row_campos['bbh_tip_ativo']=="1"?"Sim":"Não"; ?></td>
      <td style="border-bottom:1px dotted #999999;"><?php echo $row_campos['bbh_tipo_corp']=="1"?"Sim":"Não"; ?></td>
      <td width="3%" align="center" valign="middle" style="border-bottom:1px dotted #999999;"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/campos_indicios/editar.php?bbh_tip_codigo=<?php echo $row_campos['bbh_tip_codigo']; ?>','menuEsquerda|colCentro');"><img src="/e-solution/servicos/bbhive/images/editar.gif" width="17" height="17" border="0" align="absmiddle" /></a></td>
      <td width="3%" align="center" valign="middle" style="border-bottom:1px dotted #999999;">
    <?php if($row_campos['total'] == 0){ ?>  
      <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|departamentos/campos_indicios/excluir.php?bbh_tip_codigo=<?php echo $row_campos['bbh_tip_codigo']; ?>','menuEsquerda|colCentro');"><img 

src="/e-solution/servicos/bbhive/images/excluir.gif" width="17" height="17" border="0" align="absmiddle" /></a>
<?php } else {?>
<img src="/e-solution/servicos/bbhive/images/excluir-negado.gif" alt="Não é permitido a exclusão deste registro" border="0" align="absmiddle" />
<?php } ?>
</td>
  </tr>
  <?php } ?>
      <?php }else{ // Show if recordset not empty ?>
      <tr>
        <td class="color" colspan="6">N&atilde;o h&aacute; registros cadastrados.</td>
      </tr>
      <?php } ?>

  <tr>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<?php
mysqli_free_result($campos);
?>
