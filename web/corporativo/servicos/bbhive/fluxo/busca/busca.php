<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;cod_pro_codigo")||($indice=="cod_pro_codigo")){	$bbh_pro_codigo= $valor; } 
	if(($indice=="amp;bbh_tip_flu_codigo")||($indice=="bbh_tip_flu_codigo")){	$bbh_tip_flu_codigo= $valor; } 
}

if(isset($_POST['cod_pro_codigo'])){
	$bbh_pro_codigo= $_POST['cod_pro_codigo'];
}
if(isset($_POST['bbh_tip_flu_codigo'])){
	$bbh_tip_flu_codigo= $_POST['bbh_tip_flu_codigo'];
}

//$bbh_pro_codigo = !isset($bbh_pro_codigo) ? $_POST['bbh_pro_codigo'] : $bbh_pro_codigo;

//definindo busca por dia
$SQL="";
$bsData = "<var style='display:none'>document.getElementById('dtPesquisa').innerHTML = '<strong>Data pesquisada: zzzz</strong>';</var>";

if(isset($_GET['buscaDia'])){
	if(!isset($_SESSION['dtAtual'])){
		$dataAtual = date('Ymd');
		echo str_replace("zzzz",date('d/m/Y'),$bsData);
	} else {
		$dataAtual = $_SESSION['dtAtual'];
	}
		if(isset($_GET['Menos'])){
			$dataAtual = subDayIntoDate($dataAtual, 1);//remove um dia
			$_SESSION['dtAtual'] = $dataAtual;
			
		}
		if(isset($_GET['Mais'])){
			$dataAtual = addDayIntoDate($dataAtual, 1);//adiciona um dia
			$_SESSION['dtAtual'] = $dataAtual;
		}
		$data=substr($dataAtual,0,4)."-".substr($dataAtual,4,2)."-".substr($dataAtual,6,2);
		$SQL .= " AND bbh_flu_data_iniciado='".$data."'";
		
		echo str_replace("zzzz",substr($_SESSION['dtAtual'],6,2)."/".substr($_SESSION['dtAtual'],4,2)."/".substr($_SESSION['dtAtual'],0,4),$bsData);
}

//busca por período
if(isset($_POST['busca_data'])){
	$dataBrutaI = explode("/",$_POST['DataInicio']);
	$dataBrutaF = explode("/",$_POST['DataFim']);
	$bbh_flu_data_iniciado = " bbh_flu_data_iniciado>='".$dataBrutaI[2]."-".$dataBrutaI[1]."-".$dataBrutaI[0]."' and bbh_flu_data_iniciado <='".$dataBrutaF[2]."-".$dataBrutaF[1]."-".$dataBrutaF[0]."'";
	$SQL .= " AND ".$bbh_flu_data_iniciado;
}

//busca por código de barras
if(isset($_POST['busca_codigo'])){
	$SQL .=" AND bbh_flu_codigobarras = '".$_POST['bbh_flu_codigobarras']."' ";
}

//busca por título do fluxo
if(isset($_POST['bbh_busca_nome'])){
	$SQL .=" AND bbh_flu_titulo LIKE '%".mysqli_fetch_assoc($_POST['bbh_busca_nome'])."%' ";
}

//inicio
if(isset($_GET['inicia'])){
	if($_GET['inicia']=="true"){
		$SQL = "";
	} else {
		$bbh_flu_titulo = " bbh_flu_titulo LIKE '".$_GET['inicia']."%'";
		$SQL = " AND ".$bbh_flu_titulo;
	}
}

//busca avançada
if(isset($_POST['busca_avancada'])){
	$SQL.= " AND bbh_fluxo.bbh_flu_codigo in(".$_SESSION['consultaAvancada'].") ";
}

//busca de todos fluxos envolvidos
if(isset($_GET['envolvidos']) || isset($_POST['busca_envolvido'])){
	$SQL.= " AND bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod'];
}

//busca pelos dados do protocolo
   $SQL			.= isset($_POST['ck_prot']) ? " AND bbh_pro_codigo=".$_POST['bbh_pro_codigo'] : "";
   $SQL			.= isset($_POST['ck_data']) ? " AND bbh_pro_momento BETWEEN '".arrumadata($_POST['bbh_pro_data'])." 00:00:00' AND '".arrumadata($_POST['bbh_pro_data'])." 23:59:59'" : "";
   $SQL			.= isset($_POST['ck_tit']) ? " AND bbh_pro_titulo LIKE '%".mysqli_fetch_assoc($_POST['bbh_pro_titulo'])."%'" : "";
//-----------------------------

//somente do meu departamento--
	$SQL		.= " AND bbh_departamento.bbh_dep_codigo = (select bbh_dep_codigo from bbh_usuario where bbh_usu_codigo=".$_SESSION['usuCod'].")";
//-----------------------------

	//select para descobrir o total de registros na base
	$query_Fluxos = "select count(bbh_fluxo.bbh_flu_codigo) as total from bbh_fluxo
					inner join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo Where 1=1 $SQL";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Data);

	$page 		= "1";
	$nElements 	= "40";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= '/corporativo/servicos/bbhive/fluxo/busca/busca.php?Ts='.$_SERVER['REQUEST_TIME']."&bbh_pro_codigo=".$bbh_pro_codigo;
	$exibe			= 'resultBusca';
	$pages 			= ceil($row_Fluxos['total']/$nElements);

	$query_Fluxos = "select bbh_protocolos.bbh_pro_titulo, bbh_protocolos.bbh_pro_codigo, bbh_fluxo.bbh_flu_codigo, bbh_flu_oculto, bbh_fluxo.bbh_mod_flu_codigo, bbh_flu_data_iniciado, bbh_flu_titulo, 	
					bbh_mod_flu_nome, bbh_tip_flu_identificacao, bbh_flu_observacao,bbh_flu_tarefa_pai, 
					 ROUND(SUM(bbh_sta_ati_peso)/count(bbh_fluxo.bbh_flu_codigo),2) as concluido, bbh_dep_nome
					 	from bbh_fluxo 
					inner join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo
					inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo 
					inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo 
					inner join bbh_atividade on bbh_fluxo.bbh_flu_codigo = bbh_atividade.bbh_flu_codigo
					inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					inner join bbh_usuario on bbh_fluxo.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
					
						Where 1=1 $SQL
							group by bbh_fluxo.bbh_flu_codigo
							 HAVING concluido < 100
								order by bbh_fluxo.bbh_flu_codigo desc LIMIT $Inicio,$nElements";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);

	$onLink = "onClick=\"return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|fluxo/busca/regra3.php?bbh_flu_codigo=x&bbh_pro_codigo=".$bbh_pro_codigo."','menuEsquerda|conteudoGeral');\"";
?>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="4%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
        <td width="47%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>T&iacute;tulo do <?php echo $_SESSION['FluxoNome']; ?></strong></td>
        <td width="17%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Iniciado em</strong></td>
        <td width="14%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong> Origem</strong></td>
        <td width="15%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg"><strong> Status</strong></td>
        <td width="3%" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
      </tr>
<?php if($totalRows_Fluxos>0) { ?> 
	  <?php do{ ?>    
      <tr class="legandaLabel11">
        <td height="25" align="center">&nbsp;</td>
            <td style="color:#390"><?php echo($_SESSION['ProtNome']); ?>: <?php echo $row_Fluxos['bbh_pro_codigo']; ?> - &nbsp;<strong><?php echo $row_Fluxos['bbh_pro_titulo']; ?></strong></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="legandaLabel11">
        <td height="25" align="center"><img src="/corporativo/servicos/bbhive/images/setaII.gif" border="0" /></td>
        <td>&nbsp;<?php echo $row_Fluxos['bbh_flu_titulo']; ?></td>
        <td>&nbsp;<?php echo arrumadata($row_Fluxos['bbh_flu_data_iniciado']); ?></td>
        <td>&nbsp;<?php echo $row_Fluxos['bbh_dep_nome']; ?></td>
        <td>&nbsp;<?php echo $row_Fluxos['concluido']; ?>%</td>
        <td align="center"><a href="#@" <?php echo str_replace("bbh_flu_codigo=x","bbh_flu_codigo=".$row_Fluxos['bbh_flu_codigo'],$onLink); ?>><img src="/corporativo/servicos/bbhive/images/busca.gif" border="0" title="Clique para analisar os detalhes e anexar se necessário" /></a></td>
      </tr>
      <tr>
        <td height="1" colspan="6" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
      <?php } while ($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>
<?php } else { ?>  
      <tr class="legandaLabel11">
        <td height="22" colspan="6" align="center">N&atilde;o h&aacute; registros cadastrados</td>
      </tr>
<?php } ?>
    </table>
	<?php require_once('../../includes/paginacao/paginacao.php');?>