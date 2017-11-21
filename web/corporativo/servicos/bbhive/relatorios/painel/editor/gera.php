<?php ob_start();  //inicia o buffer
	
	//recupera todos os parágrafos do banco, com seus devídos títulos
	$query_relatorio = "select bbh_rel_data_criacao, bbh_flu_codigo from bbh_relatorio inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo where bbh_rel_codigo =  $bbh_rel_codigo";
    list($relatorio, $row_relatorio, $totalRows_relatorio) = executeQuery($bbhive, $database_bbhive, $query_relatorio);
	//--
	$_SESSION['dtCriacaoRel'] = arrumadata($row_relatorio["bbh_rel_data_criacao"]);
	//--

	$query_paragrafo = "SELECT * FROM bbh_paragrafo WHERE bbh_rel_codigo = $bbh_rel_codigo ORDER BY bbh_par_ordem ASC";
    list($paragrafo, $rows, $totalRows_paragrafo) = executeQuery($bbhive, $database_bbhive, $query_paragrafo, $initResult = false);
	
	$localizacao_documento = explode("web",$_SESSION['caminhoFisico']);
	$diretorio = $localizacao_documento[0] . "database/servicos/bbhive/fluxo/fluxo_".$row_relatorio['bbh_flu_codigo'];
	$diretorio.= "/documentos/".$bbh_rel_codigo."/";
	
	//recupera parâmetros para montar o PDF
	$a			=1;
	$conteudo	="";
	//-----------------------------------------------------------------------------------------------------------
	$ig=0;
		while($row_paragrafo = mysqli_fetch_assoc($paragrafo)){
			
			if($row_paragrafo['bbh_par_titulo']=="Bl@ck_arquivo_ANEXO*~"){
			  if(isset($_POST['infAnexo'])){
				$titulo = '<br /><span style="font-size: 13px"><span style="font-family: tahoma,geneva,sans-serif"><strong>Anexo - '.romano($a).'</strong> - '.$row_paragrafo['bbh_par_paragrafo'].'</span></span></center><p>&nbsp;</p>';
				$conteudo	.= $titulo;
			  }
				$a++;//soma anexos
			} elseif($row_paragrafo['bbh_par_titulo']=="Bl@ck_quebra_LINHA*~") {
				//descomentar a linha abaixo
				$mpdf->WriteHTML(($conteudo));//imprime conteúdo concatenado
				$mpdf->AddPage();//adiciona nova página
				$conteudo	="";//zera o conteúdo pois acabei de imprimir
			} else {

				//verifico sem tem anexo de imagem
				if(!empty($row_paragrafo['bbh_par_arquivo'])){
					$ig++;
					$v = "v_".$ig;
					$mpdf->$v = file_get_contents($diretorio . $row_paragrafo['bbh_par_arquivo']);
					//-- Faz uma cópia do arquivo para que possa gerar o relatório, a imagen tem um ID, depois de gerar a imagem, devo apagar o arquivo
					/*$destino = "../../../../../../datafiles/servicos/bbhive/img_temp";
						if(!file_exists($destino)){
							mkdir($destino,777);
							chmod($destino,0777);
						}
					//--
					$nmArquivo= $row_paragrafo['bbh_par_arquivo'];
					$origem   = $diretorio . $row_paragrafo['bbh_par_arquivo'];
					$destino .= "/".$nmArquivo;
					//--
					copy($origem, $destino);
					//--
					$img = "../../../../../../datafiles/servicos/bbhive/img_temp/".$nmArquivo;
							//<img src="'.$img.'"  style="margin-top:-2px;"/>*/		
					$div = '<div style="float:left; width:49%; margin-left:1%;">
							 '.$row_paragrafo['bbh_par_paragrafo'].'<br>
							 <img src="var:'.$v.'"  style="margin-top:-2px;"/><br>
							 <div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#666">
							   '.$row_paragrafo['bbh_par_legenda'].'
							 </div>
							</div>';
	
					$conteudo	.= $div;

				} else {
					//concatena conteúdo
					$conteudo	.= '<div style="clear:both">'.$row_paragrafo['bbh_par_paragrafo'].'</div><br />';
				}
			}
		}
		if(!empty($conteudo)){
			$mpdf->WriteHTML(($conteudo));//imprime conteúdo concatenado
		}
	//-----------------------------------------------------------------------------------------------------------	

?>