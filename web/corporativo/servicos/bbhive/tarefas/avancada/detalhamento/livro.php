<?php
//CAMPOS DE DETALHAMENTO
	$query_Campos = "select 
					 bbh_cam_det_flu_codigo,
					 bbh_cam_det_flu_nome,
					 bbh_cam_det_flu_titulo,
					 bbh_cam_det_flu_tipo,
					 bbh_cam_det_flu_tamanho
					 from bbh_detalhamento_fluxo 
					 inner join bbh_campo_detalhamento_fluxo on bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo
					  Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
    list($Campos, $rows, $totalRows_Campos) = executeQuery($bbhive, $database_bbhive, $query_Campos, $initResult = false);
//======================
?>
<table width="595" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
   <?php while($row_Campos = mysqli_fetch_assoc($Campos)){ 
		   $CodigoCampo = $row_Campos['bbh_cam_det_flu_codigo'];
		   $tituloCampo	= $row_Campos['bbh_cam_det_flu_titulo'];
		   $nomeCampo	= $row_Campos['bbh_cam_det_flu_nome'];
		   $tipoCampo	= $row_Campos['bbh_cam_det_flu_tipo']; 
   	  ?>   
      <tr>
        <td width="33" height="23" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="chk_<?php echo $CodigoCampo; ?>" id="chk_<?php echo $CodigoCampo; ?>" onClick="javascript: computaSelecao('chk_<?php echo $CodigoCampo; ?>')" />
        </label></td>
        <td width="562" align="left" bgcolor="#FFFFFF" class="verdana_11">&nbsp;<?php echo $tituloCampo; ?><input name="nm_campo_<?php echo $CodigoCampo; ?>" id="nm_campo_<?php echo $CodigoCampo; ?>" type="hidden" value="<?php echo $nomeCampo; ?>">
        <input name="tp_campo_<?php echo $CodigoCampo; ?>" id="tp_campo_<?php echo $CodigoCampo; ?>" type="hidden" value="<?php echo $tipoCampo; ?>">
        
        <input name="apelido_<?php echo $CodigoCampo; ?>" id="apelido_<?php echo $CodigoCampo; ?>" type="hidden" value="<?php echo $tituloCampo; ?>">
        </td>
      </tr>
      <tr>
        <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
	<?php } 
	if($totalRows_Campos==0){?>
      <tr>
        <td height="25" colspan="2" align="center" bgcolor="#EFEFE7">N&atilde;o h&aacute; campos neste modelo</td>
    </tr>
    <?php } ?>
</table>
	<?php
	if($totalRows_Campos==0){?>
<var style="display:none">document.getElementById('temExportacao').style.display='none';document.getElementById('opcaoExporta').style.display='none';</var>
	<?php } else { ?>
<var style="display:none">document.getElementById('bbh_mod_flu_codigo').value='<?php echo $_GET['bbh_mod_flu_codigo']; ?>';</var>
    <?php } ?>