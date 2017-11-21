<?php require_once('../../../../Connections/policy.php'); ?>
<?php

$colname_codigo = "-1";
if (isset($_GET['pol_apl_codigo'])) {
  $colname_codigo = $_GET['pol_apl_codigo'];
}

//Condições para resultado
$CondicaoSQL = "1=1";

if(isset($_GET['quemdet'])){
	$CondicaoSQL = " group by pol_aud_usuario";
	$Ordenacao	 = " pol_aud_usuario asc";
	$NmCombo 	 = "pol_quem";
	$ValorCombo  = "pol_aud_usuario";
} elseif(isset($_GET['relevanciadet'])){
	$CondicaoSQL = " group by pol_aud_relevancia";
	$Ordenacao	 = " pol_aud_relevancia asc";
	$NmCombo 	 = "pol_relevancia";
	$ValorCombo  = "pol_aud_relevancia";
} elseif(isset($_GET['dia'])){
	$CondicaoSQL = " group by DATE_FORMAT(pol_aud_momento, '%d%m%Y')";
	$Ordenacao	 = " pol_aud_momento desc";
	$NmCombo 	 = "pol_quando";
	$ValorCombo  = "momento";
} elseif(isset($_GET['ip'])){
	$CondicaoSQL = " group by pol_aud_ip";
	$Ordenacao	 = " pol_aud_ip ASC";
	$NmCombo 	 = "pol_onde";
	$ValorCombo  = "pol_aud_ip";
} elseif(isset($_GET['acao'])){
	$CondicaoSQL = " group by pol_aud_acao";
	$Ordenacao	 = " pol_aud_acao ASC";
	$NmCombo	 = "pol_oque";
	$ValorCombo  = "pol_aud_acao";
} else { echo "Ocorreu um erro inesperado, entre em contato com o administrador do sistema."; }

mysqli_select_db($policy, $database_policy);
$query_detalhegeral = "SELECT date_format(pol_aud_momento,'%d/%m/%Y %H:%i:%s') AS momento, pol_aud_usuario, pol_aud_acao, pol_aud_ip, pol_aud_nivel, pol_aud_relevancia, pol_aud_codigo FROM pol_auditoria RIGHT JOIN pol_aplicacao ON pol_auditoria.pol_apl_codigo = pol_aplicacao.pol_apl_codigo WHERE pol_aplicacao.pol_apl_codigo = $colname_codigo $CondicaoSQL ORDER BY $Ordenacao";
$detalhegeral = mysqli_query($policy, $query_detalhegeral) or die(mysql_error());
$row_detalhegeral = mysqli_fetch_assoc($detalhegeral);
$totalRows_detalhegeral = mysqli_num_rows($detalhegeral);

$HMTL = "<select name='$NmCombo' id='$NmCombo' class='verdana_9' style='width:320px;'>";
	do {
	$HMTL.= "<option value='".$row_detalhegeral[$ValorCombo]."'>".$row_detalhegeral[$ValorCombo]."</option>";
	} while ($row_detalhegeral = mysqli_fetch_assoc($detalhegeral));
$HMTL.= "</select>";

echo $HMTL;
?>
