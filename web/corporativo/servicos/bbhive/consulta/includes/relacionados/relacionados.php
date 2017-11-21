<?php
	$query_rela = "	select * from (
						select bbh_flu_codigo_f as codigo from bbh_fluxo_relacionado
						 where bbh_flu_codigo_p = ".$bbh_flu_codigo."
					 UNION 
						select bbh_flu_codigo_p as codigo from bbh_fluxo_relacionado
						 where bbh_flu_codigo_f = ".$bbh_flu_codigo."
					  ) as relacionados
						order by codigo asc";
    list($rela, $rows, $totalRows_rela) = executeQuery($bbhive, $database_bbhive, $query_rela, $initResult = false);
?>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="4" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/relacionados.gif" border="0" align="absmiddle" />&nbsp;<strong>(<?php echo $totalRows_rela; ?>) <?php echo $_SESSION['FluxoNome']; ?> relacionados</strong></td>
  </tr>

  <tr>
    <td height="26" align="center" bgcolor="#F9F9F9" class="legandaLabel12" style="border-bottom:#CCC solid 1px;">&nbsp;</td>
    <td bgcolor="#F9F9F9" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>C&oacute;digo - Tipo</strong></td>
    <td bgcolor="#F9F9F9" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>T&iacute;tulo</strong></td>
    <td align="center" bgcolor="#F9F9F9" class="legandaLabel12" style="border-bottom:#CCC solid 1px;">&nbsp;</td>
  </tr>
  <?php while($row_rela = mysqli_fetch_assoc($rela)){
         $bbh_flu_codigo = $row_rela['codigo'];
			 include("cabecaFluxo.php");
  	?>  
  <tr>
    <td width="29" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="282" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>&nbsp;<?php echo $bbh_flu_codigo; ?></strong><strong  style="color:#F60"> - <?php echo $row_Modelo['bbh_mod_flu_nome']." - ".$row_Modelo['bbh_flu_autonumeracao']."/".$row_Modelo['bbh_flu_anonumeracao']; ?></strong></td>
    <td width="265" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<strong style="color:#36C"><?php echo $row_CabFluxo['bbh_flu_titulo']; ?></strong></td>
    <td width="24" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;">&nbsp;</td>
  </tr>
  <?php } ?>
  <?php if($totalRows_rela == 0){ ?>
  <tr>
    <td height="26" colspan="4" bgcolor="#FFFFFF" class="legandaLabel12"><span class="color">N&atilde;o h&aacute; registros relacionados</span></td>
  </tr>
  <?php } ?>
</table>
