<?php

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_indicio'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--
if($tabelaCriada==1){
	//--
	//====Fazendo a atualização
	$nomeTabelaFisica 		= "bbh_indicio";
	$bbh_pro_codigo 		= $_SESSION['idProtocolo']!=0 ? $_SESSION['idProtocolo']: $bbh_pro_codigo;
	$codigo					= $_POST['codigo'];
	$bbh_ind_codigo			= !isset($_POST['bbh_ind_codigo']) ? 0 : $_POST['bbh_ind_codigo'];

		//RecordSet dos campos
		$query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = $codigo
							   order by tp.bbh_ordem_exibicao ASC";
        list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);
		
		//Tabela física
		$query_tabela_fisica = "SELECT * FROM $nomeTabelaFisica WHERE bbh_ind_codigo =" . $bbh_ind_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);
		//--
		if($totalRows_tabela_fisica == 0){
			//--
			$sqlInsercao = "INSERT INTO $nomeTabelaFisica(bbh_pro_codigo) VALUES(".$bbh_pro_codigo.")";
            list($Result1, $rowS, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
			$bbh_ind_codigo = mysqli_insert_id($bbhive);
		}
		//-----------------------------------------------------------------------
		
			$sqlInsercao = "UPDATE $nomeTabelaFisica";
			$campos = "";
			$valores = " SET bbh_tip_codigo=".$codigo.", bbh_usu_codigo='".$_SESSION['usuCod']."', bbh_ind_cadastro=NOW(),";
			
			while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento)){
				//--
				$tipoDeCampo 	= $row_campos_detalhamento['bbh_cam_ind_tipo'];
				$nomeFisico 	= $row_campos_detalhamento['bbh_cam_ind_nome'];
				//--
					$campos .= $nomeFisico . ",";
					if($tipoDeCampo == "horario_editavel")
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
					}else if($tipoDeCampo == "time_stamp")
					{
	
						$TS = $_POST['TS'.$nomeFisico];
						$valores .= " $nomeFisico = '" . $TS . "'" . ",";
							
					}else if($tipoDeCampo == "data")
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
						 
					}else if($tipoDeCampo == "correio_eletronico" || $tipoDeCampo == "endereco_web" || $tipoDeCampo == "lista_opcoes" || $tipoDeCampo == "lista_dinamica" || $tipoDeCampo == "texto_longo" || $tipoDeCampo == "texto_simples"){
						//--Somente um caracter neste campo
						if($nomeFisico=="bbh_ind_confiabilidade_fonte" || $nomeFisico=="bbh_ind_veracidade_informacao"){
							$_POST[$nomeFisico] = substr($_POST[$nomeFisico],0,1);
						}
						//--
						$valores .= " $nomeFisico = '" . ($_POST[$nomeFisico]) . "'" . ",";
					}else if($tipoDeCampo == "numero_decimal"){
						 
						 if($_POST[$nomeFisico] != '')
						  {
							  $valor = str_replace(".","",$_POST[$nomeFisico]);
							  $valor = str_replace(",",".",$valor);
							  $valores .= " $nomeFisico = ". $valor . ",";
						  }else{
							$valores .= " $nomeFisico = NULL,";
						  }
	
					}else if($tipoDeCampo == "numero"){
						
						if($_POST[$nomeFisico] != '')
						{
							$valores .= " $nomeFisico = " . $_POST[$nomeFisico] . ",";
						}else{
							$valores .= " $nomeFisico = NULL,";
						}
					}
				//--
			}
		$valores = substr($valores,0,strlen($valores)-1);
		$sqlInsercao .= $valores . " WHERE bbh_ind_codigo =" . $bbh_ind_codigo;

        list($Result1, $rowS, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
}
?>