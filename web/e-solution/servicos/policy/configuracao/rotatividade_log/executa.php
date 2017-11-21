<?php
if(isset($_GET['executa'])){
	$nmTabela  = "pol_auditoria";
    $nmTratada = "pol_auditoria_".date('d')."_".date('m')."_".date('Y');
		
	mysqli_select_db($policy, $database_policy);
	$sql 	= "SHOW TABLES";
	$result = mysqli_query($policy, $sql) or die(mysql_error());
	$existe = 0;
	
	while ($row = mysqli_fetch_row($result)) {
		if($row[0]==$nmTratada){
			$existe=1;
		}
	}

	if($existe==0){
		
		//recupera o último registro da tabela anterior
		mysqli_select_db($policy, $database_policy);
		$ultimoRegistro = "select pol_aud_codigo FROM pol_auditoria Order By pol_aud_codigo DESC LIMIT 1";
		$strultimoRegistro = mysqli_query($policy, $ultimoRegistro) or die(mysql_error());
		$row_strultimoRegistro = mysqli_fetch_assoc($strultimoRegistro);
		$idUltimo = $row_strultimoRegistro['pol_aud_codigo'];
		
		//renomeio a tabela
		mysqli_select_db($policy, $database_policy);
		$Renomear = "ALTER TABLE $nmTabela RENAME $nmTratada";
		$strRenomear = mysqli_query($policy, $Renomear) or die(mysql_error());

		//comando para duplicar tabela
		mysqli_select_db($policy, $database_policy);
		$Duplicar = "CREATE TABLE $nmTabela  SELECT * FROM $nmTratada Where 1<>1;";
		$strDuplicar = mysqli_query($policy, $Duplicar) or die(mysql_error());
	
		//altera a estrutura colocando as chaves e índices
		mysqli_select_db($policy, $database_policy);
		$AlteraIndices = "ALTER TABLE $nmTabela 
					  MODIFY pol_aud_codigo INT AUTO_INCREMENT PRIMARY KEY,
					  ADD INDEX pol_apl_codigo (pol_apl_codigo),
					  ADD INDEX pol_aud_usuario (pol_aud_usuario),
					  ADD CONSTRAINT pol_apl_codigo_".time()." FOREIGN KEY (pol_apl_codigo) REFERENCES pol_aplicacao (pol_apl_codigo) ON UPDATE NO ACTION;";
		mysqli_query($policy, $AlteraIndices) or die(mysql_error());
		
		//insere registro na nova tabela
		echo $insertSQL = "INSERT INTO $nmTabela (pol_aud_codigo) Values ($idUltimo)";
		mysqli_select_db($policy, $database_policy);
		$Result1 = mysqli_query($policy, $insertSQL) or die(mysql_error());
		
		//apaga registro da nova tabela
		$deleteSQL = "DELETE FROM $nmTabela WHERE pol_aud_codigo = $idUltimo";
		mysqli_select_db($policy, $database_policy);
		$Result1 = mysqli_query($policy, $deleteSQL) or die(mysql_error());
	
	//finaliza processo
		header("Location: index.php?msgAcao=Procedimento finalizado com sucesso.");
		
	} else {
		header("Location: index.php?msgAcao=Este procedimento não pode ser finalizado, pois já ocorreu hoje.");
	}
	exit;
}
?>