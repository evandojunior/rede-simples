<?php
//
// CONEXÃO COM O BANCO
//
	if (!isset($_SESSION)) { session_start();}
	require_once($_SESSION['EndFisico'].'Connections/ged.php');
//
// PRODECIMENTO DO PLUGIN CAMPO AUTOMATICO
//
	if(isset($_GET['campoAutomatico'])){
		$valores	= explode('|',$_GET['campoAutomatico']);
		$result		= $_GET['result'];
		foreach($valores as $valor){
			//pega os dados
			$pegaCodigo		= explode('>',$valor);
			$quebraValores	= explode(':',$pegaCodigo[0]);
			$quebraDados	= explode(',',$pegaCodigo[1]);
			$cam_codigo		= $quebraDados[0];
			$nmTabela		= $quebraDados[1];
			$nmDisparador	= "cam_".$quebraValores[1];
			$nmOrigem		= $nmTabela.$quebraValores[2];
			$nmBusca		= "cam_".$quebraValores[3];
			$nmRetorno		= "cam_".$quebraValores[4];
			//busca o nome do campo disparador
			mysql_select_db($database_ged, $ged);
			$query_rsDados = "SELECT $nmRetorno FROM $nmOrigem WHERE $nmBusca = '$result'";
			$rsDados = mysql_query($query_rsDados, $ged) or die(mysql_error());
			$row_rsDados = mysqli_fetch_assoc($rsDados);
			$totalRows_rsDados = mysql_num_rows($rsDados);
			//exibe o resultado no input
			echo "<var style='display:none'>document.getElementById('cam_$cam_codigo').value='$row_rsDados[$nmRetorno]'</var>";
		}
	}
//
// PROCEDIMENTO DE EXECUÇÃO
//
	if(isset($_POST['executa'])){
		//plugin valor unico
		if(!empty($_POST['valorUnico'])){
			$sep_0 = explode('<%SEP_0%>',$_POST['valorUnico']);
			foreach($sep_0 as $sep_0){
				$sep_1		= explode('<%SEP_1%>',$sep_0);
				$sep_2		= explode('<%SEP_2%>',$sep_1[0]);
				$nmTabela	= $sep_1[1];
				foreach($sep_2 as $sep_2){
					$sep_3	= explode('<%SEP_3%>',$sep_2);
					$nmCampo	= $sep_3[0];
					$titCampo	= $sep_3[1];
					$vlCampo	= $sep_3[2];
					//busca e verifica se o valor jé existe
					mysql_select_db($database_ged, $ged);
					$query_rsDados = "SELECT $nmCampo FROM $nmTabela WHERE $nmCampo = '$vlCampo'";
					$rsDados = mysql_query($query_rsDados, $ged) or die(mysql_error());
					$row_rsDados = mysqli_fetch_assoc($rsDados);
					$totalRows_rsDados = mysql_num_rows($rsDados);
					if($totalRows_rsDados>0){
						echo "<var style='display:none'>alert(\"O ".$titCampo." digitado já está cadastrado. Informe outro valor.\");</var>";
						exit;
					}
				}
			}
		}
		//execução padrão
		require_once($_SESSION['EndFisico'].$_POST['url_execucao']);
	}
?>
