<?php 
//----------------------------------------------------------------------------------------------------------------------
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
//--
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/PDF_HTML/fpdf.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/PDF_HTML/fpdi.php");
	//recupera ID----------------------------------------
	settype($_POST['id'], "integer");
	$bbh_rel_codigo = $_POST['id'];
	isset($_POST['chk_cabecalho']) ? $cabeca = true : "";
	isset($_POST['chk_rodape']) ? $rodape=true : "";
	//---------------------------------------------------
	
	$localizacao_documento 	= explode("web",$_SESSION['caminhoFisico']);
	$diretorioDestino 		= $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$_POST['bbh_flu_codigo']."/documentos/".$bbh_rel_codigo."/";
	$nomeArquivo			= 'rel_'.$bbh_rel_codigo.'_'.trataCaracteres(strtolower($_SESSION['relNome'])).'.pdf';
//----------------------------------------------------------------------------------------------------------------------

//Tenho que seguir vários passos e chamar, este arquivo novamente para manipular o PDF
	function atualiza($valor){
			echo '<var style="display:none">document.getElementById("atual").value="'.$valor.'";executaPDF();</var>';
	}
	function finaliza($valor, $bbh_rel_codigo, $database_bbhive, $bbhive){
			//Ja tenho o PDF criado
			$UPDATE = "UPDATE bbh_relatorio SET bbh_rel_pdf = '1' where bbh_rel_codigo =  $bbh_rel_codigo";
            list($resultado, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $UPDATE);
			//--
		
			//cria form
			$form = '<form name="downloadPDF" id="downloadPDF" action="/datafiles/servicos/bbhive/temp_transf/'.$_SESSION['usuCod'].'/relatorio_final.pdf" style="display:none" target="_blank"></form>' ;

			echo "
				<var style='display:none'>
					document.getElementById('tr".($valor-1)."').className = 'Processado';
					document.getElementById('td".($valor-1)."').innerHTML = icon(1);
		
					document.getElementById('tr".($valor)."').className = 'Processado';
					document.getElementById('td".($valor)."').innerHTML = icon(1);
					
					document.getElementById('atual').value='".$valor."';
					submeterPDF();
					//window.top.document.getElementById('carregaTudo').innerHTML = '&nbsp;';
				</var>";
	}////
	if($_POST['atual'] == 1){
		//REMOVE POSSÍVEL ARQUIVO EXISTENTE NO SISTEMA
			@unlink($diretorioDestino.$nomeArquivo);
			@unlink($diretorioDestino."relatorio_final.pdf");

		//--Marca se relatório será visivel
			$vis = isset($_POST['impVisivel']) ? "0" : "1";
			$updateSQL = "UPDATE bbh_relatorio SET bbh_rel_protegido='$vis' WHERE bbh_rel_codigo=".$bbh_rel_codigo;
            list($Result1, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		//--
		atualiza(2);//Atualizo para ir para o próximo
		//--
	} elseif($_POST['atual'] == 2){
		//GERA PDF E COLOCA NO DIRETÓRIO
			require_once("gera_pdf.php");
		//--
		atualiza(3);//Atualizo para ir para o próximo
		//--
	} elseif($_POST['atual'] == 3){
		//JUNTA PDF
			require_once("anexa_pdf.php");
		//--	
			atualiza(4);//Atualizo para ir para o próximo
		//--
	} elseif($_POST['atual'] == 4){
		//JUNTA PDF
			require_once("copia_pdf.php");
		//--	
			finaliza(5, $bbh_rel_codigo, $database_bbhive, $bbhive);//Atualizo para ir para o próximo
		//--
	}
?>