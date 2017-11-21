<?php  if(!isset($_SESSION)){ session_start(); } 

if(isset($_POST['AdicionaRelacao'])){
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
	$bbh_flu_codigo_p = $_POST['bbh_flu_codigo_p'];	
	$bbh_flu_codigo_f = $_POST['bbh_flu_codigo_f'];
	
	
	   $insertSQL = "INSERT INTO bbh_fluxo_relacionado (bbh_flu_codigo_p, bbh_flu_codigo_f)
						VALUES ($bbh_flu_codigo_p, $bbh_flu_codigo_f)";
        list($Result1, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	   
	$onLink = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=".$bbh_flu_codigo_p."','menuEsquerda|conteudoGeral')";
	echo "<var style='display:none'>".$onLink."</var>";	
	exit;
}
if(isset($_POST['bbh_flu_codigo_f']) && !isset($_POST['AdicionaRelacao'])){
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
	$bbh_flu_codigo_p = $_POST['bbh_flu_codigo_p'];	
	$bbh_flu_codigo_f = $_POST['bbh_flu_codigo_f'];
	
		$deleteSQL = "DELETE FROM bbh_fluxo_relacionado WHERE bbh_flu_codigo_p = $bbh_flu_codigo_p AND bbh_flu_codigo_f=$bbh_flu_codigo_f";
        list($Result1, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	
		$deleteSQL = "DELETE FROM bbh_fluxo_relacionado WHERE bbh_flu_codigo_p = $bbh_flu_codigo_f AND bbh_flu_codigo_f=$bbh_flu_codigo_p";
        list($Result1, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
	   
	$onLink = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=".$bbh_flu_codigo_p."','menuEsquerda|conteudoGeral')";
	echo "<var style='display:none'>".$onLink."</var>";	
	exit;
}
	$query_rela = "	select * from (
						select bbh_flu_codigo_f as codigo from bbh_fluxo_relacionado
						 where bbh_flu_codigo_p = ".$bbh_flu_codigo."
					 UNION 
						select bbh_flu_codigo_p as codigo from bbh_fluxo_relacionado
						 where bbh_flu_codigo_f = ".$bbh_flu_codigo."
					  ) as relacionados
						order by codigo asc";
    list($rela, $row_rela, $totalRows_rela) = executeQuery($bbhive, $database_bbhive, $query_rela, $initResult = false);

	$acaoRem = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/consulta/includes/relacionados.php','loadFluxo','removeVinculo','Aguarde','loadFluxo','1','2')";
	
	$acaoAdd = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/consulta/includes/relacionados.php','loadFluxo','AdicionaVinculo','Aguarde','loadFluxo','1','2')";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="4" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/relacionados.gif" border="0" align="absmiddle" />&nbsp;<strong>(<?php echo $totalRows_rela; ?>) <?php echo $_SESSION['FluxoNome']; ?> relacionados</strong></td>
  </tr>
  <?php while($row_rela = mysqli_fetch_assoc($rela)){
         $bbh_flu_codigo = $row_rela['codigo'];
			 include("includes/cabecaFluxo.php");
  	?>
  <tr>
    <td width="29" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="282" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>&nbsp;C&oacute;d. <?php echo $bbh_flu_codigo; ?></strong><strong  style="color:#F60"> - <?php echo $numeroProcesso; ?></strong></td>
    <td width="241" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<strong style="color:#36C"><?php echo $row_CabFluxo['bbh_flu_titulo']; ?></strong></td>
    <td width="48" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><a href="#@" onclick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&exibeAtividade=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar os detalhes deste <?php echo $_SESSION['FluxoNome']; ?>"><img src="/corporativo/servicos/bbhive/images/visualizar_indicio.gif" width="16" height="16" border="0" align="absmiddle"/></a>&nbsp;<a href="#@" title="Cancelar relação coom este <?php echo $_SESSION['FluxoNome']; ?>" onclick="if(confirm('Tem certeza que deseja cancelar a relação com este <?php echo $_SESSION['FluxoNome']; ?>?\n            Clique em Ok em caso de confirmação.')){ document.getElementById('bbh_flu_codigo_f').value = '<?php echo $bbh_flu_codigo; ?>'; <?php echo $acaoRem; ?>}"><img src="/corporativo/servicos/bbhive/images/cancelar.gif" width="18" height="18" border="0" align="absmiddle" /></a></td>
  </tr>
  <?php } ?>
  <?php if($totalRows_rela == 0){ ?>
  <tr>
    <td height="26" colspan="4" bgcolor="#FFFFFF" class="legandaLabel12"><span class="color">N&atilde;o h&aacute; registros relacionados</span></td>
  </tr>
  <?php } ?>
</table>
