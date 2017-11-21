<?php
require_once("../../../../../Connections/policy.php");
require_once("../../politicas/includes/gerencia_xml.php");
require_once("../../includes/functions.php");

//recupera o grÃ¡fico
$pol_graf_codigo = $_GET['pol_graf_codigo'];
//select do gráfico
mysqli_select_db($policy, $database_policy);
$query_dadosGrafico = "SELECT * FROM pol_grafico Where pol_graf_codigo=$pol_graf_codigo";
$dadosGrafico = mysqli_query($policy, $query_dadosGrafico) or die(mysql_error());
$row_dadosGrafico = mysqli_fetch_assoc($dadosGrafico);
$totalRows_dadosGrafico = mysqli_num_rows($dadosGrafico);

//recupera código da política
mysqli_select_db($policy, $database_policy);
$query_dadosPolitica = "SELECT * FROM pol_politica Where pol_pol_codigo=".$row_dadosGrafico['pol_pol_codigo'];
$dadosPolitica = mysqli_query($policy, $query_dadosPolitica) or die(mysql_error());
$row_dadosPolitica = mysqli_fetch_assoc($dadosPolitica);
$totalRows_dadosPolitica = mysqli_num_rows($dadosPolitica);

/*
1-quem
2-oque
3-quando
4-onde
5-relevancia
*/
function agrupar($tipo){
	switch($tipo){
		case "1" : $tipo = "pol_aud_usuario"; break;
		case "2" : $tipo = "pol_aud_acao"; break;
		case "3" : $tipo = "pol_aud_momento"; break;
		case "4" : $tipo = "pol_aud_ip"; break;
		case "5" : $tipo = "pol_aud_relevancia"; break;
	}
	return($tipo);
}
function extenso($tipo){
	switch($tipo){
		case "1" : $tipo = "Quem"; break;
		case "2" : $tipo = "O que"; break;
		case "3" : $tipo = "Quando"; break;
		case "4" : $tipo = "Onde"; break;
		case "5" : $tipo = "Relevância"; break;
	}
	return($tipo);
}
 if($row_dadosGrafico['pol_graf_grupo']=="3"){
  $agrupar = " GROUP BY date_format(pol_aud_momento,'%d/%m/%Y') ";
 }else{
   $agrupar = " GROUP BY pol_auditoria.".agrupar($row_dadosGrafico['pol_graf_grupo']);

 }
//select dos dados
	$pol_pol_codigo = $row_dadosGrafico['pol_pol_codigo'];
	//le XML
	$xml 	= new gerenciaXML();
	$nmFile  = session_id();
	$file 	 = fopen($xml->diretorio().$nmFile.".xml", "w");//abre o arquivo
	$escreve = fwrite($file, $row_dadosPolitica['pol_pol_xml']); //escreve no arquivo com a Hora
	fclose($file);//fecha o arquivo
	
	$doc = $xml->leituraXML($nmFile);
	$root 		= $doc->getElementsByTagName('politica')->item(0);
	$condicoes	= $root->getElementsByTagName('condicao')->item(0);
	$cond		= "";
	
	//condição=======================================================================================	
	foreach($condicoes->childNodes as $condicao){
		if($condicao->getAttribute("publicado")=="1"){
			$campo		= $condicao->getAttribute("campo");
			$aCondicao 	= utf8_decode($condicao->getAttribute("tipoCondicao"));
			$valor		= utf8_decode($condicao->getAttribute("valor"));

			//Exceto data e condição = > < <>
			if($condicao->getAttribute("campoData")=="1"){
				$valor = explode("|",$valor);
				$dataIni= arrumaDate($valor[0]);
				$dataFim= arrumaDate($valor[1]);
				
				$cond.= " AND $campo >='$dataIni' AND $campo <='$dataFim'";
			} else {
				//se like inicio
				if($condicao->getAttribute("tipoCondicao")=="inicio"){
					$cond.= " AND $campo LIKE '$valor%'";
					
				}else if($condicao->getAttribute("tipoCondicao")=="contenha"){
				//se like contenha
					$cond.= " AND $campo LIKE '%$valor%'";
					
				}else if($condicao->getAttribute("tipoCondicao")=="fim"){
				//se like fim
					$cond.= " AND $campo LIKE '%$valor'";
					
				}else{//qualquer outra
					$cond.= " AND $campo $aCondicao '$valor'";
				}
			}
		}
	}
	//ordenação=======================================================================================
	$ordenacao	= $root->getElementsByTagName('ordenacao')->item(0);
	$arrayOrdena= array();
	
	foreach($ordenacao->childNodes as $ordena){
		if($ordena->getAttribute("publicado")=="1"){
			$campo		= $ordena->getAttribute("campo");
			$ordem 		= $ordena->getAttribute("tipoCondicao");
			$valor		= $ordena->getAttribute("valor");

			array_push($arrayOrdena,$ordem."|".$campo."|".$valor);
		}
	}
	//ordena array
	sort($arrayOrdena);
	//varre array
	$Order="";
		for($a=0;$a<count($arrayOrdena);$a++){
			$informacoes = explode("|",$arrayOrdena[$a]);
			$Order.= ", ".$informacoes[1]." ".$informacoes[2];
		}
		
	$Ordenacao = count($arrayOrdena)>0?"ORDER BY" .substr($Order,1):"";
	$Condicoes = $cond;

	$Sql = "SELECT date_format(pol_aud_momento,'%d/%m/%Y') AS pol_aud_momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo, pol_apl_nome, count(".agrupar($row_dadosGrafico['pol_graf_grupo']).") as Total FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE 1=1 $Condicoes $agrupar $Ordenacao";

	mysqli_select_db($policy, $database_policy);
	$query_detalhegeral = $Sql;
	$detalhegeral = mysqli_query($policy, $query_detalhegeral) or die(mysql_error());
	$row_detalhegeral = mysqli_fetch_assoc($detalhegeral);
	$totalRows_detalhegeral = mysqli_num_rows($detalhegeral);
	
	$texto_linha 		= array();
	$texto_coluna 		= array();
	$valores 			= array();
	$total				= 0;
		do{
			array_push($texto_linha,$row_detalhegeral[agrupar($row_dadosGrafico['pol_graf_grupo'])]);
			array_push($texto_coluna,$row_detalhegeral['Total']);
			array_push($valores,$row_detalhegeral['Total']);
			$total+= $row_detalhegeral['Total'];
		} while ($row_detalhegeral = mysqli_fetch_assoc($detalhegeral));
?>