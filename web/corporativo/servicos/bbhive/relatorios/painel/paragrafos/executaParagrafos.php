<?php 

if(!isset($_SESSION)){ session_start(); }
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

require_once("functions.php");

if(isset($_POST['addPar'])){ 
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
	$bbh_mod_par_codigo	= $_POST['bbh_mod_par_codigo'];
	$bbh_par_autor		= ($_POST['bbh_par_autor']);
	//dados básicos do parágrafo
	$dadosModelo 		= explode("|*|",recuperaParagrafo($bbh_mod_par_codigo));
	$titleParagrafo		= $dadosModelo[0];
	$bbh_par_paragrafo	= $dadosModelo[1];
	//Ação para incluir curingas
		require_once('executaCuringas.php');
	//----
	//seleciona ordenação do modelo
	$query_ordenacao_paragrafos = "SELECT MAX(bbh_par_ordem) ultimo_paragrafo FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo";
    list($ordenacao_paragrafos, $row_ordenacao_paragrafos, $totalRows_ordenacao_paragrafos) = executeQuery($bbhive, $database_bbhive, $query_ordenacao_paragrafos);
	$ordenacao = $row_ordenacao_paragrafos['ultimo_paragrafo']+1;
	
	//inserção do parágrafo de fato
	$insertSQL = "INSERT INTO bbh_paragrafo (bbh_rel_codigo, bbh_par_titulo,bbh_par_paragrafo,bbh_par_ordem, bbh_par_momento, bbh_par_autor, bbh_mod_par_codigo) VALUES ($bbh_rel_codigo,'$titleParagrafo','$conteudo',$ordenacao, '".date('Y-m-d')."', '$bbh_par_autor', $bbh_mod_par_codigo)";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

	//destrói as sessões utilizadas
	  $_SESSION['arrayCuringa'] = NULL;
	  $_SESSION['arrayDetalhamento'] = NULL;
	  unset($_SESSION['arrayCuringa']);
	  unset($_SESSION['arrayDetalhamento']);
	  
	//redireciona para página desejada
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo='.$bbh_ati_codigo.'&bbh_rel_codigo='.$bbh_rel_codigo.'&Ts='.time();
	$carregaPagina= "OpenAjaxPostCmd('".$homeDestino."','listaParagrafos','&1=1','&nbsp;Carregando dados...','listaParagrafos','2','2');";
	echo '<var style="display:none">'.$carregaPagina.'</var>';
	exit;
}
//======================================================INSERE PARAGRAFO
if(isset($_POST['insertParagrafo'])){
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
    $bbh_par_paragrafo	= "---";
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
	  
	//redireciona para página desejada
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo='.$bbh_ati_codigo.'&bbh_rel_codigo='.$bbh_rel_codigo.'&Ts='.time();
	$carregaPagina= "OpenAjaxPostCmd('".$homeDestino."','listaParagrafos','&1=1','&nbsp;Carregando dados...','listaParagrafos','2','2');";
	echo '<var style="display:none">'.$carregaPagina.'</var>';
 exit;
}
//======================================================ATUALIZA PARAGRAFO
if(isset($_POST['updateParagrafo'])){
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
	$bbh_par_codigo		= $_POST['bbh_par_codigo'];
	$bbh_par_titulo		= mysqli_fetch_assoc($_POST['bbh_par_titulo']);
    $bbh_par_paragrafo	= mysqli_fetch_assoc($_POST['texto']);
	
	//atualiza informações
  $updateSQL ="UPDATE bbh_paragrafo SET bbh_par_paragrafo='$bbh_par_paragrafo', bbh_par_titulo='$bbh_par_titulo' WHERE bbh_par_codigo=$bbh_par_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	//redireciona para página principal
 	//$chama = 'paragrafos.php?bbh_ati_codigo='.$bbh_ati_codigo.'&bbh_rel_codigo='.$bbh_rel_codigo.'&Ts='.time()."&";
	//$homeDestino	= '/corporativo/servicos/bbhive/relatorios/atividade/gerencia/'.$chama;
	//$carregaPagina  = "OpenAjaxPostCmd('".$homeDestino."','paragrafos','&1=1','&nbsp;Carregando dados...','carregaDuplicado','2','2');";
	//echo '<var style="display:none">'.$carregaPagina.'</var>';
	exit;
}
//======================================================EXCLUIR PARAGRAFO
if(isset($_POST['exRel'])){
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_POST['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_POST['bbh_ati_codigo'];
	$bbh_par_codigo		= $_POST['bbh_par_codigo'];
	$bbh_par_arquivo	= $_POST['bbh_par_arquivo'];
	$bbh_flu_codigo		= $_POST['bbh_flu_codigo'];
	//exclui paragrafo
	$deleteSQL = "DELETE FROM bbh_paragrafo WHERE bbh_par_codigo=$bbh_par_codigo";
    list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $deleteSQL);
  
  	//verifica se tem arquivo e exclui o mesmo
	$diretorio	= explode("web", strtolower(str_replace("\\","/",$_SESSION['caminhoFisico'])));
	$Imagem		= $diretorio[0]."database/servicos/bbhive/fluxo/fluxo_".$bbh_flu_codigo."/imagens/".$bbh_par_arquivo;
	$File		= str_replace("/imagens","/documentos/".$bbh_rel_codigo,$Imagem);
	
	if(file_exists($Imagem)){
		@unlink($Imagem);
	}
	if(file_exists($File)){
		@unlink($File);
	}

	//redireciona para página desejada
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo='.$bbh_ati_codigo.'&bbh_rel_codigo='.$bbh_rel_codigo.'&Ts='.time();
	$carregaPagina= "OpenAjaxPostCmd('".$homeDestino."','listaParagrafos','&1=1','&nbsp;Carregando dados...','listaParagrafos','2','2');";
	echo '<var style="display:none">'.$carregaPagina.'</var>';
	exit;
}

//======================================================ORDENAR PARAGRAFO
if(isset($_GET['acao'])){
	//recupera variáveis do POST
	$bbh_rel_codigo 	= $_GET['bbh_rel_codigo'];
  	$bbh_ati_codigo		= $_GET['bbh_ati_codigo'];
	$bbh_par_codigo		= $_GET['bbh_par_codigo'];
	$bbh_par_ordem		= $_GET['ordem'];
	//Troca ordem
	
	if($_GET['acao']=="descer"){
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_par_ordem;// + 1;

		echo $query_Paragrafo = "select bbh_par_codigo, bbh_par_ordem FROM bbh_paragrafo Where bbh_rel_codigo= $bbh_rel_codigo and bbh_par_ordem > $nvOrdem ORDER BY bbh_par_ordem ASC LIMIT 1";
        list($Paragrafo, $row_Paragrafo, $totalRows_Paragrafo) = executeQuery($bbhive, $database_bbhive, $query_Paragrafo);
		
		//recupero os dados de quem irá trocar comigo
		$idNovo 	= $row_Paragrafo['bbh_par_codigo'];
		$ordemNovo 	= $row_Paragrafo['bbh_par_ordem'];
		
		$idVelho	= $bbh_par_codigo;
		$ordemVelha	= $bbh_par_ordem;

		//1º UPDATE
        if ($ordemNovo > 0 && $ordemVelha > 0) {
            $updateSQL = "UPDATE bbh_paragrafo SET bbh_par_ordem=$ordemNovo WHERE bbh_par_codigo = $idVelho";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

            //2º UPDATE
            $updateSQL2 = "UPDATE bbh_paragrafo SET bbh_par_ordem=$ordemVelha WHERE bbh_par_codigo = $idNovo";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL2);
        }
	} else {
		//verifico quem é o anterior para trocar comigo
		//verifico quem é o proximo para trocar comigo
		$nvOrdem = $bbh_par_ordem;// - 1;

		$query_Paragrafo = "select bbh_par_codigo, bbh_par_ordem FROM bbh_paragrafo Where bbh_rel_codigo= $bbh_rel_codigo and bbh_par_ordem < $nvOrdem ORDER BY bbh_par_ordem DESC LIMIT 1";
        list($Paragrafo, $row_Paragrafo, $totalRows_Paragrafo) = executeQuery($bbhive, $database_bbhive, $query_Paragrafo);
		
		//recupero os dados de quem irá trocar comigo
		$idNovo 	= $row_Paragrafo['bbh_par_codigo'];
		$ordemNovo 	= $row_Paragrafo['bbh_par_ordem'];
		
		$idVelho	= $bbh_par_codigo;
		$ordemVelha	= $bbh_par_ordem;

		//1º UPDATE
        if ($ordemNovo > 0 && $ordemVelha > 0) {
            $updateSQL = "UPDATE bbh_paragrafo SET bbh_par_ordem=$ordemNovo WHERE bbh_par_codigo = $idVelho";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);

            //2º UPDATE
            $updateSQL2 = "UPDATE bbh_paragrafo SET bbh_par_ordem=$ordemVelha WHERE bbh_par_codigo = $idNovo";
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL2);
        }
	}
	
	//echo $_SERVER['QUERY_STRING'];
	//redireciona para página desejada
	$homeDestino	= '/corporativo/servicos/bbhive/relatorios/painel/includes/lista.php?bbh_ati_codigo='.$bbh_ati_codigo.'&bbh_rel_codigo='.$bbh_rel_codigo.'&Ts='.time();
	$carregaPagina= "OpenAjaxPostCmd('".$homeDestino."','listaParagrafos','&1=1','&nbsp;Carregando dados...','listaParagrafos','2','2');";
	
	echo '<var style="display:none">'.$carregaPagina.'</var>';
	exit;
}