<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#99FFFF">
  <tr>
    <td height="26" colspan="2" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/acao.gif" border="0" align="absmiddle" />&nbsp;<strong>O que voc&ecirc; deseja fazer?</strong></td>
  </tr>
  <?php if(!isset($bbh_flu_codigo_p)){ /*?>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/fluxograma.gif" width="18" height="20" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<?php <a href="#@" onclick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/consulta/regra.php?bbh_interface_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>&','loadFluxo','','Aguarde','loadFluxo','2','2')" title="Clique para visualizar o fluxograma na interface rica">Interface rica</a></td>
  </tr>*/?>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/visualizar_indicio.gif" width="16" height="16" border="0" align="absmiddle"/></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="return showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar todos os detalhes deste <?php echo $_SESSION['FluxoNome']; ?>">Visualizar todos os detalhes</a></td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/relacao.gif" width="16" height="16" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php?bbh_flu_codigo_p=<?php echo $row_Fluxo['bbh_flu_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para relacionar <?php echo $_SESSION['FluxoNome']; ?> a partir deste">Relacionar <?php echo $_SESSION['FluxoNome']; ?> a partir deste</a></td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/voltar.gif" width="14" height="15" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php?1=1<?php echo $compl; ?>','menuEsquerda|conteudoGeral');" title="Voltar para página de consultas">Ir para p&aacute;gina de consulta de <?php echo $_SESSION['FluxoNome']; ?></a></td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/imprimir.gif" width="16" height="16" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="document.imprime.submit();">Imprimir somente este <?php echo $_SESSION['FluxoNome']; ?> e <?php echo($_SESSION['ProtNome']); ?></a></td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/imprimir.gif" width="16" height="16" /></td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="document.imprimeCompleto.submit();">Imprimir todos os <?php echo $_SESSION['FluxoNome']; ?> relacionados a este e <?php echo($_SESSION['ProtNome']); ?></a></td>
  </tr>
  <tr>
    <td width="23" height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">
    <?php if($CriouRelatorio==1){ ?>
    	<img src="/corporativo/servicos/bbhive/images/download.gif" alt="Download do arquivo" width="17" height="17" border="0">
    <?php } else {?>
    	<img src="/corporativo/servicos/bbhive/images/downloadOFF.gif" alt="Não há arquivos" width="17" height="17" border="0">
    <?php } ?>
    </td>
    <td width="577" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<?php if($CriouRelatorio==1){

			$query_relatorios = "SELECT bbh_relatorio.bbh_usu_codigo, bbh_rel_protegido FROM bbh_relatorio 
				inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo
				WHERE bbh_flu_codigo = $bbh_flu_codigo and bbh_rel_pdf='1' 
					GROUP BY bbh_relatorio.bbh_rel_codigo order by bbh_rel_codigo desc LIMIT 0,1";
            list($relatorios, $row_relatorios, $totalRows_relatorios) = executeQuery($bbhive, $database_bbhive, $query_relatorios);
		//--
	  	if($_SESSION['usuCod'] == $row_relatorios['bbh_usu_codigo']){//Sou dono então não tenho restrição
			echo '<a href="#@" onclick="document.actionDownloadPDF.submit();">Fazer download do Relat&oacute;rio</a>';
		} elseif($row_relatorios['bbh_rel_protegido'] == '0'){//Não dou o dono só exibo se não tiver protegido
			echo '<a href="#@" onclick="document.actionDownloadPDF.submit();">Fazer download do Relat&oacute;rio</a>';
		} else {//Não sou o dono e está protegido
			echo '<span style="color:#999">Download protegido pelo autor</span>';
		}
		?>
    <?php } else { ?>
    	<span style="color:#999">Não existe arquivos a serem baixados</span>
    <?php } ?>
    </td>
  </tr>
  <?php //if($row_Fluxo['bbh_flu_finalizado']=='1'){ ?>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12"><img src="/corporativo/servicos/bbhive/images/painel/enviar.gif" alt="" width="16" height="16" /></td>
    <td bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;<a href="#@" onclick="document.enviaProtocolo.submit();">Solicitar/enviar resultado/informa&ccedil;&otilde;es do <?php echo $_SESSION['FluxoNome']; ?> para outro departamento</a></td>
  </tr>
  <?php //} ?>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
  </tr>
  <?php } else { ?>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
    <td align="center" bgcolor="#FFFFFF" class="legandaLabel12">
    <?php if($row_confRel['total'] > 0){ ?>
    	<span style="color:#F00; font-size:15px;">
    		ESTES <?php echo strtoupper($_SESSION['FluxoNome']); ?> JÁ ESTÃO RELACIONADOS!
     	</span>
    <?php } else { ?>
    <input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/relacao.gif);background-repeat:no-repeat;background-position:left;height:23px;width:200px;margin-right:5px; cursor:pointer;background-color:#FFFFFF; font-weight:bold" type="button" class="back_input" id="cadastrar2" value="&nbsp;Relacionar <?php echo $_SESSION['FluxoNome']; ?>" onclick="if(confirm('Tem certeza que deseja relacionar os dois <?php echo $_SESSION['FluxoNome']; ?>?\n        Clique em OK em caso de confirmação.')){ <?php echo $acaoAdd; ?> }"/>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="legandaLabel12">&nbsp;</td>
  </tr>
  <?php } ?>
  </table>
<label id="loadFluxo" class="legandaLabel12">&nbsp;</label>

<form name="actionDownloadPDF" id="actionDownloadPDF" action="/corporativo/servicos/bbhive/relatorios/painel/download.php" target="_blank" method="post">
	<input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
    <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $row_rel['bbh_rel_codigo']; ?>" />
</form>

<form name="imprime" id="imprime" action="/corporativo/servicos/bbhive/consulta/includes/impressao.php" target="_blank" method="post">
	<input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
</form>
<form name="imprimeCompleto" id="imprimeCompleto" action="/corporativo/servicos/bbhive/consulta/includes/impressaoCompleta.php" target="_blank" method="post">
	<input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
</form>

<form name="removeVinculo" id="removeVinculo">
<input type="hidden" name="bbh_flu_codigo_p" id="bbh_flu_codigo_p" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
<input type="hidden" name="bbh_flu_codigo_f" id="bbh_flu_codigo_f" value="" />
</form>

<form name="AdicionaVinculo" id="AdicionaVinculo">
<input type="hidden" name="bbh_flu_codigo_p" id="bbh_flu_codigo_p" value="<?php echo @$bbh_flu_codigo_p; ?>" />
<input type="hidden" name="bbh_flu_codigo_f" id="bbh_flu_codigo_f" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
<input type="hidden" name="AdicionaRelacao" id="AdicionaRelacao" value="1" />
</form>

<?php //if($row_Fluxo['bbh_flu_finalizado']=='1'){
	//Data da ultima atividade
	$query_strUltima = "select bbh_ati_final_real from bbh_atividade Where bbh_flu_codigo=$bbh_flu_codigo ORDER BY bbh_ati_codigo desc LIMIT 1";
    list($strUltima, $row_strUltima, $totalRows_ultima) = executeQuery($bbhive, $database_bbhive, $query_strUltima);
	//--
	?>
<form name="enviaProtocolo" id="enviaProtocolo" method="post" action="/servicos/bbhive/protocolos/enviaProtocolo.php" target="_blank" style="display:none">
<input name="bbh_pro_flagrante" type="text" value="<?php echo @$nv_bbh_pro_flagrante;?>" />
<input name="bbh_flu_pai" type="text" value="<?php echo $row_Fluxo['bbh_flu_codigo']; ?>" />
<input name="bbh_pro_identificacao" type="text" id="bbh_pro_identificacao" value="<?php echo isset($nv_bbh_pro_identificacao) ? $nv_bbh_pro_identificacao : '';?>"/>
<input name="bbh_pro_autoridade" type="text" id="bbh_pro_autoridade" value="<?php echo $nv_bbh_pro_autoridade;?>" />
<input name="bbh_pro_titulo" type="text" id="bbh_pro_titulo" value="<?php echo @$nv_bbh_pro_titulo;?>" />
<input name="bbh_pro_data" type="text" id="bbh_pro_data" value="<?php echo @$nv_bbh_pro_data;?>" />
<textarea class="formulario2" name="bbh_pro_descricao" id="bbh_pro_descricao"><?php
	echo "Código:". $row_Fluxo['bbh_flu_codigo']."\r\n";
	echo "Título:". $row_Fluxo['bbh_flu_titulo']."\r\n";
	echo "Tipo:". normatizaCep($row_Fluxo['bbh_tip_flu_identificacao'])."&nbsp;".$row_Fluxo['bbh_tip_flu_nome']."\r\n";
	echo "Origem:". $row_Fluxo['bbh_dep_nome']."\r\n";
	echo "Distribuído por:". (array_key_exists('bbh_usu_nome', $row_Fluxo) ? $row_Fluxo['bbh_usu_nome'] : '')."\r\n";
	echo "Iniciado em:". $row_Fluxo['bbh_flu_data_iniciado']."\r\n";
	echo "Finalizado em:". arrumadata($row_strUltima['bbh_ati_final_real'])."\r\n";
?>
========
<?php echo isset($nv_bbh_pro_descricao) ? $nv_bbh_pro_descricao : '';?>
</textarea>
<br />
</form>
<?php //} ?>