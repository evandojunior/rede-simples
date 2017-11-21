<?php


//recupera o diretório da aplicação, sendo que não sei em qual aplicação estou
$divisor = "web";//padrão letra minuscula
$dirPadrao = explode($divisor,str_replace("\\","/",(dirname(__FILE__))));
$dirOnde = $dirPadrao[0]."web";

$tmpMax = ini_get('max_execution_time');

if(!isset($_SESSION)){ session_start(); }
require_once($dirOnde."/Connections/bbhive.php");
require_once($dirOnde."/corporativo/servicos/bbhive/includes/functions.php");


	function getFileExtension($str) {
	
			$i = strrpos($str,".");
			if (!$i) { return ""; }
	
			$l = strlen($str) - $i;
			$ext = substr($str,$i+1,$l);
	
			return $ext;
	
	}
   // Edit upload location here
	//$localizacao_documento = explode("web",$caminhoFisico);
	$path = $dirPadrao[0];
	
	$nm = $_GET['ts'];
	$var = base64_decode(file_get_contents($dirOnde . "/datafiles/servicos/bbhive/sessao/$nm.txt",'w'));
	$dados = explode('&',$var);
	
	$codFluxo 		= $dados[0];
	$Autor			= $dados[2];
	$acao			= $dados[3];
	$caminhoFisico 	= $dados[4];
	$codUsu			= $dados[5];
	$arqPublico		= $dados[6];
	$obsAqrPublico  = $dados[7];
	
	$arquivo = isset($_FILES['file']) ? $_FILES['file'] : FALSE;
	//verifica o tamanho do arquivo antes de mover
	$tamMaximo = ini_get('upload_max_filesize')*1024*1024;
	
		if($arquivo["size"] > $tamMaximo){
			echo '<script language="javascript" type="text/javascript">
					alert("Erro ao efetuar upload, arquivo muito grande!");
				  </script>';	
			exit;
		}

	//
	// Pega extens&atilde;o do arquivo			
	$pext = getFileExtension($arquivo["name"]);
	
	$codigo_usuario = $codUsu;
			
		$diretorio = $path . "database";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/servicos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
		$diretorio.= "/bbhive";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/fluxo";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/fluxo_".$codFluxo;
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}
	
	$diretorio.= "/arquivos";
	if(!file_exists($diretorio)) {	
		mkdir($diretorio, 777);
		chmod($diretorio,0777);
	}

   $result = 0;
   $target_path = $diretorio . basename($_FILES['file']['name']);

	//Permissão no diretório
	$caminho = $diretorio;
	@chmod($caminho,0777);

	$localizacao = "/fluxo/fluxo_".$codFluxo."/arquivos";
	
	$dataModificado 	= date("Y-m-d H:i:s");
//	$codFluxo	    	= $_SESSION['bbh_flu_codigo'];
//	$Autor 				= $_SESSION['bbh_arq_autor'];
	$tituloArquivo = str_replace(".$pext","",($arquivo["name"]));

	$Titulo				= (isset($_POST['bbh_arq_titulo'])) ? $_POST['bbh_arq_titulo'] : $tituloArquivo;//$_POST['bbh_arq_titulo'];
	$Descricao			= (isset($_POST['bbh_arq_descricao'])) ? $_POST['bbh_arq_descricao'] : $tituloArquivo;
	$obsAqrPublico		= (isset($_POST['bbh_arq_obs_publico'])) ? $_POST['bbh_arq_obs_publico'] : $dados[7];
	$nomeArquivo 		= trataCaracteres(str_replace(".$pext" , "", strtolower($arquivo["name"]))).".$pext";//"arq.$pext";
	$mimeType			= $arquivo["type"];
	
	$Compartilhado		= ($dados[1]=='true')? 1 : 0;
	$arqPublico			= ($dados[6]=='true')? 1 : 0;
	
	$Compartilhado		= (isset($_POST['bbh_arq_compartilhado'])) ? 1 : $Compartilhado;
	$arqPublico			= (isset($_POST['bbh_arq_publico'])) ? 1 : $arqPublico;
//	if(isset($_SESSION['bbh_arq_compartilhado'])){
//		$Compartilhado	= 1;	
//	}
	
	//AQUI COMEÇA O CÓDIGO PARA INSERÇÃO NO BANCO
	if($acao == 'insert'){
	
		$insertSQL = sprintf("INSERT INTO bbh_arquivo (bbh_arq_autor, bbh_arq_titulo, bbh_arq_descricao, bbh_arq_localizacao, bbh_arq_data_modificado, bbh_arq_versao, bbh_usu_codigo, bbh_flu_codigo, bbh_arq_compartilhado, bbh_arq_nome,bbh_arq_tipo, bbh_arq_nome_logico, bbh_arq_mime, bbh_arq_publico, bbh_arq_obs_publico) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
							   GetSQLValueString($bbhive, $Autor, "text"),
							   GetSQLValueString($bbhive, $Titulo, "text"),
							   GetSQLValueString($bbhive, $Descricao, "text"),
							   GetSQLValueString($bbhive, $localizacao, "text"),
							   GetSQLValueString($bbhive, $dataModificado, "date"),
							   GetSQLValueString($bbhive, 1, "int"),
							   GetSQLValueString($bbhive, $codigo_usuario, "int"),
							   GetSQLValueString($bbhive, $codFluxo, "int"),
							   GetSQLValueString($bbhive, $Compartilhado, "int"),
							   GetSQLValueString($bbhive, $nomeArquivo, "text"),
							   GetSQLValueString($bbhive, $pext, "text"),
							   GetSQLValueString($bbhive, $nomeArquivo, "text"),
							   GetSQLValueString($bbhive, $mimeType, "text"),
							   GetSQLValueString($bbhive, $arqPublico, "text"),
							   GetSQLValueString($bbhive, $obsAqrPublico, "text"));

		/*$log = fopen("/var/www/backsite/projeto12/database/servicos/bbhive/log.txt",'a');
		$txto = fwrite($log, $insertSQL);
		fclose($log);*/

        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $insertSQL);

		$idArquivo = "SELECT bbh_arq_codigo FROM bbh_arquivo WHERE bbh_arq_codigo = LAST_INSERT_ID()";
        list($idArquivo, $row_idArquivo, $totalRows_idArquivo) = executeQuery($bbhive, $idArquivo, $insertSQL);

		$idreal = $row_idArquivo['bbh_arq_codigo'];
		
		$updateSQL = "UPDATE bbh_arquivo SET bbh_arq_nome='".$idreal."_$nomeArquivo' WHERE bbh_arq_codigo=$idreal";
        list($Result2, $row, $totalRows) = executeQuery($bbhive, $idArquivo, $updateSQL);
		 
		 //move o arquivo para a pasta
		// Caminho de onde a imagem ficar
		$imagem_dir = $diretorio ."/".$idreal."_".$nomeArquivo;
		
		// Faz o upload da imagem
		$c=0;
//		move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
		while (move_uploaded_file($arquivo["tmp_name"], $imagem_dir)) {
			// aguarda o envio...
					if($c == 30){
						$tmpMax = $tmpMax + 1;
						set_time_limit($tmpMax);
						$c = -1;
					}
					$c++;
		}
	
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Incluiu o arquivo ($nomeArquivo) no ".$_SESSION['arqNome']." - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	echo true;
	exit;
	}
	//AQUI TERMINA O CÓDIGO PARA INSERÇÃO NO BANCO
	
	//AQUI COMEÇA O CÓDIGO PARA ATUALIZAÇÃO DO ARQUIVO
	if(isset($_POST['MM_update'])){
		$idArquivo = $_POST['bbh_arq_codigo'];
		
		$updateSQL = "UPDATE bbh_arquivo SET bbh_arq_compartilhado = $Compartilhado, bbh_arq_titulo = '$Titulo', bbh_arq_descricao = '$Descricao', bbh_arq_publico = '$arqPublico', bbh_arq_obs_publico = '$obsAqrPublico'  WHERE bbh_arq_codigo = $idArquivo";

        list($Result1, $row, $totalRows) = executeQuery($bbhive, $idArquivo, $updateSQL);
		
	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Alterou informações do arquivo cód. ($idArquivo) - (".$Titulo.") do ".$_SESSION['arqNome']." - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
		unset($_SESSION['MM_update']);
	}	
	//AQUI TERMINA O CÓDIGO PARA ATUALIZAÇÃO DO ARQUIVO
	
	//AQUI COMEÇA O CÓDIGO PARA EXCLUSÃO DO ARQUIVO
	if(isset($_POST['MM_delete'])){
		$idArquivo = $_POST['bbh_arq_codigo'];

		$query_arquivo = "SELECT * FROM bbh_arquivo WHERE bbh_arq_codigo = $idArquivo";
        list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $idArquivo, $query_arquivo);
		
		$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
		$path = $localizacao_documento[0];
		
		$codigo_usuario = $_SESSION['usuCod'];
		$diretorio = $path . "database/servicos/bbhive/fluxo/fluxo_".$row_arquivo['bbh_flu_codigo']."/arquivos/".$row_arquivo['bbh_arq_nome'];	

		if(file_exists($diretorio)){
			unlink($diretorio);
		}

	     $deleteSQL = "DELETE FROM bbh_arquivo WHERE bbh_arq_codigo=$idArquivo";
        list($Result1, $rows, $totalRows) = executeQuery($bbhive, $idArquivo, $deleteSQL);
		 
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Excluiu o arquivo cód. ($idArquivo) - (".$row_arquivo['bbh_arq_nome'].") do ".$_SESSION['arqNome']." - BBHive corporativo.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	}	
	//AQUI TERMINA O CÓDIGO PARA EXCLUSÃO DO ARQUIVO
	
	//AQUI COMEÇA O CÓDIGO PARA EXCLUSÃO DO ARQUIVO
	if(isset($_POST['MM_delete_multiplo'])){
		foreach($_POST as $i => $v){
			if(substr($i,0,3) == 'chb'){
				$idArquivo = $v;//$_POST['bbh_arq_codigo'];
	//			echo($idArquivo . '<br>');

				$query_arquivo = "SELECT * FROM bbh_arquivo WHERE bbh_arq_codigo = $idArquivo";
                list($arquivo, $row_arquivo, $totalRows_arquivo) = executeQuery($bbhive, $idArquivo, $query_arquivo);
				
				$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
				$path = $localizacao_documento[0];
				
				$codigo_usuario = $_SESSION['usuCod'];
				$diretorio = $path . "database/servicos/bbhive/fluxo/fluxo_".$row_arquivo['bbh_flu_codigo']."/arquivos/".$row_arquivo['bbh_arq_nome'];	
			
				if(file_exists($diretorio)){
					unlink($diretorio);
				}
			
				$deleteSQL = "DELETE FROM bbh_arquivo WHERE bbh_arq_codigo=$idArquivo";
                list($Result1, $rows, $totalRows) = executeQuery($bbhive, $idArquivo, $deleteSQL);
	
				/*===============================INICIO AUDITORIA POLICY=========================================*/
				$_SESSION['relevancia']="0";
				$_SESSION['nivel']="1";
				$Evento="Excluiu o arquivo cód. ($idArquivo) - (".$row_arquivo['bbh_arq_nome'].") do ".$_SESSION['arqNome']." - BBHive corporativo.";
				EnviaPolicy($Evento);
				/*===============================FIM AUDITORIA POLICY============================================*/
			}
		}
		$url = '';
		if(isset($_POST['bbh_flu_codigo_sel'])){
			$url .= "bbh_flu_codigo=".$_POST['bbh_flu_codigo_sel'];
		}
		if(isset($_POST['bbh_ati_codigo'])){
			$url .= "&bbh_ati_codigo=".$_POST['bbh_ati_codigo'];
		}
        
		echo("<var style='display:none'>
		showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?lp=true&$url|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');
		</var>");
		exit;
	}
	//AQUI TERMINA O CÓDIGO PARA EXCLUSÃO DO ARQUIVO
?>
<script language="javascript" type="text/javascript">
//window.top.document.getElementById('carregaTudo').innerHTML='&nbsp;
window.top.window.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?lp=true&<?php if(isset($_POST['bbh_flu_codigo_sel'])){ echo "bbh_flu_codigo=".$_POST['bbh_flu_codigo_sel']; } if(isset($_POST['bbh_ati_codigo'])){echo "&bbh_ati_codigo=".$_POST['bbh_ati_codigo']; } ?>|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');
//window.top.location.href='/corporativo/servicos/bbhive/arquivos/upload/limpa.php';
</script>   
