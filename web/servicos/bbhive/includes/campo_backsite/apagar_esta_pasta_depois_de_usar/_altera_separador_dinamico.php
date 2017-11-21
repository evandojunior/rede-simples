<?php
// OS CAMPOS DO TIPO COMBO NÃO USA MAIS A VIRGULA COMO SEPARADOR
// ESTE SCRIPT TEM COMO OBJETIVO MOSTRAR TODOS OS CAMPOS DO TIPO COMBO E IRÁ ALTERA-LO
// PARA O NOVO SEPARADOR PADRÃO
	if (!isset($_SESSION)) { session_start();}
	if(!isset($_SESSION['EndFisico'])){ header('Location: http://'.$_SERVER['HTTP_HOST'].'/servicos/ged/login.php');}
	require_once($_SESSION['EndFisico'].'servicos/ged/includes/autentica.php');

	if(isset($_POST['update'])){
		foreach($_POST as $chave=>$valor){
			if(($chave !='submit')||$chave !='update'){
				mysql_select_db($database_ged, $ged);
				$update_sql = "UPDATE ged_campo SET cam_vl_default = '".addslashes($valor)."' WHERE cam_nome = '$chave'";
				mysql_query($update_sql, $ged) or die(mysql_error());
			}
		}
		exit;
	}
	
	mysql_select_db($database_ged, $ged);
	$query_rsCampos = "SELECT * FROM ged_campo WHERE cam_tipo = 14";
	$rsCampos = mysql_query($query_rsCampos, $ged) or die(mysql_error());
	$row_rsCampos = mysqli_fetch_assoc($rsCampos);
	$totalRows_rsCampos = mysql_num_rows($rsCampos);
?>
<form name="form1" id="form1" action="altera_separador_dinamico.php" method="post">
<?php
do{
	?>
	<br/>
<input name="<?=$row_rsCampos['cam_nome']?>" id="<?=$row_rsCampos['cam_nome']?>" value="<?=$row_rsCampos['cam_vl_default']?>" size="200" />
<?php
}while($row_rsCampos = mysqli_fetch_assoc($rsCampos));
?>
<input name="submit" id="submit" type="submit"  />
<input name="update" id="update" />
</form>