<?php if($bbh_flu_codigo>0){ ?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="26" colspan="5" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/relacionados.gif" border="0" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['FluxoNome']; ?> relacionado</strong></td>
  </tr>
  <?php //while($row_rela = mysqli_fetch_assoc($rela)){
         //$bbh_flu_codigo = $row_rela['codigo'];
		//descobre o Fluxo desta atividade
		$query_Fluxo =  "select bbh_usu_apelido, bbh_fluxo.bbh_flu_codigo, bbh_mod_ati_codigo, bbh_fluxo.bbh_mod_flu_codigo, DATE_FORMAT(bbh_flu_data_iniciado, '%d/%m/%Y') as bbh_flu_data_iniciado, bbh_flu_titulo, bbh_flu_autonumeracao, bbh_flu_anonumeracao,
						bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_tip_flu_nome, bbh_flu_observacao,
						 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome, MAX(bbh_ati_final_previsto) as final
							from bbh_fluxo 
						
						inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
						inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
						inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
						inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
						inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
						inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
							Where bbh_fluxo.bbh_flu_codigo = $bbh_flu_codigo
								group by bbh_fluxo.bbh_flu_codigo
									order by bbh_flu_codigo desc LIMIT 0,1";
        list($Fluxo, $row_Fluxo, $totalRows_Fluxo) = executeQuery($bbhive, $database_bbhive, $query_Fluxo);
//--
	$nomeFluxo 		= $row_Fluxo['bbh_mod_flu_nome'];
	$autoNumeracao	= $row_Fluxo['bbh_flu_autonumeracao'];
	$tipoProcesso	= explode(".",$row_Fluxo['bbh_tip_flu_identificacao']);
	$tipoProcesso	= (int)$tipoProcesso[0];
	$anoNumeracao	= $row_Fluxo['bbh_flu_anonumeracao'];
	//--
	$numeroProcesso	= $nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
	//--
//--	
		
		$msg = $row_Fluxo['concluido']."% conclu&iacute;do";

	$query_rel = "select MAX(r.bbh_rel_codigo) as bbh_rel_codigo from bbh_protocolos as p
				  inner join bbh_fluxo as f on p.bbh_flu_codigo = f.bbh_flu_codigo
				  inner join bbh_atividade as a on f.bbh_flu_codigo = a.bbh_flu_codigo
				  inner join bbh_modelo_atividade as ma on a.bbh_mod_ati_codigo = ma.bbh_mod_ati_codigo
				  inner join bbh_relatorio as r on a.bbh_ati_codigo = r.bbh_ati_codigo
				   Where ma.bbh_mod_ati_relatorio = '1' AND r.bbh_rel_pdf='1' AND p.bbh_pro_codigo = $bbh_pro_codigo";
    list($rel, $row_rel, $totalRows_rel) = executeQuery($bbhive, $database_bbhive, $query_rel);
	$CriouRelatorio = $row_rel['bbh_rel_codigo'] > 0 ? 1 : 0;
	$cd = "";
		if($CriouRelatorio == 1){
			$cd = $row_rel['bbh_rel_codigo'];
		}
  	?>
  <tr>
    <td height="26" colspan="2" align="left" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><strong>Distr&iacute;buido por:</strong>&nbsp;<?php echo $row_Fluxo['bbh_usu_apelido']; ?></td>
    <td colspan="2" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>Em:</strong>&nbsp;<?php echo $row_Fluxo['bbh_flu_data_iniciado']; ?></td>
    <td align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;">&nbsp;</td>
  </tr>
  <tr>
    <td width="27" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/nome.gif" width="16" height="16" border="0" align="absmiddle" /></td>
    <td width="276" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><strong>&nbsp;C&oacute;d. <?php echo $bbh_flu_codigo; ?></strong><strong  style="color:#F60"> - <?php echo $numeroProcesso; ?></strong></td>
    <td width="249" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;"><img src="/corporativo/servicos/bbhive/images/numero.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;<strong style="color:#36C"><?php echo $row_Fluxo['bbh_flu_titulo']; ?></strong>
    
    </td>
    <td width="21" align="center" bgcolor="#FFFFFF" class="legandaLabel11" style="border-bottom:#CCC solid 1px;">
    	<?php if($CriouRelatorio == 1){ 

			$query_relatorios = "SELECT bbh_relatorio.bbh_usu_codigo, bbh_rel_protegido FROM bbh_relatorio 
				inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo
				WHERE bbh_rel_codigo = $cd and bbh_rel_pdf='1' 
					GROUP BY bbh_relatorio.bbh_rel_codigo order by bbh_rel_codigo desc LIMIT 0,1";
            list($relatorios, $row_relatorios, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relatorios);
		//--	
		
			if($_SESSION['usuCod'] == $row_relatorios['bbh_usu_codigo']){//Sou dono então não tenho restrição
				echo '<a href="#@" onclick="document.actionDownloadPDF'.$cd.'.submit();"><img src="/corporativo/servicos/bbhive/images/mime-pdf.gif" title="Efetuar download deste relat&oacute;rio" width="16" height="16" border="0" align="absmiddle" /></a>';
			} elseif($row_relatorios['bbh_rel_protegido'] == '0'){//Não dou o dono só exibo se não tiver protegido
				echo '<a href="#@" onclick="document.actionDownloadPDF'.$cd.'.submit();"><img src="/corporativo/servicos/bbhive/images/mime-pdf.gif" title="Efetuar download deste relat&oacute;rio" width="16" height="16" border="0" align="absmiddle" /></a>';
			} else {//Não sou o dono e está protegido
				echo '<img src="/corporativo/servicos/bbhive/images/mime-pdfOFF.gif" width="16" height="16" border="0" align="absmiddle" />';
				$protegido = true;	
			}

		 } else { ?>
      <img src="/corporativo/servicos/bbhive/images/mime-pdfOFF.gif" width="16" height="16" border="0" align="absmiddle" />
		<?php } ?>
    </td>
    <td width="27" align="center" bgcolor="#FFFFFF" class="legandaLabel12" style="border-bottom:#CCC solid 1px;"><a href="#@" onClick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&exibeAtividade=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar o resumo deste <?php echo $_SESSION['FluxoNome']; ?>"><img src="/corporativo/servicos/bbhive/images/visualizar_indicio.gif" width="16" height="16" border="0" align="absmiddle"/></a></td>
  </tr>
  <?php //} ?>
</table>
<br>
<form name="actionDownloadPDF<?php echo $cd; ?>" id="actionDownloadPDF<?php echo $cd; ?>" action="/corporativo/servicos/bbhive/relatorios/painel/download.php" target="_blank" method="post">
    <input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
    <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $cd; ?>" />
</form>
<?php } ?>