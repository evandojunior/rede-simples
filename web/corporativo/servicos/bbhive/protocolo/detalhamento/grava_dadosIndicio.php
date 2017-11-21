<?php
include_once("../../../../../Connections/bbhive.php");
require_once("../../../../../../database/config/globalFunctions.php");

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $fetch, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);

//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
$bbh_ind_codigo			= !isset($_POST['bbh_ind_codigo']) ? 0 : $_POST['bbh_ind_codigo'];

//--
if($tabelaCriada==1 && isset($_POST['codigo'])){
	//--
	//====Fazendo a atualização
	$nomeTabelaFisica 		= "bbh_indicio";
	$codigo					= $_POST['codigo'];

		//RecordSet dos campos
		$query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = $codigo
							   order by tp.bbh_ordem_exibicao ASC";
        list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);
//		echo "<hr>$bbh_ind_codigo<hr>";
		//Tabela física
		$query_tabela_fisica = "SELECT * FROM $nomeTabelaFisica WHERE bbh_ind_codigo =" . $bbh_ind_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		//-----------------------------------------------------------------------
		
			$sqlInsercao = "UPDATE $nomeTabelaFisica";
			$campos = "";
			$valores = " SET bbh_tip_codigo=".$codigo.",";
			
			while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
				//--
				$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_ind_tipo'];
				$nomeFisico 	= $row_campos_detalhamento['bbh_cam_ind_nome'];
				//--
					$campos .= $nomeFisico . ",";
					if($tipoDeCampo == "horario_editavel")
					{
						//
						if( isset($_POST[$nomeFisico]) )
						{ 
							$data = substr($_POST['Data'.$nomeFisico],6,4) . "-";
							$data .= substr($_POST['Data'.$nomeFisico],3,2) . "-";
							$data .= substr($_POST['Data'.$nomeFisico],0,2);
								 
							$am_pm = $_POST['am_pm'.$nomeFisico];
							$hora = $_POST[$nomeFisico . "HH"];
							$minuto = $_POST[$nomeFisico . "MM"];
							$segundo = $_POST[$nomeFisico . "SS"];	
							if($am_pm == 'AM') 
							{
								if($hora != 12)
								{
									$hora = $hora;
								}else{
									$hora = "00";
								}
							}else{
								if($hora != 12)
								{
									$hora = 12 + $hora;
								}else{
									$hora = 12;
								}
							}
							
							$tempo = $data . " ". $hora . ":" . $minuto . ":" . $segundo;		
							$valores .= " $nomeFisico = '" . $tempo . "'" . ",";
						}
					}else if($tipoDeCampo == "time_stamp")
					{
						//
						if( isset($_POST[$nomeFisico]) )
						{ 
							$TS = $_POST['TS'.$nomeFisico];
							$valores .= " $nomeFisico = '" . $TS . "'" . ",";
						}
						
					}else if($tipoDeCampo == "data")
					{
						//
						if( isset($_POST[$nomeFisico]) )
						{ 
							if($_POST[$nomeFisico] != '')
							{
								 $data = substr($_POST[$nomeFisico],6,4) . "-";
								 $data .= substr($_POST[$nomeFisico],3,2) . "-";
								 $data .= substr($_POST[$nomeFisico],0,2);
								 $valores .= " $nomeFisico = '" . $data . "'" . ","; 
							}else{
								$valores .= " $nomeFisico = NULL,";
							}
						}
						 
					}else if($tipoDeCampo == "correio_eletronico" || $tipoDeCampo == "endereco_web" || $tipoDeCampo == "lista_opcoes" || $tipoDeCampo == "lista_dinamica" || $tipoDeCampo == "texto_longo" || $tipoDeCampo == "texto_simples"){
					
						//
						if( isset($_POST[$nomeFisico]) )
						$valores .= " $nomeFisico = '" . ($_POST[$nomeFisico]) . "'" . ",";
					
					
					}else if($tipoDeCampo == "numero_decimal"){
						
						//
						if( isset($_POST[$nomeFisico]) )
						{ 
							 if($_POST[$nomeFisico] != '')
							  {
								  
									  $valor = str_replace(".","",$_POST[$nomeFisico]);
									  $valor = str_replace(",",".",$valor);
									  $valores .= " $nomeFisico = ". $valor . ",";
							  }else{
								$valores .= " $nomeFisico = NULL,";
							  }
						}
	
					}else if($tipoDeCampo == "numero"){
					
						//
						if( isset($_POST[$nomeFisico]) )
						{ 
							if($_POST[$nomeFisico] != '')
							{
								$valores .= " $nomeFisico = " . $_POST[$nomeFisico] . ",";
							}else{
								$valores .= " $nomeFisico = NULL,";
							}
						}
					}
				//--
			}
		$valores = substr($valores,0,strlen($valores)-1);
		$sqlInsercao .= $valores . " WHERE bbh_ind_codigo =" . $bbh_ind_codigo;
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
		
}

$query = "
SELECT flu.bbh_flu_codigo
	
FROM `bbh_indicio` as ind
	
	inner join `bbh_protocolos` as pro ON (ind.bbh_pro_codigo = pro.bbh_pro_codigo)
	inner join `bbh_fluxo` as flu ON (pro.bbh_flu_codigo = flu.bbh_flu_codigo)
	
WHERE ind.bbh_ind_codigo = $bbh_ind_codigo LIMIT 1";
list($query, $fetch, $totalRows) = executeQuery($bbhive, $database_bbhive, $query);
$bbh_flu_codigo = $fetch['bbh_flu_codigo'];
?>
<var style="display:none;">
showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=<?PHP echo $bbh_flu_codigo;?>&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=1&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');
</var>