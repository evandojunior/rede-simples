<?php
//apaga busca avançada
if(isset($_SESSION['consultaAvancada'])){ unset($_SESSION['consultaAvancada']); };

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página principal do sistema - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	  
if(!isset($_SESSION)){ session_start(); } 
 if($_SESSION['acesso']==1){
	$query_Procedimentos = "select bbh_perfil.bbh_per_codigo, bbh_usu_codigo, 
      round(sum(bbh_per_fluxo)) as bbh_per_fluxo, 
      round(sum(bbh_per_mensagem)) as bbh_per_mensagem,
      round(sum(bbh_per_arquivos)) as bbh_per_arquivos,
      round(sum(bbh_per_equipe)) as bbh_per_equipe,
      round(sum(bbh_per_tarefas)) as bbh_per_tarefas,
      round(sum(bbh_per_relatorios)) as bbh_per_relatorios,
      round(sum(bbh_per_protocolos)) as bbh_per_protocolos,
	  round(sum(bbh_per_bi)) as bbh_per_bi,
	  round(sum(bbh_per_geo)) as bbh_per_geo,
	  round(sum(bbh_per_peoplerank)) as bbh_per_peoplerank
    from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                     group by bbh_usu_codigo";

     list($Procedimentos, $row_Procedimentos, $totalRows_Procedimentos) = executeQuery($bbhive, $database_bbhive, $query_Procedimentos);
?>
<div class="verdana_12" style="margin-left:5px;margin-right:5px;margin-bottom:5px;">

<?php if($row_Procedimentos['bbh_per_protocolos']>=1){ ?>
  <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de <?php echo ($_SESSION['protNome']); ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/solicitacoes.gif" width="37" height="37" border="0" /></a>
<?php } ?>

<?php if($row_Procedimentos['bbh_per_fluxo']>=1){ ?>
	<a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php','menuEsquerda|conteudoGeral');" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Busca de <?php echo $_SESSION['FluxoNome'] ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/busca.gif" width="37" height="37" border="0" /></a> 
<?php
}
 /*
    <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1&protocolo=1|protocolo/index.php?todos=true','menuEsquerda|conteudoGeral');">Ind&iacute;cios</a> 
    */ ?>
<?php /*if($row_Procedimentos['bbh_per_fluxo']>=1){ ?>
    <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita')"><?php echo mysqli_fetch_assoc($_SESSION['FluxoNome']) ?></a>
<?php }*/ ?>

<?php if($row_Procedimentos['bbh_per_tarefas']>=1){ ?>
    <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de <?php echo $_SESSION['TarefasNome']; ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/tarefas.gif" width="37" height="37" border="0" /></a>
<?php } ?>
    
<?php if($row_Procedimentos['bbh_per_mensagem']>=1){ ?>
     <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&mensagens=1|mensagens/index.php?caixaEntrada=True|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de <?php echo $_SESSION['MsgNome']; ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/mensagem.gif" width="37" height="37" border="0" /></a> 
<?php } ?>

<?php if($row_Procedimentos['bbh_per_arquivos']>=1){ ?>
  <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de <?php echo $_SESSION['arqNome']; ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/GED.gif" width="37" height="37" border="0" /></a> 
<?php } ?>

<?php if($row_Procedimentos['bbh_per_relatorios']>=1){ ?>
  <a href="#@" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&relatorios=1|relatorios/index.php|includes/colunaDireita.php?fluxosDireita=1&eventos=1','menuEsquerda|colCentro|colDireita')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de <?php echo $_SESSION['relNome']; ?>'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/relatorios.gif" width="37" height="37" border="0" /></a>
<?php } ?>

<?php if($row_Procedimentos['bbh_per_bi']>=1 && isset($_SESSION['EndURL_BI'])){ ?>
  <a href="<?php echo $_SESSION['EndURL_BI']; ?>/corporativo/servicos/bi/" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Clique para acessar o BI'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'" target="_blank"><img src="/corporativo/servicos/bbhive/images/icones_barra/bi.gif" width="37" height="37" border="0" /></a>
<?php } ?>

<?php if($row_Procedimentos['bbh_per_geo']>=1 && isset($_SESSION['EndURL_GEO'])){ ?>
  <a href="<?php echo $_SESSION['EndURL_GEO']; ?>/servicos/guia_baixada/" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Clique para acessar o GEO'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'" target="_blank"><img src="/corporativo/servicos/bbhive/images/icones_barra/geoprocessamento.gif" width="37" height="37" border="0" /></a>
<?php } ?>

<?php if($row_Procedimentos['bbh_per_peoplerank']>=1 && isset($_SESSION['EndURL_PEOPLERANK'])){ ?>
  <a href="<?php echo $_SESSION['EndURL_PEOPLERANK']; ?>/corporativo/servicos/peoplerank/" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Clique para acessar o PEOPLERANK'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'" target="_blank"><img src="/corporativo/servicos/bbhive/images/icones_barra/peoplerank.gif" width="37" height="37" border="0" /></a>
<?php } ?>

<a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&equipe=1|perfil/regra.php|includes/colunaDireita.php?equipeArquivos=1&tarefasDireita=1&fluxosDireita=1','menuEsquerda|colCentro|colDireita')" onmouseover="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;Gerenciamento de Perfil'" onmouseout="javascript: document.getElementById('legendaFluxo').innerHTML = '&nbsp;'"><img src="/corporativo/servicos/bbhive/images/icones_barra/perfil.gif" width="37" height="37" border="0" /></a>
</div>
<div style="font-weight:bold;margin-left:5px;margin-right:5px;margin-bottom:5px;" id="legendaFluxo">&nbsp;</div>
<?php } ?>
