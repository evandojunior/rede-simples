<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$homeDestino = "/e-solution/servicos/bbhive/fluxos/modelosFluxos/paragrafos/paragrafos.php";

if($_GET['acao']=="subir"){
	//recupera dados da troca
	$bbh_mod_par_codigo = $_GET['bbh_mod_par_codigo'];
	$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
	
	//efetua primeiro select
	$query_modparagrafo = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
    list($modparagrafo, $row_modparagrafo, $totalRows_modparagrafo) = executeQuery($bbhive, $database_bbhive, $query_modparagrafo);
		//recupera dados do primeiro select
		$bbh_mod_par_nomeI 		= $row_modparagrafo['bbh_mod_par_nome'];
		$bbh_mod_par_tituloI 	= $row_modparagrafo['bbh_mod_par_titulo'];
		$bbh_mod_par_paragrafoI = $row_modparagrafo['bbh_mod_par_paragrafo'];
		$bbh_mod_flu_codigoI 	= $row_modparagrafo['bbh_mod_flu_codigo'];
		$bbh_mod_par_privadoI 	= $row_modparagrafo['bbh_mod_par_privado'];
		$bbh_usu_autorI 		= $row_modparagrafo['bbh_usu_autor'];
			if($bbh_usu_autorI===NULL){
				$bbh_usu_autorI='NULL';
			}
		$bbh_adm_codigoI 		= $row_modparagrafo['bbh_adm_codigo'];	
			if($bbh_adm_codigoI===NULL){
				$bbh_adm_codigoI='NULL';
			}
		
	//efetua segundo select
	$query_Todos = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_flu_codigo = $bbh_mod_flu_codigo ORDER BY bbh_mod_par_codigo ASC";
    list($Todos, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Todos, $initResult = false);
	 $cont=0;
		while ($row_Todos = mysqli_fetch_assoc($Todos)){
			if($row_Todos['bbh_mod_par_codigo']==$bbh_mod_par_codigo){
				mysqli_data_seek($Todos,$cont-1);
				$row_Todos  = mysqli_fetch_assoc($Todos);
				$codAnterior= $row_Todos['bbh_mod_par_codigo'];
				break;
			}
			$cont=$cont+1;
		}
	$query_modparagrafoII = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $codAnterior";
    list($modparagrafoII, $row_modparagrafoII, $totalRows_modparagrafoII) = executeQuery($bbhive, $database_bbhive, $query_modparagrafoII);

		//recupera dados do primeiro select
		$bbh_mod_par_nomeII 	= $row_modparagrafoII['bbh_mod_par_nome'];
		$bbh_mod_par_tituloII 	= $row_modparagrafoII['bbh_mod_par_titulo'];
		$bbh_mod_par_paragrafoII= $row_modparagrafoII['bbh_mod_par_paragrafo'];
		$bbh_mod_flu_codigoII 	= $row_modparagrafoII['bbh_mod_flu_codigo'];
		$bbh_mod_par_privadoII 	= $row_modparagrafoII['bbh_mod_par_privado'];
		$bbh_usu_autorII 		= $row_modparagrafoII['bbh_usu_autor'];
			if($bbh_usu_autorII===NULL){
				$bbh_usu_autorII='NULL';
			}
		$bbh_adm_codigoII 		= $row_modparagrafoII['bbh_adm_codigo'];	
			if($bbh_adm_codigoII===NULL){
				$bbh_adm_codigoII='NULL';
			}
		
	//efetua primeiro update
	 $updateSQLI = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nomeII', bbh_mod_par_titulo = '$bbh_mod_par_tituloII', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafoII', bbh_mod_flu_codigo=$bbh_mod_flu_codigoII, bbh_mod_par_privado='$bbh_mod_par_privadoII', bbh_usu_autor=$bbh_usu_autorII, bbh_adm_codigo=$bbh_adm_codigoII  WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQLI);
	
	//efetua segundo update
	 $updateSQLII = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nomeI', bbh_mod_par_titulo = '$bbh_mod_par_tituloI', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafoI', bbh_mod_flu_codigo=$bbh_mod_flu_codigoI, bbh_mod_par_privado='$bbh_mod_par_privadoI', bbh_usu_autor=$bbh_usu_autorI, bbh_adm_codigo=$bbh_adm_codigoI  WHERE bbh_mod_par_codigo = $codAnterior";
    list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQLII);
	 
	//echo $bbh_mod_par_codigo."<hr>";
	//echo $codAnterior;
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."?bbh_mod_flu_codigo=".$bbh_mod_flu_codigo."&Ts=".time()."','exibePar','&1=1','Atualizando dados...','loadOrdena','2','1');</var>";
	  exit;
}

if($_GET['acao']=="descer"){
	//recupera dados da troca
	$bbh_mod_par_codigo = $_GET['bbh_mod_par_codigo'];
	$bbh_mod_flu_codigo = $_GET['bbh_mod_flu_codigo'];
	
	//efetua primeiro select
	$query_modparagrafo = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
    list($modparagrafo, $row_modparagrafo, $totalRows_modparagrafo) = executeQuery($bbhive, $database_bbhive, $query_modparagrafo);
		//recupera dados do primeiro select
		//recupera dados do primeiro select
		$bbh_mod_par_nomeI 		= $row_modparagrafo['bbh_mod_par_nome'];
		$bbh_mod_par_tituloI 	= $row_modparagrafo['bbh_mod_par_titulo'];
		$bbh_mod_par_paragrafoI = $row_modparagrafo['bbh_mod_par_paragrafo'];
		$bbh_mod_flu_codigoI 	= $row_modparagrafo['bbh_mod_flu_codigo'];
		$bbh_mod_par_privadoI 	= $row_modparagrafo['bbh_mod_par_privado'];
		$bbh_usu_autorI 		= $row_modparagrafo['bbh_usu_autor'];
			if($bbh_usu_autorI===NULL){
				$bbh_usu_autorI='NULL';
			}
		$bbh_adm_codigoI 		= $row_modparagrafo['bbh_adm_codigo'];	
			if($bbh_adm_codigoI===NULL){
				$bbh_adm_codigoI='NULL';
			}
		
	//efetua segundo select
	$query_Todos = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_flu_codigo = $bbh_mod_flu_codigo ORDER BY bbh_mod_par_codigo ASC";
    list($Todos, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_Todos, $initResult = false);
	
		while ($row_Todos = mysqli_fetch_assoc($Todos)){
			if($row_Todos['bbh_mod_par_codigo']==$bbh_mod_par_codigo){
				$row_Todos = mysqli_fetch_assoc($Todos);
				$codProximo= $row_Todos['bbh_mod_par_codigo'];
				break;
			}
		}

	$query_modparagrafoII = "SELECT * FROM bbh_modelo_paragrafo WHERE bbh_mod_par_codigo = $codProximo";
    list($modparagrafoII, $row_modparagrafoII, $totalRows_modparagrafoII) = executeQuery($bbhive, $database_bbhive, $modparagrafoII);
		//recupera dados do primeiro select
		$bbh_mod_par_nomeII 	= $row_modparagrafoII['bbh_mod_par_nome'];
		$bbh_mod_par_tituloII 	= $row_modparagrafoII['bbh_mod_par_titulo'];
		$bbh_mod_par_paragrafoII= $row_modparagrafoII['bbh_mod_par_paragrafo'];
		$bbh_mod_flu_codigoII 	= $row_modparagrafoII['bbh_mod_flu_codigo'];
		$bbh_mod_par_privadoII 	= $row_modparagrafoII['bbh_mod_par_privado'];
		$bbh_usu_autorII 		= $row_modparagrafoII['bbh_usu_autor'];
			if($bbh_usu_autorII===NULL){
				$bbh_usu_autorII='NULL';
			}
		$bbh_adm_codigoII 		= $row_modparagrafoII['bbh_adm_codigo'];	
			if($bbh_adm_codigoII===NULL){
				$bbh_adm_codigoII='NULL';
			}
			
	//efetua primeiro update
	 $updateSQLI = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nomeII', bbh_mod_par_titulo = '$bbh_mod_par_tituloII', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafoII', bbh_mod_flu_codigo=$bbh_mod_flu_codigoII, bbh_mod_par_privado='$bbh_mod_par_privadoII', bbh_usu_autor=$bbh_usu_autorII, bbh_adm_codigo=$bbh_adm_codigoII  WHERE bbh_mod_par_codigo = $bbh_mod_par_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQLI);
	
	//efetua segundo update
	 $updateSQLII = "UPDATE bbh_modelo_paragrafo SET bbh_mod_par_nome = '$bbh_mod_par_nomeI', bbh_mod_par_titulo = '$bbh_mod_par_tituloI', bbh_mod_par_paragrafo = '$bbh_mod_par_paragrafoI', bbh_mod_flu_codigo=$bbh_mod_flu_codigoI, bbh_mod_par_privado='$bbh_mod_par_privadoI', bbh_usu_autor=$bbh_usu_autorI, bbh_adm_codigo=$bbh_adm_codigoI  WHERE bbh_mod_par_codigo = $codProximo";
    list($Result2, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQLII);
//	echo $bbh_mod_par_codigo."<hr>";
	//echo $codProximo;
	//efetua segundo update
	echo "<var style='display:none'>OpenAjaxPostCmd('".$homeDestino."?bbh_mod_flu_codigo=".$bbh_mod_flu_codigo."&Ts=".time()."','exibePar','&1=1','Atualizando dados...','loadOrdena','2','1');</var>";
	  exit;
}
?>