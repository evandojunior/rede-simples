<?php
//========== REGRAS DESTA PÁGINA ==========//
//
// INCLUSÕES DESTA PÁGINA:
//
	if (!isset($_SESSION)) { session_start();}
	require_once($_SESSION['EndFisico'].'servicos/ged/includes/autentica.php');
//
// PROCEDIMENTO:
//
	mysql_select_db($database_ged, $ged);
	$query_rsBuscaTabelas = "SELECT cam_codigo, emp_codigo, cam_nome FROM ged_campo_especifico ORDER BY emp_codigo";
	$rsBuscaTabelas = mysql_query($query_rsBuscaTabelas, $ged) or die(mysql_error());
	$row_rsBuscaTabelas = mysqli_fetch_assoc($rsBuscaTabelas);
	$totalRows_rsBuscaTabelas = mysql_num_rows($rsBuscaTabelas);
	do{
		echo $string = "UPDATE ged_campo_especifico SET cam_nome='cam_esp_".$row_rsBuscaTabelas['cam_codigo']."' WHERE cam_codigo = ".$row_rsBuscaTabelas['cam_codigo'];
		echo "<br />";
		mysql_query($string, $ged) or die(mysql_error());

		$tabela = 'ged_atributos_'.$row_rsBuscaTabelas['emp_codigo'];
		
		if($row_rsBuscaTabelas['cam_nome']!='cam_esp_'.$row_rsBuscaTabelas['cam_codigo']){
			echo $string_2 = "ALTER TABLE `$tabela` CHANGE COLUMN `".$row_rsBuscaTabelas['cam_nome']."` `cam_esp_".$row_rsBuscaTabelas['cam_codigo']."`";
			echo "<br />";
			$rsBuscaTabelas = mysql_query($string_2, $ged) or die(mysql_error());
		}

	}while($row_rsBuscaTabelas = mysqli_fetch_assoc($rsBuscaTabelas));
	echo 'feito!';
?>