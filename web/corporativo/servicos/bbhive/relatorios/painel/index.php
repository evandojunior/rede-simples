<?php
foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
}
require_once("includes/cabecalhoModeloFluxo.php");
require_once("includes/cabecalhoAtividade.php");
require_once("includes/functions.php");

$query_relatorios = "SELECT count(bbh_paragrafo.bbh_par_codigo) as paragrafos, bbh_relatorio.*,date_format(bbh_rel_data_criacao,'%d/%m/%Y') as criacao,
 sum(if(bbh_par_titulo = 'Bl@ck_arquivo_ANEXO*~', 1, 0)) as anexos FROM bbh_relatorio  LEFT JOIN bbh_paragrafo ON bbh_paragrafo.bbh_rel_codigo = bbh_relatorio.bbh_rel_codigo WHERE bbh_ati_codigo = $bbh_ati_codigo GROUP BY bbh_relatorio.bbh_rel_codigo";

list($relatorios, $row_relatorios, $totalRows_relatorios) = executeQuery($bbhive, $database_bbhive, $query_relatorios, $initResult = false);

$finalizado = relatorioFinalizado($database_bbhive, $bbhive, $bbh_ati_codigo);
?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11 color" style="margin-top:8px;">
  <tr>
    <td width="326">&nbsp;<strong>Gerenciamento de <?php echo $_SESSION['relNome']; ?></strong>
    </td>
    <td width="279" align="right">    <a href="#@" onclick="showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/acao/regra.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&','menuEsquerda|colPrincipal');" style="color:#0099CC;" class="verdana_11">
   	 <img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />&nbsp;<strong>Voltar para <?php echo $_SESSION['TarefasNome']; ?></strong>
    </a> </td>
  </tr>
  <tr>
    <td height="4" colspan="2" background="/corporativo/servicos/bbhive/images/barra_tar.gif"></td>
  </tr>
</table>
<?php require_once("includes/cabeca.php"); ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_12" style="margin-top:5px; border:#A0AFC3 solid 1px;">
  <tr>
    <td width="296" height="23" class="verdana_12" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)">&nbsp;<strong>A&ccedil;&atilde;o</strong>
    </td>
    <td width="307" align="right" class="verdana_12" style="border-bottom:#A0AFC3 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/painel/pixelBack.jpg)"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&relatorios=1|relatorios/index.php|includes/colunaDireita.php?fluxosDireita=1&eventos=1','menuEsquerda|colCentro|colDireita')" style="color:#0099CC;" class="verdana_11">
   	 <img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />&nbsp;<strong>Voltar para <?php echo $_SESSION['relNome']; ?></strong></a></td>
  </tr>
  <tr>
    <td colspan="2" align="left" valign="top" bgcolor="#FFFFFF">
    <div style="overflow:auto; height:350px;">
    <div style="position:absolute;z-index:3000" id="nvDoc"></div>
    <?php 
	if($finalizado > 0){ ?>
    	<div style="color:#F60; font-size:16px;height:25px; vertical-align:text-bottom" align="center" class="titulo_setor">Atividade finalizada!!!</div>
    <?php
		$icone = "novo_relOFF.gif";
		$titulo= "Novo";
		$legenda= "Adicionar documento";
		$a=1;
		$onClick= "";
	} else {
		$icone = "novo_rel.gif";
		$titulo= "Novo";
		$legenda= "Adicionar documento";
		$a=1;
		$onClick= "OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/novo.php','nvDoc','?bbh_ati_codigo=".$bbh_ati_codigo."&titulo=".$n." - ".$numeroProcesso."','...','nvDoc','2','2');";
	}
		include("includes/menu.php");
	
	while ($row_relatorios = mysqli_fetch_assoc($relatorios)){
	   //if($a > 0){
		 $icone = "rel.gif";
		 $titulo= $row_relatorios['bbh_rel_titulo'];
		 $legenda= "Versão $a<br><span style='color:#999'>Contém <span style='color:#FF9900'>{$row_relatorios['anexos']}</span> anexo(s)</span> ";
		 $onClick= "return LoadSimultaneo('perfil/index.php?perfil=1&tarefas=1|relatorios/painel/propriedades.php?bbh_rel_codigo=".$row_relatorios['bbh_rel_codigo']."&bbh_ati_codigo=".$bbh_ati_codigo."','menuEsquerda|ambienteRelatorio');";
	   //}
		include("includes/menu.php");
	  	echo $a % 2 == 1 ? "<br>" : "";
		$a++;
	}
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Visualizou o relatório (".$row_CabFluxo['bbh_flu_titulo'].") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	
	?>
    </div>
    </td>
  </tr>
</table>