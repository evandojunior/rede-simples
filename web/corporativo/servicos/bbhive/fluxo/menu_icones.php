<?php //--AGUARDANDO VALIDAÇÃO DE DADOS COM BASE NO XML

	$icones_disponíveis = array();
	//--
	$nomeElementos = "ico_Fluxo,ico_Tarefas,ico_Detalhamento,ico_Mensagens,ico_Ged,ico_Fluxograma,ico_Indicios,ico_Resumo";
	//--
	//--Descrição do Fluxo
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para visualizar a descrição - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"escondeBloco('corpoFluxo','fluxo', 'titulo', '&nbsp;".$_SESSION['FluxoNome']."', '/corporativo/servicos/bbhive/fluxo/fluxo.php?bbh_flu_codigo=". $bbh_flu_codigo."');this.className = 'ico_Fluxo_Selecionado'; desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Fluxo_Inativo' id='ico_Fluxo'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Descrição ".$_SESSION['FluxoNome']."</td>
		  </tr>
		</table>
	</div>";

	//--Tarefas/Atividades
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique e confira todas as atividades - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"escondeBloco('corpoFluxo','atividade', 'titulo', '&nbsp;Atividades', '/corporativo/servicos/bbhive/fluxo/atividades.php?bbh_flu_codigo=". $bbh_flu_codigo."');this.className = 'ico_Tarefas_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Tarefas_Inativo' id='ico_Tarefas'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>".$_SESSION['TarefasNome']."</td>
		  </tr>
		</table>
	</div>";
	
	
	//--Detalhamento
	if(($row_AltDetal['total']>0)&&($totalRows_tabDet>0) && ($row_Fluxos['atividades']!=$row_Fluxos['finalizadas'])) {
		$fluxoFinalizado= $row_Fluxos['bbh_flu_finalizado']=='0' ? '0' : '1';
		
		$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique e atualize os campos adicionais - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"escondeBloco('corpoFluxo','detalhamento', 'titulo', '&nbsp;Campos adicionais', '/corporativo/servicos/bbhive/fluxo/detalhamento/edita.php?bbh_flu_codigo=".$bbh_flu_codigo."&bbh_mod_flu_codigo=".$bbh_mod_flu_codigo."&fluxoFinalizado=".$fluxoFinalizado."&edtDet=true');this.className = 'ico_Detalhamento_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Detalhamento_Inativo' id='ico_Detalhamento'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Campos adicionais</td>
		  </tr>
		</table>
	 </div>";
	}
	
	//--Mensagens - BASEADO NO XML
	$_SESSION['exibeMenFluxo'] = 1;
	if(isset($_SESSION['exibeMenFluxo']) && $_SESSION['exibeMenFluxo'] == 1){
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique e confira as mensagens recentes - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&exibeMensagem=true&caixaEntrada=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');this.className = 'ico_Mensagens_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Mensagens_Inativo' id='ico_Mensagens'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Mensagens</td>
		  </tr>
		</table>
	</div>";
	}
	
	//--GED
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para gerenciar os arquivos - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');this.className = 'ico_Ged_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Ged_Inativo' id='ico_Ged'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>(".$row_GED['total'].") Arquivos</td>
		  </tr>
		</table>
	</div>";
	
	//--Fluxograma
	/*$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para visualizar o fluxograma - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/index.php?bbh_interface_codigo=".$bbh_flu_codigo."&','menLoad','','Aguarde','menLoad','2','2');this.className = 'ico_Fluxograma_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Fluxograma_Inativo' id='ico_Fluxograma'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Fluxograma</td>
		  </tr>
		</table>
	</div>";*/
	
	//--Indícios - BASEADO NO XML
	$_SESSION['exibeIndicios'] = 1;
	if( isset($_SESSION['exibeIndicios']) && $_SESSION['exibeIndicios'] == 1){
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para visualizar os".$_SESSION['componentesNome']." - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=".$bbh_flu_codigo."&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=".$bbh_flu_codigo."&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');this.className = 'ico_Indicios_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Indicios_Inativo' id='ico_Indicios'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>" .$_SESSION['componentesNome']."</td>
		  </tr>
		</table>
	</div>";
	}
	//--Resumo
	$icones_disponíveis[]="<div onMouseOver=\"exibeLegenda('Clique para visualizar o resumo - ".$_SESSION['FluxoNome']."'); gerenciaCSS(this);\" onMouseOut=\"exibeLegenda('');gerenciaCSS(this);\" onclick=\"showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=".$bbh_flu_codigo."','menuEsquerda|conteudoGeral');this.className = 'ico_Resumo_Selecionado';desabilitaClasse(this,'".$nomeElementos."')\" style='cursor:pointer; width:74px; height:61px;' class='ico_Resumo_Inativo' id='ico_Resumo'>
		<table width='73' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td height='61' align='center' valign='bottom'>Resumo</td>
		  </tr>
		</table>
	</div>";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F7F7F8">
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
</table><?php /*
<hr>

<table width="550">
<tr>
        <td width="72" height="61" align="center" class="tbTarefas">
            <a href="#@" onclick="return escondeBloco('corpoFluxo','fluxo', 'titulo', '&nbsp;<?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?>', '/corporativo/servicos/bbhive/fluxo/fluxo.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Detalhes do <?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?></span>] body=[<span class='verdana_11'>Clique para verificar todos os dados do <?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?></span>]">
                <img src="/corporativo/servicos/bbhive/images/btnFluxo.gif" border="0" style="margin-left:10px;" /><br />
      Descri&ccedil;&atilde;o do <?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?>             </a>        </td>
        <td width="72" height="61" align="center" class="tbTarefas">
            <a href="#00" onclick="return escondeBloco('corpoFluxo','atividade', 'titulo', '&nbsp;Atividades', '/corporativo/servicos/bbhive/fluxo/atividades.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Exibir todas atividades</span>] body=[<span class='verdana_11'>Clique e confira todas as atividades deste <?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']); ?></span>]">
                <img src="/corporativo/servicos/bbhive/images/btnAtiv.gif" border="0" style="margin-left:10px;" /><br />
      Atividades             </a>        </td>
      <?php 
        <td width="72" height="61" align="center" class="tbTarefas">
            <a href="#000" onclick="return escondeBloco('corpoFluxo','mensagem', 'titulo', '&nbsp;Mensagens', '/corporativo/servicos/bbhive/fluxo/mensagens.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Exibir todas mensagens</span>] body=[<span class='verdana_11'>Clique e confira as mensagens recentes</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnHisto.gif" border="0" style="margin-left:10px;" /><br />
      Mensagens             </a>        </td>
       ?>
        <td width="72" height="61" align="center" class="tbTarefas">
        <?php if(($row_AltDetal['total']>0)&&($totalRows_tabDet>0) && ($row_Fluxos['atividades']!=$row_Fluxos['finalizadas'])) { ?>
            <a href="#0000" onclick="return escondeBloco('corpoFluxo','detalhamento', 'titulo', '&nbsp;Detalhamento', '/corporativo/servicos/bbhive/fluxo/detalhamento.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&bbh_mod_flu_codigo=<?php echo $bbh_mod_flu_codigo; ?>&fluxoFinalizado=<?php if($row_Fluxos['bbh_flu_finalizado']=='0'){ echo '0'; } else { echo '1'; } ?>');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Editar campos adicionais</span>] body=[<span class='verdana_11'>Clique e atualize os campos adicionais</span>]">
                <img src="/corporativo/servicos/bbhive/images/btnDetalhe.gif" border="0" style="margin-left:10px;" /><br />
      Detalhamento             </a>
      <?php } else { ?>
      	<img src="/corporativo/servicos/bbhive/images/btnDetalheOFF.gif" border="0" style="margin-left:10px;" /><br />
      Detalhamento
      <?php } ?>
      </td>
      
        <td width="72" height="61" align="center" class="tbTarefas">
			<a href='#@' onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Arquivos</span>] body=[<span class='verdana_11'>Clique para gerenciar os arquivos</span>]">
                <img src="/corporativo/servicos/bbhive/images/btn_FILE.gif" border="0" style="margin-left:10px;" /><br />
      Arquivos             </a>        </td>
      
        <td width="72" height="61" align="center" class="tbTarefas">
            <a href="#@" onclick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/index.php?bbh_interface_codigo=<?php echo $bbh_flu_codigo; ?>&','menLoad','','Aguarde','menLoad','2','2')" style="cursor:pointer;" title="header=[<span class='verdana_11'>Fluxograma</span>] body=[<span class='verdana_11'>Clique para visualizar o fluxograma</span>]">
                <img src="/corporativo/servicos/bbhive/images/btn_Start.gif" border="0" style="margin-left:10px;" /><br />
      Fluxograma             </a>        </td>
      
        <td width="72" height="61" align="center" class="tbTarefas">
           <a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');"  style="cursor:pointer;" title="header=[<span class='verdana_11'>Indícios</span>] body=[<span class='verdana_11'>Clique para visualizar os indícios</span>]">
                <img src="/corporativo/servicos/bbhive/images/painel/indicios.gif" border="0" style="margin-left:5px;" /><br />
      Indícios            </a>       </td>
      
        <td width="72" height="61" align="center" class="tbTarefas">
            <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/regra.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>','menuEsquerda|conteudoGeral');" style="cursor:pointer;" title="header=[<span class='verdana_11'>Resumo</span>] body=[<span class='verdana_11'>Clique para visualizar o resumo</span>]">
                <img src="/corporativo/servicos/bbhive/images/resumo.gif" border="0" style="margin-left:5px;" /><br />
      Resumo             </a>        </td>
  </tr>
</table>*/?>