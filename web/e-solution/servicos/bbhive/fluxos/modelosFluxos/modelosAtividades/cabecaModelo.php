<?php
 if(isset($_GET['bbh_mod_flu_codigo'])){
 	$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
 } else {
 	$bbh_mod_flu_codigo = $bbh_mod_flu_codigo;
 }
	$query_modFluxos = "select bbh_mod_flu_codigo, bbh_tipo_fluxo.bbh_tip_flu_codigo, bbh_mod_flu_nome, bbh_mod_flu_sub
      , bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_mod_flu_observacao
			 from bbh_modelo_fluxo
				  inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
				  Where bbh_mod_flu_codigo = $bbh_mod_flu_codigo";
    list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="3%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
        <td width="71%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>T&iacute;tulo de <?php echo $_SESSION['adm_FluxoNome']; ?></strong></td>
        <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center" id="loadFluxo">&nbsp;</td>
        <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center"><a href="#@" title="Clique para visualizar o Fluxograma" onclick="return OpenAjaxPostCmd('/e-solution/servicos/bbhive/fluxos/modelosFluxos/index.php?bbh_interface_codigo=<?php echo $row_modFluxos['bbh_mod_flu_codigo']; ?>&','loadFluxo','','Aguarde','loadFluxo','2','2')"><img src="/e-solution/servicos/bbhive/images/fluxograma_mini.gif" align="absmiddle" border="0"/></a></td>
      </tr>
<?php $codModelo = $row_modFluxos['bbh_mod_flu_codigo'];
		//perfis adicionados no modelo
		$query_perAdd = "select count(bbh_per_flu_codigo) as total from bbh_permissao_fluxo Where bbh_mod_flu_codigo=$codModelo";
        list($perAdd, $row_perAdd, $totalRows_perAdd) = executeQuery($bbhive, $database_bbhive, $query_perAdd);
		
		//atividades adicionadas no modelo
		$query_atiAdd = "select count(bbh_mod_ati_codigo) as total from bbh_modelo_atividade Where bbh_mod_flu_codigo=$codModelo";
        list($atiAdd, $row_atiAdd, $totalRows_atiAdd) = executeQuery($bbhive, $database_bbhive, $query_atiAdd);
	?>
      <tr class="legandaLabel11">
        <td height="25" align="center">
        <?php if($row_modFluxos['bbh_mod_flu_sub']=="1"){ ?>
        	<img src="/e-solution/servicos/bbhive/images/282.gif" border="0" />
        <?php } else { ?>
        	<img src="/e-solution/servicos/bbhive/images/setaII.gif" border="0" />
        <?php } ?>        </td>
        <td>&nbsp;<?php echo $row_modFluxos['bbh_mod_flu_nome']; ?></td>
        <td width="9%" align="center"><a href="#@" title="<?php echo $row_perAdd['total']; ?> perfi(s) cadastrado(s)">
       <?php if($row_perAdd['total']>0){ ?> 
        <img src="/e-solution/servicos/bbhive/images/cadeado.gif" border="0" align="absmiddle" /> 
       <?php } else { ?>
        <img src="/e-solution/servicos/bbhive/images/cadeado_off.gif" border="0" align="absmiddle" />
       <?php } ?><label id="totPermi"><?php echo $row_perAdd['total']; ?></label></a></td>
        <td width="9%" align="center">
        <a href="#@" title="<?php echo $row_atiAdd['total']; ?> atividade(s) cadastrada(s)"><img src="/e-solution/servicos/bbhive/images/atividades.gif" border="0" align="absmiddle" /> <?php echo $row_atiAdd['total']; ?></a></td>
  </tr>
      <tr class="legandaLabel11">
        <td height="25" align="center">&nbsp;</td>
        <td colspan="3" class="legandaLabel10">tipo <?php echo $_SESSION['adm_FluxoNome']; ?>: <span class="color"><?php echo normatizaCep($row_modFluxos['bbh_tip_flu_identificacao'])."&nbsp;".$row_modFluxos['bbh_tip_flu_nome']; ?></span></td>
      </tr>
      <tr class="legandaLabel11">
        <td height="25" align="center">&nbsp;</td>
        <td colspan="3" class="legandaLabel10"><?php echo nl2br($row_modFluxos['bbh_mod_flu_observacao']); ?></td>
      </tr>
      <tr>
        <td height="1" colspan="4" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
      <tr class="legandaLabel11">
        <td height="5" colspan="4" align="center"></td>
      </tr>
    </table>
<form name="executaInterfaceRica" id="executaInterfaceRica" method="get" action="/e-solution/servicos/bbhive/fluxograma/interface_rica/index.php" target="_blank">
</form>