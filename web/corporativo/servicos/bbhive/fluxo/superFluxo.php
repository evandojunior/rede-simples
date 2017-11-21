	<?php
	$bbh_flu_codigo = $codigoFluxo;
	
	//verifico se tenho subfluxos
	$query_fluxoPai = "select bbh_flu_codigo from bbh_fluxo Where bbh_flu_tarefa_pai=$bbh_flu_codigo";
    list($fluxoPai, $row_fluxoPai, $totalRows_fluxoPai) = executeQuery($bbhive, $database_bbhive, $query_fluxoPai);
 
 		if($totalRows_fluxoPai>0){
                //descobre o Fluxo desta atividade
                $query_SuperFluxo =  "select bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, 	
                                bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,
                                 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido
                                    from bbh_fluxo 
                                
                                inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
                                inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
                                inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
                                inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
                                
                                    Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
                                        group by bbh_fluxo.bbh_flu_codigo
                                            order by bbh_flu_codigo desc LIMIT 0,1";
                list($SuperFluxo, $row_SuperFluxo, $totalRows_SuperFluxo) = executeQuery($bbhive, $database_bbhive, $query_SuperFluxo);
    ?>
<table width="410" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#E0DFE3" style="cursor:pointer" title="Clique para verificar os detalhes deste fluxo" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=1|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');">
                            <tr>
                              <td height="19" colspan="3" background="/corporativo/servicos/bbhive/images/back_flux.gif" style="border-bottom:#999999 solid 1px;">&nbsp;<strong><?php echo $_SESSION['FluxoNome']; ?> - <?php echo $row_SuperFluxo['bbh_flu_titulo']; ?></strong></td>
                            </tr>

                            <tr>
                              <td width="91" height="22" align="right" bgcolor="#FCF0DD"><strong>Tipo :&nbsp;</strong></td>
                              <td colspan="2" bgcolor="#FDF7EE">&nbsp;<?php echo normatizaCep($row_SuperFluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_SuperFluxo['bbh_mod_flu_nome']; ?></td>
                            </tr>
                            <tr>
                              <td height="22" align="right" bgcolor="#FCF0DD"><strong>Iniciado em :&nbsp;</strong></td>
                              <td width="228" bgcolor="#FDF7EE">&nbsp;<?php echo $row_SuperFluxo['bbh_flu_data_iniciado']; ?>          </td>
                              <td width="87" bgcolor="#FDF7EE" align="left">
                            <table width="<?php echo $row_SuperFluxo['concluido']; ?>%" align="left" cellpadding="0" cellspacing="0">
                                <tr>
                             <td height="20" bgcolor="#<?php if($row_SuperFluxo['concluido']=="0"){ echo "cccccc"; } else { echo "999999";}  ?>" class="verdana_9" align="center" title="<?php echo $row_SuperFluxo['concluido']; ?>% conclu&iacute;do" style="color:#FFFFFF"><?php echo $row_SuperFluxo['concluido']; ?>%</td>
                                </tr>
                            </table>                              </td>
                            </tr>
                          </table>
	<?php }
 ?>