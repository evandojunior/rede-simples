<?php
require_once('includes/functionsAtividades.php');

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;paginaSome")||($indice=="paginaSome")){	$paginaSome= $valor; } 
}

if(!isset($_SESSION)){ session_start(); }
$CodAtividade	= $_GET['bbh_ati_codigo'];
$bbh_ati_codigo = $CodAtividade;

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");

$tarPredec 		= 0;
$subFilho		= 0;

require_once('includes/classeAtividade.php');
$atividade = new atividade();
$atividade->setLinkConnection($bbhive);
$atividade->setDefaultDatabase($database_bbhive);
$atividade->execute($CodAtividade);

//verifica subfluxos
$query_subFluxo = "select bbh_fluxo.*, sum(bbh_sta_ati_peso)/count(bbh_ati_codigo) as Peso, 
max(bbh_ati_final_previsto) as tPrevisto, count(bbh_ati_codigo) as Tarefas

from bbh_fluxo
      inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
      inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo

 Where bbh_flu_tarefa_pai=$CodAtividade
 
  group by bbh_flu_codigo";
list($subFluxo, $row_subFluxo, $totalRows_subFluxo) = executeQuery($bbhive, $database_bbhive, $query_subFluxo);

	//dados do status
	$query_status = "select * from bbh_status_atividade Where bbh_sta_ati_codigo>2 order by bbh_sta_ati_nome asc";
    list($status, $row_status, $totalRows_status) = executeQuery($bbhive, $database_bbhive, $query_status);
	
	//meu departamento
	$query_Dpto = "select bbh_dep_codigo from bbh_usuario Where bbh_usu_codigo=".$_SESSION['usuCod'];
    list($Dpto, $row_Dpto, $totalRows_Dpto) = executeQuery($bbhive, $database_bbhive, $query_Dpto);
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?addStatus=true&Ts='.$TimeStamp;
	$homeDestal		= '/corporativo/servicos/bbhive/fluxo/detalhamento/grava_det_atividade.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'updateAticidade';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	//--
	$acaoDetal = "OpenAjaxPostCmd('".$homeDestal."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	//--
	$acaoFluxo = "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/regra.php?bbh_ati_codigo=".$CodAtividade."','menuEsquerda|colPrincipal');";

//dados das predecessoras
$Predecessoras 	= $atividade->predecessoras;
$totPredecessora= count($Predecessoras);
if($totPredecessora>0){
	$tarPredec=1;
}

//verifica se tenho obrigratoriedade de criar relatório e se foi criado
$CriouRelatorio=0;
$bbhRelCodigo = 0;
if($atividade->bbh_mod_ati_relatorio=='1'){
	$query_rel = "select MAX(bbh_rel_codigo) as bbh_rel_codigo from bbh_relatorio Where bbh_ati_codigo=".$CodAtividade." AND bbh_rel_pdf='1'";
    list($rel, $row_rel, $totalRows_rel) = executeQuery($bbhive, $database_bbhive, $query_rel);
	
	if($totalRows_rel > 0){
        $bbhRelCodigo = $row_rel['bbh_rel_codigo'];
		$CriouRelatorio = $row_rel['bbh_rel_codigo'] > 0 ? 1 : 0;
	}
}

//esta variável precisa ser dinâmica
$relFinalizado=$CriouRelatorio;

//--TOTAL DE ARQUIVOS PÚBLICOS DO GED
$totGED = "select count(bbh_arq_codigo) as total from bbh_arquivo
			Where bbh_arq_compartilhado='1' 
			 AND bbh_arquivo.bbh_flu_codigo IN (
				select bbh_fluxo.bbh_flu_codigo from bbh_fluxo
				inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
				inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
				Where (bbh_atividade.bbh_usu_codigo = ".$_SESSION['usuCod']." OR bbh_usuario.bbh_usu_chefe=".$_SESSION['usuCod'].")
				group by bbh_fluxo.bbh_flu_codigo
			)
	AND bbh_arquivo.bbh_flu_codigo = ".$atividade->codigoFluxo;
list($GED, $row_GED, $totalRows) = executeQuery($bbhive, $database_bbhive, $totGED);
//--
?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11 ">
  <tr>
    <td>
    <strong class="verdana18 color"><?php require_once("../../fluxo/cabecalhoModeloFluxo.php"); ?></strong><br />&nbsp;
    &nbsp;<strong>Gerenciamento de atividade</strong><?php if($row_Dpto['bbh_dep_codigo']==$atividade->meuDepartamento){ echo " do(a) ".$atividade->profissional; } else { echo " do ".$atividade->nmDepto; } ?>
    <div id="totAtividadeII" style="float:right;"><strong><?php
		$totFilhos = contaNohs($CodAtividade);
	if($totFilhos>1){ echo $totFilhos." coment&aacute;rios"; } else { echo $totFilhos." coment&aacute;rio"; } ?></strong></div>
    </td>
  </tr>
  <tr>
    <td height="4" background="/corporativo/servicos/bbhive/images/barra_tar.gif"></td>
  </tr>
</table>
<?php require_once("menu_icones.php"); ?>
<?php 
//--Verifica se estou neste processo e se sou chefe do usuário que executará esta atividade
$cd_fluxo = $atividade->codigoFluxo;
$sqParticipo = "select a.bbh_ati_codigo from bbh_atividade as a
 where a.bbh_usu_codigo =".$_SESSION['usuCod']." and a.bbh_flu_codigo = $cd_fluxo";

list($Participo, $row_participo, $totalRows_participo) = executeQuery($bbhive, $database_bbhive, $sqParticipo, $initResult = false);

//Aberto
$sqAberto = "select f.bbh_flu_finalizado as f from bbh_fluxo as f where f.bbh_flu_codigo=".$atividade->codigoFluxo;
list($Aberto, $row_Aberto, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqAberto);

if($row_Aberto['f']=='0' && $totalRows_participo > 0 && $atividade->usuChefe == $_SESSION['usuCod'] && $atividade->status==2){
	
	$reabrirAtividade = true;
}



//--ARQUIVOS DO PROTOCOLO
//Descobre qual protocolo é deste fluxo
$sqlFluProt = "select bbh_pro_codigo from bbh_protocolos as p where p.bbh_flu_codigo = ".$atividade->codigoFluxo." limit 1";
list($FluProt, $row_FluProt, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlFluProt);

$bbh_pro_codigo = $row_FluProt['bbh_pro_codigo'] > 0 ? $row_FluProt['bbh_pro_codigo'] : -1;
//--
echo '<div id="conteudoDinamico" class="verdana_12">';
 require_once("../../protocolo/includes/arquivos_digitalizados.php");
echo '</div>';
//--
?><br />
<form name="updateAticidade" id="updateAticidade" style="margin-top:5px;width:98%;">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="98%" height="33" style="border-left:#D7D7D7 solid 1px; background-image:url(/corporativo/servicos/bbhive/images/backTopII.jpg); background-repeat:no-repeat">
    <div id="titulo" style="width:98%; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>Atividade</strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label>
        <label style="position:absolute; margin-top:-25px; margin-left:160px;" class="verdana_12">
                        <?php if($atividade->status==2){ 
							$_SESSION['atividadeAberta'] = 0;
							$query_Sta = "select bbh_sta_ati_nome from bbh_status_atividade Where bbh_sta_ati_codigo=2";
                            list($Sta, $row_Sta, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Sta);
						?>
                            <input type="hidden" name="bbh_sta_ati_codigo" id="bbh_sta_ati_codigo" value="2|Finalizado" />
                            <span style="color:#999999"><strong><?php echo $row_Sta['bbh_sta_ati_nome']; ?></strong></span>
                        <?php } else { ?>
                        Mudar status :
                          <select name="bbh_sta_ati_codigo" id="bbh_sta_ati_codigo" class="verdana_11">
                            <?php
            do {  
            ?>
                            <option value="<?php echo $row_status['bbh_sta_ati_codigo']?>|<?php echo $row_status['bbh_sta_ati_nome']?>"<?php if (!(strcmp($row_status['bbh_sta_ati_codigo'], $atividade->status))) {echo "selected=\"selected\"";} ?>><?php echo $row_status['bbh_sta_ati_nome']?></option>
                            <?php
            } while ($row_status = mysqli_fetch_assoc($status));
              $rows = mysqli_num_rows($status);
              if($rows > 0) {
                  mysqli_data_seek($status, 0);
                  $row_status = mysqli_fetch_assoc($status);
              }
				
            ?>
                          </select>
                           <?php if(($atividade->usuarioAtividade==$_SESSION['usuCod']) && ($tarPredec==0)&&($atividade->bbh_flu_finalizado=='0')){ $_SESSION['atividadeAberta'] = 1; ?>	
                            <a href="#@" onclick="document.getElementById('acaoDaVez').value='aba_salvar'; <?php echo $acaoDetal; ?>" style="cursor:pointer;" title="header=[<span class='verdana_11'>Salvar atividade</span>] body=[<span class='verdana_11'>Clique para salvar atera&ccedil;&otilde;es desta atividade</span>]">
                                <img src="/corporativo/servicos/bbhive/images/salvar.gif" width="16" height="16" border="0" align="absmiddle" />
                            <?php } else { $_SESSION['atividadeAberta'] = 0; ?>   
                                <img src="/corporativo/servicos/bbhive/images/salvarOFF.gif" width="16" height="16" border="0" align="absmiddle" title="N&atilde;o &eacute; possivel salvar esta atividade!"/>
                            <?php } ?> 
                             </a>
<input type="hidden" name="aba_salvar" id="aba_salvar" value="<?php echo $acao; ?>" />
                        <?php } ?>  
                        </label>
    <div id="menLoad" class="verdana_11 color" style="position:absolute;z-index:500000; margin-top:-47px; margin-left:280px">&nbsp;</div>
    </td>
  </tr>
  <tr>
    <td width="98%" height="200" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="corpoTarefa" >
        <div id="atividade" class="show"><span id="loadAtividade" class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="fluxo" 	class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="atribuir" 	class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="decisao" 	class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="gerencia" 	class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="historico" class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
        <div id="icidencia" class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
    </td>
  </tr>
</table>
<?php 
 if($totPredecessora>0){
	$tarPredec=1;//tenho predecessoras
 echo '<div id="predecessoras">';
 	require_once('includes/predecessoras.php');
 echo "</div>";
 }

//laudos disponíveis - última versão
//if($atividade->bbh_mod_ati_relatorio=='1'){
	if($CriouRelatorio>=1){//tem relatório e o mesmo foi finalizado
		require_once('includes/arquivosDisponiveis.php');
	} 
//}
//dados subfluxos
if($totalRows_subFluxo>0){
 echo '<div id="subFluxos">';
 	require_once('includes/subFluxos.php');
 echo "</div>";
}
	/*if($CriouRelatorio==1){
	?>
	<div class="verdana_12" style="color:#3C6; cursor:pointer" onclick="document.actionDownloadPDF.submit();"><img src="/corporativo/servicos/bbhive/images/download.gif" alt="Download do arquivo" width="17" height="17" border="0"><strong>Fazer download do <?php echo mysqli_fetch_assoc($_SESSION['relNome']); ?></strong></div>
<?php
	}*/
//dados da ação
 echo '<div id="acaoAtividade">';
 	require_once('includes/acaoAtividade.php');
 echo "</div>";
?>
	<input type="hidden" name="bbh_ati_codigo" id="bbh_ati_codigo" value="<?php echo $CodAtividade; ?>" />
    <input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $atividade->codigoFluxo; ?>" />
</form>
<form name="actionDownloadPDF" id="actionDownloadPDF" action="/corporativo/servicos/bbhive/relatorios/painel/download.php" target="_blank" method="post">
	<input type="hidden" name="bbh_flu_codigo" id="bbh_flu_codigo" value="<?php echo $atividade->codigoFluxo; ?>" />
    <input type="hidden" name="bbh_rel_codigo" id="bbh_rel_codigo" value="<?php echo $bbhRelCodigo; ?>" />


    <input name="acaoDaVez" id="acaoDaVez" type="hidden" value="" />
</form>

<?php
/*
	Responsável pela chamada assíuncrona dos objetos que serão listados na página
	Chamo apenas um objeto e ele faz o resto
*/
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtividade.php?bbh_ati_codigo='.$CodAtividade.'&Ts='.$TimeStamp."&";
	$carregaPagina= "OpenAjaxPostCmd('".$homeDestino."','atividade','&1=1','&nbsp;Carregando dados...','loadAtividade','2','1');";
	

//atualiza status pela 1ª vez

if($atividade->inicioReal==NULL){
	if(($atividade->usuarioAtividade==$_SESSION['usuCod']) && ($tarPredec==0)&&($subFilho==0)){
		//atualiza XML dando ciente na tarefa
		$updateSQL = "UPDATE bbh_atividade SET bbh_sta_ati_codigo=3, bbh_ati_inicio_real='".date("Y-m-d H:i:s")."' WHERE bbh_ati_codigo=$CodAtividade";
        list($Result1, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
		//verifica qual é o status 3, por padrão o sistema vem como Ciente
		$query_status = "select bbh_sta_ati_nome, bbh_sta_ati_codigo from bbh_status_atividade Where bbh_sta_ati_codigo=3";
        list($status, $row_status, $totalRows_status) = executeQuery($bbhive, $database_bbhive, $query_status);
		
		atualizaXML($CodAtividade, 'Profissional ciente da atividade');
		
		//atualiza status
		echo "<var style='display:none'>document.getElementById('bbh_sta_ati_codigo').value='".$row_status['bbh_sta_ati_codigo']."|".$row_status['bbh_sta_ati_nome']."'</var>";
	}
}
?>
<var style="display:none"><?php echo $carregaPagina; 
	//echo isset($paginaSome) ? "document.getElementById('carregaTudo').innerHTML = '&nbsp;'" : "";
?></var>