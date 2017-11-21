<?php if(!isset($_SESSION)){ session_start(); }
ob_start();
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	if(isset($_POST['addInd'])){
	
	foreach($_POST as $indice=>$valor){
		if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){	$bbh_ati_codigo= $valor; } 
		if(($indice=="amp;bbh_rel_codigo")||($indice=="bbh_rel_codigo")){ 	$bbh_rel_codigo= $valor; } 
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ 	$bbh_flu_codigo= $valor; } 
	}
		//--
		$query_protocolo = "select bbh_pro_codigo from bbh_protocolos where bbh_flu_codigo = $bbh_flu_codigo";
        list($protocolo, $row_protocolo, $totalRows_protocolo) = executeQuery($bbhive, $database_bbhive, $query_protocolo);
		$codProtocolo = $row_protocolo['bbh_pro_codigo'];
		//--
		$semAnexo = true;
		$semImagem= true;
		
		ob_clean();								// limpa o buffer
		require_once('includes/indicios.php');	// carrega o conteúdo do arquivo html para o buffer
		$html = ob_get_clean();					// pega o conteudo do buffer, insere na variavel e limpa a memória
	
		//recupera variáveis do POST
		$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
		$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
		$bbh_par_paragrafo	= $html;
		$bbh_par_momento	= $_POST['bbh_par_momento'];
		$bbh_par_titulo		= ($_POST['bbh_par_titulo']);
		$bbh_par_autor		= ($_POST['bbh_par_autor']);
		
		//seleciona ordenação do modelo
		$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
        list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);

		$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
		
		//inserção do parágrafo de fato
        $insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_titulo,bbh_par_paragrafo,bbh_par_ordem, bbh_par_momento, bbh_par_autor) VALUES ($bbh_rel_codigo,'$bbh_par_titulo','$bbh_par_paragrafo',$ordenacao, '$bbh_par_momento', '$bbh_par_autor')";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);
	?>
    <script type="text/javascript">
		window.top.window.uploadFile.reset();
		window.top.window.OpenAjaxPostCmd('/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>&bbh_rel_codigo=<?php echo $bbh_rel_codigo;?>&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&Ts=<?php echo time(); ?>&"','listaParagrafos','&1=1','Atualizando dados...','listaParagrafos','2','2');
	</script>	
    <?php
	exit();
}
?>