<?php //--AGUARDANDO VALIDAÇÃO DE DADOS COM BASE NO XML

	$icones_disponíveis = array();
	//--
	$nomeElementos = "ico_Fluxo,ico_Tarefas,ico_Mensagens,ico_Atribuicao,ico_Ged,ico_Fluxograma,ico_Relatorio";
	//--
	//--Descrição do Fluxo
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Descrição ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_fluxo'; ".$acaoDetal.";this.className = 'ico_Fluxo_Selecionado'; desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Fluxo_Inativo' id='ico_Fluxo'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Descrição ".$_SESSION['FluxoNome']."</td>
		  </tr>
		</table>
	</div>";

	//--Tarefas/Atividades
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique e confira todos os detalhes desta atividade - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_atividade';".$acaoDetal.";this.className = 'ico_Tarefas_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Tarefas_Inativo' id='ico_Tarefas'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Descri&ccedil;&atilde;o da atividade</td>
		  </tr>
		</table>
	</div>";
	
	//--Mensagens - BASEADO NO XML
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para comentar esta atividade - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_historico';".$acaoDetal.";this.className = 'ico_Mensagens_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Mensagens_Inativo' id='ico_Mensagens'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Coment&aacute;rio da atividade</td>
		  </tr>
		</table>
	</div>";

	//SOU CHEFE POSSO TUDO
	$_SESSION['euChefe'] = $atividade->usuChefe;
	$_SESSION['quem']	 = $atividade->usuarioAtividade;
	
	//--Atribuir atividade
	if(($atividade->usuChefe==$_SESSION['usuCod']) || (($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($atividade->status!=2) && ($tarPredec==0) && ($atividade->bbh_flu_finalizado=='0'))){
		$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para atribuir esta atividade a outro profissional - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_atribuir';".$acaoDetal.";this.className = 'ico_Atribuicao_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Atribuicao_Inativo' id='ico_Atribuicao'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Atribuir atividade</td>
		  </tr>
		</table>
	 </div>";
	}
	
	//--FLUXO
	 if(($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($atividade->status!=2)&&($tarPredec==0)&&($atividade->bbh_flu_finalizado=='0')){
		$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para iniciar ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_iniciar';".$acaoDetal.";this.className = 'ico_Fluxograma_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Fluxograma_Inativo' id='ico_Fluxograma'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Iniciar ". $_SESSION['FluxoNome']."</td>
		  </tr>
		</table>
	  </div>";
	 }
	
	//--GED
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para gerenciar os arquivos - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_arquivos';".$acaoDetal.";this.className = 'ico_Ged_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Ged_Inativo' id='ico_Ged'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>(".$row_GED['total'].") Arquivos</td>
		  </tr>
		</table>
	</div>";
	
	//--Relatório
	if(($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($tarPredec==0)&&($subFilho==0)&&($atividade->status!=2)&&($atividade->bbh_flu_finalizado=='0')&&($atividade->bbh_mod_ati_relatorio=='1')/*&&($relFinalizado==0)*/){
		$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para gerenciar ".$_SESSION['relNome']." - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"document.getElementById('acaoDaVez').value='aba_relatorio';".$acaoDetal.";this.className = 'ico_Relatorio_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Relatorio_Inativo' id='ico_Relatorio'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Iniciar ".$_SESSION['relNome']."</td>
		  </tr>
		</table>
		</div>";
	}
//onclick=\"showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$atividade->codigoFluxo."&bbh_ati_codigo=".$bbh_ati_codigo."&exibeIndicios=true&paginaTarefas=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');this.className = 'ico_Indicios_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\"	
	//--Indícios - BASEADO NO XML
	$_SESSION['exibeIndicios'] = 1;
	if( isset($_SESSION['exibeIndicios']) && $_SESSION['exibeIndicios'] == 1){
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para visualizar os".$_SESSION['componentesNome']." - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\"  onclick=\"document.getElementById('acaoDaVez').value='aba_icidencia';".$acaoDetal.";this.className = 'ico_Incidencia_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\"  style='cursor:pointer; width:74px; height:61px;' class='ico_Indicios_Inativo' id='ico_Indicios'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>" .$_SESSION['componentesNome']."</td>
		  </tr>
		</table>
	</div>";
	}
	//echo $acaoDetal;
?>
<table width="98%" align="center" border="0" cellpadding="0" cellspacing="0" bgcolor="#F7F7F8">
  <tr>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
    <td width="73" height="1"></td>
  </tr>
  <tr>
	  <?php foreach($icones_disponíveis as $i=>$v){ ?>
        <td width="73" height="61" align="center" style="font-family:Verdana;font-size:10px"><?php echo $v; ?></td>
      <?php } ?>
  </tr>
  <tr>
    <td height="22" colspan="8" bgcolor="#FFFFFF" id="legenda" style="font-family:Tahoma;font-weight:bold; font-size:12px">&nbsp;</td>
  </tr>
</table>


<input type="hidden" name="aba_icidencia" id="aba_icidencia" value="escondeBloco('corpoTarefa','fluxo', 'titulo', '&nbsp;Fluxo', '/corporativo/servicos/bbhive/fluxo/index2.php?tarefas=true&bbh_ati_codigo=<?php echo $CodAtividade; ?>&bbh_flu_codigo=<?PHP echo $atividade->codigoFluxo; ?>&exibeIndicios=true');" />
<input type="hidden" name="aba_fluxo" id="aba_fluxo" value="escondeBloco('corpoTarefa','fluxo', 'titulo', '&nbsp;Fluxo', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerFluxo.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />

<input type="hidden" name="aba_atividade" id="aba_atividade" value="escondeBloco('corpoTarefa','atividade', 'titulo', '&nbsp;Atividade', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtividade.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />

<input type="hidden" name="aba_historico" id="aba_historico" value="escondeBloco('corpoTarefa','historico', 'titulo', '&nbsp;Coment&aacute;rios', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerComentario.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />

<input type="hidden" name="aba_atribuir" id="aba_atribuir" value="escondeBloco('corpoTarefa','atribuir', 'titulo', '&nbsp;Atribui&ccedil;&atilde;o', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtribuicao.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />

<input type="hidden" name="aba_iniciar" id="aba_iniciar" value="<?php echo $acaoFluxo; ?>" />

<input type="hidden" name="aba_arquivos" id="aba_arquivos" value="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?bbh_flu_codigo=<?php echo $atividade->codigoFluxo; ?>&bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');" />

<input type="hidden" name="aba_relatorio" id="aba_relatorio" value="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>','menuEsquerda|colPrincipal');" />

<?php /*
<table width="556">
    <tr>
        <td width="75" height="61" align="center" class="tbTarefas">
            <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_fluxo'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Detalhes do fluxo</span>] body=[<span class='verdana_11'>Clique para verificar todos os dados do fluxo</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnFluxo.gif" border="0" style="margin-left:10px;" /><br />
                    Descri&ccedil;&atilde;o do <?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?>
             </a>
    <input type="hidden" name="aba_fluxo" id="aba_fluxo" value="escondeBloco('corpoTarefa','fluxo', 'titulo', '&nbsp;Fluxo', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerFluxo.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />
        </td>
        <td width="75" height="61" align="center" class="tbTarefas">
            <a href="#" onclick="document.getElementById('acaoDaVez').value='aba_atividade'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Detalhes da atividade</span>] body=[<span class='verdana_11'>Clique e confira todos os detalhes desta atividade</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnAtiv.gif" border="0" style="margin-left:10px;" /><br />
                    Descri&ccedil;&atilde;o da atividade
             </a>
    <input type="hidden" name="aba_atividade" id="aba_atividade" value="escondeBloco('corpoTarefa','atividade', 'titulo', '&nbsp;Atividade', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtividade.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />
        </td>
        <td width="75" height="61" align="center" class="tbTarefas">
        <?php //if($atividade->bbh_flu_finalizado=='0'){ ?>
            <a href="#"  onclick="document.getElementById('acaoDaVez').value='aba_historico'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Comentar atividade</span>] body=[<span class='verdana_11'>Clique para comentar esta atividade</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnHisto.gif" border="0" style="margin-left:10px;" /><br />
                    Coment&aacute;rio da atividade
             </a>
    <input type="hidden" name="aba_historico" id="aba_historico" value="escondeBloco('corpoTarefa','historico', 'titulo', '&nbsp;Coment&aacute;rios', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerComentario.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />
         <?php /*} else { ?>
                <img src="/corporativo/servicos/bbhive/images/btnHistoOFF.gif" border="0" style="margin-left:10px;" /><br />
                    Coment&aacute;rio da atividade
         <?php } ?>    
        </td>
        <td width="75" height="61" align="center" class="tbTarefas">
        <?php 

	//if(($atividade->usuarioAtividade==$_SESSION['usuCod'] || $atividade->usuChefe==$_SESSION['usuCod'])){
		//if(($atividade->status!=2) && ($tarPredec==0) && ($atividade->bbh_flu_finalizado=='0')){ 
		
		//SOU CHEFE POSSO TUDO
		$_SESSION['euChefe'] = $atividade->usuChefe;
		$_SESSION['quem']	 = $atividade->usuarioAtividade;
		if($atividade->usuChefe==$_SESSION['usuCod']){ ?>
            <a href="#@"  onclick="document.getElementById('acaoDaVez').value='aba_atribuir'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Atribui&ccedil;&atilde;o de atividade</span>] body=[<span class='verdana_11'>Clique para atribuir esta atividade a outro profissional</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnAtri.gif" border="0" style="margin-left:10px;" /><br />
                    Atribuir atividade
             </a>
		<input type="hidden" name="aba_atribuir" id="aba_atribuir" value="escondeBloco('corpoTarefa','atribuir', 'titulo', '&nbsp;Atribui&ccedil;&atilde;o', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtribuicao.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />
		<?php } elseif( ($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($atividade->status!=2) && ($tarPredec==0) && ($atividade->bbh_flu_finalizado=='0')){
		
		?>
            <a href="#@"  onclick="document.getElementById('acaoDaVez').value='aba_atribuir'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Atribui&ccedil;&atilde;o de atividade</span>] body=[<span class='verdana_11'>Clique para atribuir esta atividade a outro profissional</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnAtri.gif" border="0" style="margin-left:10px;" /><br />
                    Atribuir atividade
             </a>
		<input type="hidden" name="aba_atribuir" id="aba_atribuir" value="escondeBloco('corpoTarefa','atribuir', 'titulo', '&nbsp;Atribui&ccedil;&atilde;o', '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtribuicao.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>');" />
         <?php } else { ?>
        <label title="Voc&ecirc; n&atilde;o tem permiss&atilde;o para atribuir esta atividade para outro profissional">
                <img src="/corporativo/servicos/bbhive/images/btnAtriOFF.gif" border="0" style="margin-left:10px;"/><br />
                    Atribuir atividade
        </label>
         <?php } ?>     
        </td>
        <td width="75" height="61" align="center" class="tbTarefas">
        <?php if(($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($atividade->status!=2)&&($tarPredec==0)&&($atividade->bbh_flu_finalizado=='0')){ ?>
            <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_iniciar'; <?php echo $acaoDetal; ?>">
                <img src="/corporativo/servicos/bbhive/images/btn_Start.gif" border="0" style="margin-left:10px;" /><br />
                    Iniciar<br /><?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?>
           </a>
		<input type="hidden" name="aba_iniciar" id="aba_iniciar" value="<?php echo $acaoFluxo; ?>" />
        <?php } else { ?>
        <label title="Voc&ecirc; n&atilde;o tem permiss&atilde;o para iniciar um fluxo">
                <img src="/corporativo/servicos/bbhive/images/btn_StartOFF.gif" border="0" style="margin-left:10px;"/><br />
                    Iniciar<br /><?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?>
        </label>
        <?php } ?>
        </td>
        
        <td width="75" height="61" align="center" class="tbTarefas">
        <?php if(($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($tarPredec==0)&&($subFilho==0)&&($atividade->status!=2)&&($atividade->bbh_flu_finalizado=='0')&&($atividade->bbh_mod_ati_relatorio=='1') /**&&($relFinalizado==0)**){ ?>
            <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_relatorio'; <?php echo $acaoDetal; ?>">
                <img src="/corporativo/servicos/bbhive/images/btnRelatorio.gif" border="0" style="margin-left:10px;" /><br />
                    Iniciar<br /><?php echo mysqli_fetch_assoc($_SESSION['relNome']); ?>
           </a>
           <input type="hidden" name="aba_relatorio" id="aba_relatorio" value="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=<?php echo $CodAtividade; ?>','menuEsquerda|colPrincipal');" />
        <?php } else { ?>
        <label title="Voc&ecirc; n&atilde;o tem permiss&atilde;o para iniciar um relat&oacute;rio">
                <img src="/corporativo/servicos/bbhive/images/btnRelatorioOFF.gif" border="0" style="margin-left:10px;"/><br />
                    Iniciar<br /><?php echo mysqli_fetch_assoc($_SESSION['relNome']); ?>
        </label>
        <?php } ?>
        </td>
        
<?php 
/*if(isset($_GET['bbh_flu_codigo'])){
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$_GET['bbh_flu_codigo']."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$_GET['bbh_flu_codigo']."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
} else {
	$onClick = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');";
}
?>
        <td width="75" height="61" align="center" class="tbTarefas">
            <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_arquivos'; <?php echo $acaoDetal; ?>" style="cursor:pointer;">
                <img src="/corporativo/servicos/bbhive/images/btn_FILE.gif" border="0" style="margin-left:10px;" /><br />
                    Arquivos
             </a>
           <input type="hidden" name="aba_arquivos" id="aba_arquivos" value="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?bbh_flu_codigo=<?php echo $atividade->codigoFluxo; ?>&bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');" />
        </td>
    </tr>
</table> */?>