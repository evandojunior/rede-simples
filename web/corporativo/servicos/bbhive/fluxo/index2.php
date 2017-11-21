<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	if(isset($_GET['bbh_interface_codigo'])){
		$_SESSION['bbh_flu_codigo'] = $_GET['bbh_interface_codigo'];
		?>
        <var style="display:none">
        	document.executaInterfaceRica.submit();
        </var>
        <?php
		exit;
	}


 	//recuperação de variáveis do GET e SESSÃO
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
	}

$SQL=" and bbh_fluxo.bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_flu_tarefa_pai is NULL";

if(isset($bbh_flu_codigo)){
	$SQL = " and bbh_fluxo.bbh_flu_codigo=".$bbh_flu_codigo;
}

$query_Fluxos = "select bbh_fluxo.bbh_flu_codigo, bbh_fluxo.bbh_mod_flu_codigo, bbh_flu_oculto, bbh_fluxo.bbh_usu_codigo, bbh_flu_titulo,  bbh_flu_codigobarras,	
					bbh_mod_flu_nome, bbh_flu_finalizado, bbh_flu_autonumeracao, (select count(*) from bbh_atividade where bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo) as atividades,

(select count(*) from bbh_atividade where bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo AND bbh_sta_ati_codigo=2) finalizadas,
  ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido
					 	from bbh_fluxo 
					
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					
						Where 1=1 $SQL 
							group by bbh_fluxo.bbh_flu_codigo
								order by bbh_flu_codigo desc LIMIT 0,1";
list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);

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
	AND bbh_arquivo.bbh_flu_codigo = $bbh_flu_codigo";
list($GED, $row_GED, $totalRows) = executeQuery($bbhive, $database_bbhive, $totGED);
//--
	$bbh_flu_codigo 	= $row_Fluxos['bbh_flu_codigo'];
	$bbh_mod_flu_codigo = $row_Fluxos['bbh_mod_flu_codigo'];
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/fluxo/executa.php?edOculto=true&bbh_flu_codigo='.$bbh_flu_codigo.'&Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'updateFluxo';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a página principal de ".$_SESSION['FluxoNome']." (".$row_Fluxos['bbh_mod_flu_nome'].") - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/ 
?>

<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['FluxoNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="595" height="33" sstyle="border-left:#D7D7D7 solid 1px; background-imag:url(/corporativo/servicos/bbhive/images/backTopII.jpg); background-repeat:no-repeat">
    
    <!--div id="titulo" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>
      <?php /* if($totalRows_Fluxos==0){ ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11 color">
  <tr>
    <td>&nbsp;<strong>Gerenciamento <?php echo $_SESSION['FluxoNome']; ?></strong>
    </td>
  </tr>
  <tr>
    <td height="4" style="background-image:url(/corporativo/servicos/bbhive/images/barra_tar.gif); background-repeat:no-repeat"></td>
  </tr>
</table>
	<span class='verdana_11 color'>N&atilde;o h&aacute; <?php echo $_SESSION['FluxoNome']; ?> cadastrados!</span>
<?php 
	exit;
} 
*/
	//Tenho permissão para alterar o detalhamento
	$query_AltDetal = "select count(bbh_ati_codigo) as total from bbh_atividade 

inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo

Where bbh_fluxo.bbh_flu_codigo=$bbh_flu_codigo and (bbh_fluxo.bbh_usu_codigo=".$_SESSION['usuCod']." OR bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod'].")
 group by bbh_fluxo.bbh_flu_codigo";
	
	/*$query_AltDetal = "	select count(bbh_ati_codigo) as total from bbh_atividade 
      Where bbh_flu_codigo=$bbh_flu_codigo and bbh_usu_codigo=".$_SESSION['usuCod']."
           group by bbh_flu_codigo";*/
    list($AltDetal, $row_AltDetal, $totalRows_AltDetal) = executeQuery($bbhive, $database_bbhive, $query_AltDetal);
	
	//verifica se a tabela de detalhamento foi criada
	$query_tabDet = "select * from bbh_detalhamento_fluxo Where bbh_mod_flu_codigo=$bbh_mod_flu_codigo AND bbh_det_flu_tabela_criada=1";
    list($tabDet, $row_tabDet, $totalRows_tabDet) = executeQuery($bbhive, $database_bbhive, $query_tabDet);

		$acaoDestino	= '/corporativo/servicos/bbhive/fluxo/reabrir_fluxo.php?bbh_flu_codigo='.$bbh_flu_codigo.'&Ts='.$TimeStamp."&";
		$acaoReabre	= "OpenAjaxPostCmd('".$acaoDestino."','menLoad','&1=1','&nbsp;Processando informações...','menLoad','2','2');";
?>
      <?php echo $_SESSION['componentesNome']; ?></strong></div-->
    <!--div id="titulo" style="display:none;width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong><?php echo $_SESSION['FluxoNome']; ?></strong></div>
   <br style="clear:both;" /-->
<form name="updateFluxo" id="updateFluxo" style="margin-top:5px;width:98%; align:center;" onsubmit="return false;">
    
   <?php if($row_Fluxos['bbh_usu_codigo']==$_SESSION['usuCod']) { ?> 
   <!--table width="98%" align:center border="0" cellspacing="0" cellpadding="0" class="verdana_12 color">
      <tr>
        <td width="26" height="20" align="center" bgcolor="#F8F8F8"><input type="checkbox" name="bbh_flu_oculto" id="bbh_flu_oculto" <?php if($row_Fluxos['bbh_flu_oculto']=='1') { echo 'checked="checked"'; } ?>/></td>
        <td width="336">&nbsp;Ocultar <?php echo $_SESSION['FluxoNome']; ?></td>
        <td width="164"><strong>C&oacute;digo de barras</strong> :</td>
        <td width="229"><input name="bbh_flu_codigobarras" id="bbh_flu_codigobarras" type="text" class="verdana_11 color" value="<?php echo $row_Fluxos["bbh_flu_codigobarras"];?>"  style="width:146px;" maxlength="20" /></td>
        <td width="32" align="center">
        
        <?php if($row_Fluxos['bbh_flu_finalizado']=='0'){ ?>
        	<a href="#" onclick="if(retiraEspacos(document.getElementById('bbh_flu_titulo').value)==''){ alert('O título não deve ficar vazio!'); } else { <?php echo $acao; ?> }">
            	<img src="/corporativo/servicos/bbhive/images/salvar.gif" width="16" height="16" border="0" align="absmiddle" /></a>
        <?php } else { ?>    
        <img src="/corporativo/servicos/bbhive/images/salvarOFF.gif" width="16" height="16" border="0" align="absmiddle" />
        <?php } ?>
        
        </td>
      </tr>
    </table-->
   <?php } ?> 
    <div id="menLoad" class="verdana_11 color" style="position:absolute;z-index:500000; margin-top:-43px; margin-left:370px">&nbsp;</div>
   
</form> </td>
  </tr>
  <tr>
    <td width="98%" height="200" valign="top" sstyle="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="corpoFluxo" >
    <div id="index2_atividade" 	class="show"><span class="verdana_12" id="loadAtividade">&nbsp;Carregando dados...</span></div>
    <div id="index2_fluxo" 		class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
    <div id="index2_mensagem" 		class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
    <div id="index2_detalhamento" 	class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>
    <div id="index2_indicio" 		class="hide"><span class="verdana_12">&nbsp;Carregando dados...</span></div>

    </td>
  </tr>
</table>

<form name="executaInterfaceRica" id="executaInterfaceRica" method="get" action="/corporativo/servicos/bbhive/fluxograma/interface_rica/index.php" target="_blank">
</form>
<form name="trocaResponsavel" id="trocaResponsavel">
	<input name="bbh_ind_codigo" id="bbh_ind_codigo" type="hidden" value="" />
	<input name="bbh_flu_codigo" id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>" />
    <input name="bbh_trocaResponsavel" id="bbh_trocaResponsavel" type="hidden" value="1" />
</form>
<form name="exameRealizado" id="exameRealizado">
	<input name="bbh_ind_codigoReal" id="bbh_ind_codigoReal" type="hidden" value="" />
	<input name="bbh_flu_codigo" id="bbh_flu_codigo" type="hidden" value="<?php echo $bbh_flu_codigo; ?>" />
    <input name="bbh_realizado" id="bbh_realizado" type="hidden" value="" />
    
	<input name="bbh_ind_dt_exame" id="bbh_ind_dt_exame" type="hidden" value="" />
	<input name="bbh_ind_procedimentos" id="bbh_ind_procedimentos" type="hidden" value="" />
	<input name="bbh_ind_qt_procedimento" id="bbh_ind_qt_procedimento" type="hidden" value="" />

    <input name="bbh_exameRealizado" id="bbh_exameRealizado" type="hidden" value="1" />
</form>
<?php
/*
	Responsável pela chamada assíuncrona dos objetos que serão listados na página
	Chamo apenas um objeto e ele faz o resto
*/

$TimeStamp 		= time();
$homeDestino	= '/corporativo/servicos/bbhive/fluxo/fluxo.php?bbh_flu_codigo='.$bbh_flu_codigo.'&Ts='.$TimeStamp."&";
$carregaPagina	= "OpenAjaxPostCmd('".$homeDestino."','index2_atividade','&1=1','&nbsp;Carregando dados...','loadAtividade','2','1');";

	foreach($_GET as $indice=>$valor){
		if($indice == "exibeAtividade" || $indice == "amp;exibeAtividade"){
			$carregaPagina = "escondeBloco('corpoFluxo','index2_atividade', 'titulo', '&nbsp;Atividades', '/corporativo/servicos/bbhive/fluxo/atividades.php?bbh_flu_codigo=".$bbh_flu_codigo."')";
			break;
		}
		if($indice == "exibeMensagem" || $indice == "amp;exibeMensagem"){
			$carregaPagina = "escondeBloco('corpoFluxo','index2_mensagem', 'titulo', '&nbsp;Mensagens', '/corporativo/servicos/bbhive/fluxo/mensagens.php?bbh_flu_codigo=".$bbh_flu_codigo."&caixaEntrada=true&bbh_flu_codigo=".$bbh_flu_codigo."')";
			break;
		}
		if($indice == "exibeIndicios" || $indice == "amp;exibeIndicios"){
			$adicional = "";
			if( isset($_GET['tarefas'] ) ) $adicional = "tarefas=true&bbh_ati_codigo=".$_GET['bbh_ati_codigo']."&";
			 $carregaPagina = "escondeBloco('corpoFluxo','index2_indicio', 'titulo', '&nbsp;".$_SESSION['componentesNome']."', '/corporativo/servicos/bbhive/fluxo/indicios/regra.php?".$adicional."bbh_flu_codigo=".$bbh_flu_codigo."')";
			break;
		}
	}
?>

<var style="display:none"><?php echo $carregaPagina; ?></var>