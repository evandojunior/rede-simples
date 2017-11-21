<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_mod_flu_codigo")||($indice=="bbh_mod_flu_codigo")){ $bbh_mod_flu_codigo = $valor; }
	if(($indice=="amp;bbh_cam_det_flu_codigo")||($indice=="bbh_cam_det_flu_codigo")){ $bbh_cam_det_flu_codigo = $valor; }
	if(($indice=="amp;bbh_cam_det_flu_nome")||($indice=="bbh_cam_det_flu_nome")){ $bbh_cam_det_flu_nome = $valor; }
}

//--
$sqlColunas = "SELECT TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME FROM information_schema.COLUMNS 
			WHERE TABLE_SCHEMA='$database_bbhive' AND TABLE_NAME='bbh_modelo_fluxo_".$bbh_mod_flu_codigo."_detalhado'";
list($rsColunas, $rows, $totalRows_Colunas) = executeQuery($bbhive, $database_bbhive, $sqlColunas, $initResult = false);
//--
$tabelaCriada = $totalRows_Colunas > 0 ? 1 : 0;
//--

if($tabelaCriada == 1){
	$query_ConsultaTabela = "select $bbh_cam_det_flu_nome, length($bbh_cam_det_flu_nome) from bbh_modelo_fluxo_".$bbh_mod_flu_codigo."_detalhado where length($bbh_cam_det_flu_nome) > 0 AND $bbh_cam_det_flu_nome is not null GROUP by $bbh_cam_det_flu_nome order by 1 ASC";
    list($ConsultaTabela, $rows, $totalRows_ConsultaTabela) = executeQuery($bbhive, $database_bbhive, $query_ConsultaTabela, $initResult = false);
	
	$CodigoCampo = $bbh_cam_det_flu_codigo;
?>
<select name='campo_<?php echo $CodigoCampo; ?>' class='verdana_11' id='campo_<?php echo $CodigoCampo; ?>' <?php if($totalRows_ConsultaTabela>0) { ?>style="width:260px;"<?php } ?>>
<?php	
	while($row_ConsultaTabela = mysqli_fetch_assoc($ConsultaTabela)){
?>
	<option value='<?php echo $row_ConsultaTabela[$bbh_cam_det_flu_nome]; ?>' $selected><?php echo $row_ConsultaTabela[$bbh_cam_det_flu_nome]; ?></option>
<?php } ?>
 </select>
<?php } else { ?>
	Tabela inexistente!
<?php } ?>