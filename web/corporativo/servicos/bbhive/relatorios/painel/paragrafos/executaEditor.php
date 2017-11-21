<?php if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
require_once("functions.php");

if(isset($insert)){
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];//
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];//
    $bbh_par_paragrafo	= retiraHTML(retiraTagHTML($_POST['editor1']));//
	$bbh_par_momento	= $_POST['bbh_par_momento'];//
	$bbh_par_titulo		= ($_POST['bbh_par_titulo']);//
	$bbh_par_autor		= ($_POST['bbh_par_autor']);//
	
	//Ação para incluir curingas
		require_once('executaCuringas.php');
	//----
	$bbh_par_paragrafo	= $conteudo;
	
	//seleciona ordenação do modelo
	$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
    list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);
	$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
	
	//inserção do parágrafo de fato
	 $insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_titulo,bbh_par_paragrafo,bbh_par_ordem, bbh_par_momento, bbh_par_autor) VALUES ($bbh_rel_codigo,'$bbh_par_titulo','$bbh_par_paragrafo',$ordenacao, '$bbh_par_momento', '$bbh_par_autor')";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	 
} else {
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
	$bbh_par_titulo		= ($_POST['bbh_par_titulo']);
    $bbh_par_paragrafo	= retiraHTML(retiraTagHTML($_POST['editor1']));//
	
	//Ação para incluir curingas
		require_once('executaCuringas.php');
	//----
	$bbh_par_paragrafo	= $conteudo;
	
	//atualiza informações
   $updateSQL ="UPDATE bbh_paragrafo SET bbh_par_paragrafo='$bbh_par_paragrafo', bbh_par_titulo='$bbh_par_titulo' WHERE bbh_par_codigo=$bbh_par_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
}

 if(isset($_SESSION['bbh_par_titulo'])){unset($_SESSION['bbh_par_titulo']);}
 if(isset($_SESSION['textoEdito'])){unset($_SESSION['textoEdito']);}
 if(isset($_SESSION['bbh_par_codigo'])){unset($_SESSION['bbh_par_codigo']);}
 ?><script type="text/javascript">
		window.top.window.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo;?>&Ts=<?php echo time(); ?>&"','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');
	</script>