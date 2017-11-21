<?php
if(isset($_GET['executa'])){
	$nmTabela  = "pol_auditoria";
    $nmTratada = "pol_auditoria_".date('d')."_".date('m')."_".date('Y');
		
	mysql_select_db($database_policy, $policy);	
	$sql 	= "SHOW TABLES";
	$result = mysql_query($sql, $policy) or die(mysql_error());
	$existe = 0;
	
	while ($row = mysql_fetch_row($result)) {
		if($row[0]==$nmTratada){
			$existe=1;
		}
	}

	if($existe==0){
		
		//recupera o último registro da tabela anterior
		mysql_select_db($database_policy, $policy);
		$ultimoRegistro = "select pol_aud_codigo FROM pol_auditoria Order By pol_aud_codigo DESC LIMIT 1";
		$strultimoRegistro = mysql_query($ultimoRegistro, $policy) or die(mysql_error());
		$row_strultimoRegistro = mysql_fetch_assoc($strultimoRegistro);
		$idUltimo = $row_strultimoRegistro['pol_aud_codigo'];
		
		//renomeio a tabela
		mysql_select_db($database_policy, $policy);
		$Renomear = "ALTER TABLE $nmTabela RENAME $nmTratada";
		$strRenomear = mysql_query($Renomear, $policy) or die(mysql_error());

		//comando para duplicar tabela
		mysql_select_db($database_policy, $policy);
		$Duplicar = "CREATE TABLE $nmTabela  SELECT * FROM $nmTratada Where 1<>1;";
		$strDuplicar = mysql_query($Duplicar, $policy) or die(mysql_error());
	
		//altera a estrutura colocando as chaves e índices
		mysql_select_db($database_policy, $policy);
		$AlteraIndices = "ALTER TABLE $nmTabela 
					  MODIFY pol_aud_codigo INT AUTO_INCREMENT PRIMARY KEY,
					  ADD INDEX pol_apl_codigo (pol_apl_codigo),
					  ADD INDEX pol_aud_usuario (pol_aud_usuario),
					  ADD CONSTRAINT pol_apl_codigo_".time()." FOREIGN KEY (pol_apl_codigo) REFERENCES pol_aplicacao (pol_apl_codigo) ON UPDATE NO ACTION;";
		mysql_query($AlteraIndices, $policy) or die(mysql_error());
		
		//insere registro na nova tabela
		echo $insertSQL = "INSERT INTO $nmTabela (pol_aud_codigo) Values ($idUltimo)";
		mysql_select_db($database_policy, $policy);
		$Result1 = mysql_query($insertSQL, $policy) or die(mysql_error());
		
		//apaga registro da nova tabela
		$deleteSQL = "DELETE FROM $nmTabela WHERE pol_aud_codigo = $idUltimo";
		mysql_select_db($database_policy, $policy);
		$Result1 = mysql_query($deleteSQL, $policy) or die(mysql_error());
	
	//finaliza processo
		header("Location: index.php?msgAcao=Procedimento finalizado com sucesso.");
		
	} else {
		header("Location: index.php?msgAcao=Este procedimento não pode ser finalizado, pois já ocorreu hoje.");
	}
	exit;
}
?>