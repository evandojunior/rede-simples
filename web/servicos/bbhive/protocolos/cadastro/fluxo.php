<?php if(!isset($_SESSION)){ session_start(); } 

	//verifica se a atividade foi lida
		$CodFluxo = $codFluxo;
	
	//descobre o Fluxo desta atividade
	$query_Fluxo =  "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_flu_observacao,
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, MAX(bbh_ati_final_previsto) as final, bbh_usu_nome, bbh_flu_finalizado
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						Where bbh_fluxo.bbh_flu_codigo = $CodFluxo
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
    list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
	
	$msg = $row_Fluxo['concluido']."% conclu&iacute;do";
?>
<fieldset style="margin-top:2px; margin-bottom:2px;">
  <legend class="legandaLabel11">Informa&ccedil;&otilde;es do <?php echo $_SESSION['FluxoNome']; ?></legend>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11" style="margin-top:10px; font-size:10px;">
  <tr>
    <td width="20" height="25" class="titulo_setor" align="center"><img src="/corporativo/servicos/bbhive/images/visualizar.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td colspan="2" class="titulo_setor legandaLabel12">&nbsp;<strong>Dados b&aacute;sicos</strong></td>
    <td width="137" rowspan="2">
      <fieldset style="margin-top:2px; margin-bottom:2px;">
        <legend class="legandaLabel11"></legend>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11" style="font-size:10px;">
          <tr>
            <td width="12%" height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td width="88%" height="25">&nbsp;<strong>Iniciado em &nbsp;<span style="color:#F60"><?php echo $dt=$row_Fluxo['bbh_flu_data_iniciado']; ?></span></strong></td>
            </tr>
          <tr>
            <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/calendar.gif" border="0" align="absmiddle"></td>
            <td height="25">&nbsp;<strong>Final previsto &nbsp;<span style="color:#F60"><?php echo $dt=arrumadata($row_Fluxo['final']); ?></span></strong></td>
            </tr>
          </table>
        </fieldset>
    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>C&oacute;digo :&nbsp;</strong></td>
    <td width="260">&nbsp;<span class="color"><strong><?php echo $row_Fluxo['bbh_flu_codigo']; ?></strong></span></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>T&iacute;tulo :&nbsp;</strong></td>
    <td colspan="2">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_flu_titulo']; ?></span></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Tipo :&nbsp;</strong></td>
    <td colspan="2">&nbsp;<span class="color"><?php echo normatizaCep($row_Fluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxo['bbh_tip_flu_nome']; ?></span></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Origem :&nbsp;</strong></td>
    <td colspan="2">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_dep_nome']; ?></span></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Distribu&iacute;do por :&nbsp;</strong></td>
    <td colspan="2">&nbsp;<span class="color"><?php echo $row_Fluxo['bbh_usu_nome']; ?></span></td>
    </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Situa&ccedil;&atilde;o :&nbsp;</strong></td>
    <td>&nbsp;<span class="color"><?php echo $row_Fluxo['concluido']; ?>%</span></td>
    <td width="137" align="left" valign="top"></td>
  </tr>
  <tr>
    <td height="5"><span style="font-size:4px;">&nbsp;</span></td>
    <td width="83"><span style="font-size:4px;">&nbsp;</span></td>
    <td colspan="2"><span style="font-size:4px;">&nbsp;</span></td>
  </tr>
</table>
</fieldset>