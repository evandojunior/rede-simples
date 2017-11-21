<?php
//conexão
$dir = str_replace("\\","/",dirname(__FILE__));
$dir = explode("web",$dir);
$dir = $dir[0]."web/Connections/bbhive.php";
require_once($dir);

$escolha = isset($bbh_flu_codigo)?" bbh_fluxo.bbh_flu_codigo=$bbh_flu_codigo":"bbh_atividade.bbh_ati_codigo = $bbh_ati_codigo";

$query_CabFluxo = "select bbh_fluxo.bbh_flu_codigo, bbh_flu_titulo
from bbh_atividade 
inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo 
inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo 
Where $escolha";
list($CabFluxo, $row_CabFluxo, $totalRows_CabFluxo) = executeQuery($bbhive, $database_bbhive, $query_CabFluxo);

$query_Modelo = "select bbh_flu_autonumeracao, bbh_tip_flu_identificacao, bbh_mod_flu_nome, bbh_flu_anonumeracao 
	from bbh_fluxo
		inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
		inner join bbh_tipo_fluxo  on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
			Where bbh_flu_codigo = ".$row_CabFluxo['bbh_flu_codigo'];
list($Modelo, $row_Modelo, $totalRows_Modelo) = executeQuery($bbhive, $database_bbhive, $query_Modelo);
//--
	$nomeFluxo 		= $row_Modelo['bbh_mod_flu_nome'];
	$autoNumeracao	= $row_Modelo['bbh_flu_autonumeracao'];
	$tipoProcesso	= explode(".",$row_Modelo['bbh_tip_flu_identificacao']);
	$tipoProcesso	= (int)$tipoProcesso[0];
	$anoNumeracao	= $row_Modelo['bbh_flu_anonumeracao'];
	//--
	$numeroProcesso	= $nomeFluxo . " - " . $autoNumeracao . "." . $tipoProcesso . "/" . $anoNumeracao;
	//--
//--
?>
<a href="#@" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_CabFluxo['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_CabFluxo['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar detalhes do fluxo">

<strong class="verdana16 color"><?php echo $numeroProcesso; ?><br />&nbsp;<?php echo $n= $row_CabFluxo['bbh_flu_titulo']; ?></strong>

</a>