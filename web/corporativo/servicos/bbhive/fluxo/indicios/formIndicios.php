<table width="510" border="0" cellspacing="0" cellpadding="0" style="border:#E1E1E1 solid 1px;margin-bottom:10px;">
  <tr>
    <td height="25" colspan="2" style="border-bottom:#E1E1E1 solid 1px;">
      <table width="100%" style="background:<?php if($realizado==0){ echo "#FFFFCC"; } else { echo "#DFEFDF"; } ?>; border:#FFF solid 1px; height:100%;" class="legandaLabel11">
      	<tr>
        	<td width="94%">&nbsp;<?php if(!isset($semImagem)){ ?><img src="/corporativo/servicos/bbhive/images/detalhesIndicios.gif" width="16" height="16" align="absbottom"><?php } ?>&nbsp;<strong style="color:#339900">Gerenciamento deste ind&iacute;cio
        	  <input name="realizado_<?php echo $cod; ?>" type="hidden" id="realizado_<?php echo $cod; ?>" value="<?php if($realizado==1){ echo 1; } else { echo 0; } ?>">
        	</strong></td>
        	<td width="6%" align="center"><?php if(!isset($semAnexo)){?><a href="#@" onClick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/editar.php','indicio','?bbh_ind_codigo=<?php echo $cod; ?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>','Carregando informa&ccedil;&otilde;es...','indicio','2','2');"><img src="/corporativo/servicos/bbhive/images/editar.gif" width="17" height="17" border="0" title="Atualizar informações deste indício"></a><?php } ?></td>
      	</tr>
      </table>  
    </td>
  </tr>
  <tr>
    <td width="231" height="22" align="left" valign="middle">&nbsp;<?php if($realizado==1){ echo "<strong>Exame efetuado</strong>"; } else { echo "Exame não efetuado"; } ?></td>
    <td width="277" align="left" valign="middle">
    <div id="dtExame_<?php echo $cod; ?>" style="display:<?php if($realizado==1){ echo "block"; } else { echo "none"; } ?>">
    Data do exame :&nbsp;<?php echo !empty($row_ind['bbh_ind_dt_exame']) ? arrumadata(substr($row_ind['bbh_ind_dt_exame'],0,10)) : "---";?></div></td>
  </tr>
  <tr>
    <td height="1" colspan="2">
    	<div style="display:<?php if($realizado==1){ echo "block"; } else { echo "none"; } ?>; margin-left:3px;" id="qtdExame_<?php echo $cod; ?>">
        <strong>Responsável pela análise: <?php echo !empty($row_ind['profissional']) ? $row_ind['profissional'] : $row_ind['bbh_ind_profissional']; ?></strong>
                <div>&nbsp;</div>
        
		    Quantidade de procedimentos realizados:&nbsp;<strong><?php echo $row_ind['bbh_ind_qt_procedimento']; ?></strong> </div>
        </td>
  </tr>
  <tr>
    <td height="1" colspan="2" valign="top">
    <div style="display:<?php if($realizado==1){ echo "block"; } else { echo "none"; } ?>; margin-left:3px;margin-top:5px;" id="nmProcedimentos_<?php echo $cod; ?>">
    	<u>Procedimentos realizados :</u><br>
        <span style="color:#339900">
        <strong><?php echo $row_ind['bbh_ind_procedimentos']; ?></strong>
        </span>
    </div>
    </td>
  </tr>
  </table>
