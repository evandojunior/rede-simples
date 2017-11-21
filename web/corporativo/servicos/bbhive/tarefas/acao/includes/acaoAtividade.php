<?php
//verifico se esta atividade tem alternativas
 $query_Alternativas = "select bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_fluxo_alternativa.bbh_mod_flu_codigo, 
      bbh_flu_alt_codigo, bbh_flu_alt_titulo, bbh_fluxo_alternativa.bbh_mod_ati_ordem  from bbh_modelo_atividade
      inner join bbh_fluxo_alternativa on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_fluxo_alternativa.bbh_mod_ati_codigo
           Where bbh_modelo_atividade.bbh_mod_ati_codigo=".$atividade->ModeloAtividade."
            order by bbh_modelo_atividade.bbh_mod_ati_ordem ASC";
list($Alternativas, $row_Alternativas, $totalRows_Alternativas) = executeQuery($bbhive, $database_bbhive, $query_Alternativas);

$finalFluxo='&finalFluxo=0';

if($atividade->bbh_mod_atiFim=='1'){
	$finalFluxo="&finalFluxo=1";
}

$homeDestino 	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?endAtividade=true&Ts='.$TimeStamp.$finalFluxo;
$acaoAtividade 	= "OpenAjaxPostCmd('".$homeDestino."','menAcao','".$infoGet_Post."','".$Mensagem."','menAcao','".$Metodo."','".$TpMens."');";

$homeDestino 	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?openAtividade=true&Ts='.$TimeStamp.$finalFluxo;
$acaoReabrir = "OpenAjaxPostCmd('".$homeDestino."','menAcao','".$infoGet_Post."','".$Mensagem."','menAcao','".$Metodo."','".$TpMens."');";

$homeDestinoII 	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?descicaoAtiv=true&bbh_flu_alt_codigo=xxxx&Ts='.$TimeStamp;

//vamos decidir se iremos colocar link na frase
$naoLink=0;

if(($atividade->usuarioAtividade==$_SESSION['usuCod'])&&($tarPredec==0)&&($subFilho==0)&&($atividade->status!=2)&&($atividade->bbh_flu_finalizado=='0')){
	//$naoLink=1;//posso exibir o link

	if($atividade->bbh_mod_ati_relatorio=='1'){
		if($relFinalizado>=1){//tem relatório e o mesmo foi finalizado
			$naoLink=1;//posso exibir o link
		} else {
			$naoLink=0;//não posso exibir o link
		}
	} else {
			$naoLink=1;//não tenho relatório então posso exibir link
	}
}
//VERIFICA SE ESTA ATIVIDADE É FINAL===========================================
if($atividade->bbh_mod_atiFim=='1'){
	 $query_Finalizadas = "select count(*) as atividades, SUM(if(bbh_sta_ati_codigo=2,1,0)) as finalizadas 
	 						from bbh_atividade 
								 inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
								 where bbh_flu_codigo = ".$atividade->codigoFluxo." AND bbh_ati_codigo not in($bbh_ati_codigo)
								 group by bbh_flu_codigo
								 order by bbh_mod_ati_ordem ASC";
    list($Finalizadas, $row_Finalizadas, $totalRows_Finalizadas) = executeQuery($bbhive, $database_bbhive, $query_Finalizadas);
	//VERIFICA SE TODAS ATIVIDADES ANTES DE MIM
		if($row_Finalizadas['atividades'] != $row_Finalizadas['finalizadas']){
			$naoLink=0;//não posso exibir o link
			echo "<label class='verdana_12' style='color:#F00'>ESTA É A ÚLTIMA ETAPA E EXISTEM ETAPAS ANTERIORES EM ABERTO</label>";
		} elseif($atividade->status!=2 && $CriouRelatorio==1) {
			$naoLink=1;//sou atividade fim e todas anteriores foram finalizadas
		}
}
//=============================================================================

?><br />
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="98%" height="33" style="border-left:#D7D7D7 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/backTopII.jpg); background-repeat:no-repeat">
    <div id="acao" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>A&ccedil;&atilde;o</strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label>
    <div id="menAcao" class="verdana_11 color" style="position:absolute;z-index:500000; margin-top:-27px; margin-left:280px">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td height="30" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="sub" class="verdana_11 color"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="22" bgcolor="#F3F3F7">
        <?php if($naoLink==1 && !isset($_SESSION['naoFile'])) { ?>
        <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_sequencia'; <?php echo $acaoDetal; ?>">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
        <?php } else { echo '&nbsp;<img src="/corporativo/servicos/bbhive/images/okOFF.gif" border="0"/>&nbsp;<span style="color:#666666">'; } ?>
        &nbsp;Dar sequ&ecirc;ncia ao fluxo
        <?php if($naoLink==1 && !isset($_SESSION['naoFile'])) { ?>
        </a>
        <input type="hidden" name="aba_sequencia" id="aba_sequencia" value="if(confirm('     Tem certeza que deseja prosseguir com esta ação?!\n Ao clicar em OK esta atividade  poder&aacute; ou n&atilde;o mudar o fluxo!')){ <?php echo $acaoAtividade; ?>}" />
        <?php } else { echo "</span>";}  ?>
        </td>
        </tr>
      <tr>
        <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
        </tr>
<?php if($totalRows_Alternativas>0) { $a=0;
			do{ ?>
      <tr>
        <td height="22" bgcolor="#F7F7F9">
        <?php if($naoLink==1) { ?>
        <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_alternativa<?php echo $a; ?>'; <?php echo $acaoDetal; ?>">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
        <?php } else { echo '&nbsp;<img src="/corporativo/servicos/bbhive/images/okOFF.gif" border="0"/>&nbsp;<span style="color:#666666">'; } ?>
        &nbsp;<?php echo $row_Alternativas['bbh_flu_alt_titulo']; ?>
        <?php if($naoLink==1) { ?>
        </a>
        <?php } else { echo "</span>";}  ?>
        
                <input type="hidden" name="aba_alternativa<?php echo $a; ?>" id="aba_alternativa<?php echo $a; ?>" value="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|fluxo/subFluxo_regra.php?bbh_mod_flu_codigo=<?php echo $row_Alternativas['bbh_mod_flu_codigo']; ?>&bbh_ati_codigo=<?php echo $CodAtividade; ?>&bbh_flu_alt_codigo=<?php echo $row_Alternativas['bbh_flu_alt_codigo']; ?>&titAlt=<?php echo $row_Alternativas['bbh_flu_alt_titulo']; ?>&ordem=<?php echo $row_Alternativas['bbh_mod_ati_ordem']; ?>&bbh_mod_ati_codigo=<?php echo $row_Alternativas['bbh_mod_ati_codigo']; ?>&bbh_flu_codigo=<?php echo $atividade->codigoFluxo; ?>','menuEsquerda|colPrincipal');" />
        </td>
        </tr>
      <tr>
        <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
        </tr>
<?php   $a++;
    } while ($row_Alternativas = mysqli_fetch_assoc($Alternativas)); ?>
<?php
	} 
?>
    <?php if(isset($reabrirAtividade)){ ?>
      <tr>
        <td height="22"><a href="#@" onclick="if(confirm('Tem certeza que deseja reabrir esta atividade? Clique no botão OK em caso de confirmação!')){ <?php echo $acaoReabrir; ?>}">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
        &nbsp;&nbsp;Reabrir <?php echo $_SESSION['TarefasNome']; ?></a>
        </td>
      </tr>
      <tr>
        <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
        </tr>
     <?php } ?> 
      <tr>
        <td height="22"><a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_voltar_atividade'; <?php echo $acaoDetal; ?>">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
        &nbsp;&nbsp;Voltar para lista de <?php echo $_SESSION['TarefasNome']; ?></a>
        <input type="hidden" name="aba_voltar_atividade" id="aba_voltar_atividade" value="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');" />
        </td>
      </tr>
      <tr>
        <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
        </tr>
      <tr>
        <td height="22"><a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_voltar_fluxo'; <?php echo $acaoDetal; ?>">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
        &nbsp;&nbsp;Voltar para  <?php echo $_SESSION['FluxoNome']; ?></a>
        <input type="hidden" name="aba_voltar_fluxo" id="aba_voltar_fluxo" value="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=<?php echo $atividade->codigoFluxo; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $atividade->codigoFluxo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" />
        </td>
      </tr>
    </table></td>
  </tr>
</table>