<div style="background:#FFF"><?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/detalhamento/includes/functions.php");

if ((isset($_POST["camposDetalhamento"])) && ($_POST["camposDetalhamento"] == "1")) {
	//====Fazendo a atualização
	$nomeTabelaFisica 		= $_POST['nome_tabela'];
	$codigo_modelo_fluxo 	= $_POST['bbh_mod_flu_codigo'];
	$bbh_flu_codigo 		= $_POST['bbh_flu_codigo'];
	$colunasDet				= $_POST['colunasDet'];
	//--

	echo isset($_POST['acaoDaVez']) ? $_POST['acaoDaVez'] : '-';
	//--
		//RecordSet dos campos
		$query_campos_detalhamento = "SELECT * FROM bbh_campo_detalhamento_fluxo  INNER JOIN bbh_detalhamento_fluxo ON bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo  WHERE bbh_detalhamento_fluxo.bbh_mod_flu_codigo = $codigo_modelo_fluxo AND bbh_cam_det_flu_disponivel='1' AND bbh_cam_det_flu_codigo in ($colunasDet)";
        list($campos_detalhamento, $row_campos_detalhamento, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento);
		
		//Tabela física
		$query_tabela_fisica = "SELECT * FROM $nomeTabelaFisica WHERE bbh_flu_codigo =" . $bbh_flu_codigo;
        list($tabela_fisica, $row_tabela_fisica, $totalRows_tabela_fisica) = executeQuery($bbhive, $database_bbhive, $query_tabela_fisica);


		if($totalRows_tabela_fisica == 0)
		{
			$chave = "bbh_mod_flu_".$_POST['bbh_flu_codigo']."_det_codigo_pk";
			$sqlInsercao = "INSERT INTO $nomeTabelaFisica(bbh_flu_codigo) VALUES(".$bbh_flu_codigo.")";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
		}
		$sqlInsercao = "UPDATE $nomeTabelaFisica";
		$campos = "";
		$valores = " SET ";
	//--
		do{
		
			$tipoDeCampo = $row_campos_detalhamento['bbh_cam_det_flu_tipo'];
			$nomeFisico = $row_campos_detalhamento['bbh_cam_det_flu_nome'];
			
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
					 
				}else if($tipoDeCampo == "correio_eletronico" or $tipoDeCampo == "endereco_web" or $tipoDeCampo == "lista_opcoes" or $tipoDeCampo == "lista_dinamica" or $tipoDeCampo == "texto_longo" or $tipoDeCampo == "texto_simples"){
				
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
		
		}while($row_campos_detalhamento = mysqli_fetch_assoc($campos_detalhamento));
		//--
		
		$valores = substr($valores,0,strlen($valores)-1);
		$sqlInsercao .= $valores . " WHERE bbh_flu_codigo =" . $bbh_flu_codigo;

		if ($totalRows_campos_detalhamento > 0 && strlen($valores) > 4) {
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sqlInsercao);
        }
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1.1";
	$Evento="Atualizou o detalhamento (".$bbh_flu_codigo.") de ".$_SESSION['FluxoNome']."  - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/ 
}

echo "<var style='display:none'>executaAcaoAtividade();</var>";
?></div>