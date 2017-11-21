<?php
	//recupera arquivos em PDF's anexados
	//varre diretório e descobre quais são os PDF's respeitando o que já foi gerado
	  //--
		//Abrir o diretório e adicionar no ZIP todos os arquivos
		echo $arquivoPrincipal 		= $nomeArquivo;
		
		function extensao($arquivo){
			$arquivo = substr($arquivo, -4);
				if($arquivo[0] == '.'){
					  $arquivo = substr($arquivo, -3);
				}
			return $arquivo;
		}
			
		function ordemDoArquivo($bbh_par_codigo, $database_bbhive, $bbhive){
			$query_relatorio = "select bbh_par_ordem from bbh_paragrafo where bbh_par_codigo =  $bbh_par_codigo";
            list($relatorio, $row_relatorio, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relatorio);
			return $row_relatorio['bbh_par_ordem'];
		}
		
		class concat_pdf extends FPDI { 
		 
			var $files = array(); 
		 
			function setFiles($files) { 
				$this->files = $files; 
			} 
		 
			function concat() { 
				foreach($this->files AS $file) { 
					$pagecount = $this->setSourceFile($file); 
					for ($i = 1; $i <= $pagecount; $i++) { 
						 $tplidx = $this->ImportPage($i); 
						 $s = $this->getTemplatesize($tplidx); 
						 $this->AddPage('P', array($s['w'], $s['h'])); 
						 $this->useTemplate($tplidx); 
					} 
				} 
			} 
			//-- Cabeçalho padrão
			function Header()
			{
				if($this->textCabecalho == 1){// definiu cabeçalho?
					$this->SetMargins(30,0); //Coloca as margens no cabeçalho (largura,altura)
					$this->Ln(3);
					$imagem = "../../../../../../datafiles/servicos/bbhive/corporativo/images/cabeca_relatorio.jpg";
				
					if(file_exists($imagem))
					{
						$this->Image($imagem,27, 3,164, 33,"JPEG", ""); //Traz a imagem no canto superior esquerdo.
					}
				}
			}
			//<img src="" width="777" height="179">
			//-- Rodapé padrão
			function Footer()
			{
				$this->SetMargins(37,0); //Coloca as margens no cabeçalho (largura,altura)
				//Vai para 1.5 cm da borda inferior
				$this->SetY(-17);
				//Seleciona Arial itálico 8
				$this->SetFont('Arial','I',6);
				//Imprime o número da página centralizado
				//$this->Cell(0,0,'Pagina '.$this->PageNo().'',0,0,'R');
				$this->Cell(70,0, $this->textCabecalho4 ,0,0,'L');
				
				if($this->textCabecalho3 == 1){//tem paginação?
					$this->Cell(87,0, utf8_decode('Página '.$this->PageNo().'/{total}'),0,0,'R');
				}
				if($this->textCabecalho2 == 1){// definiu rodapé?
					$imagem = "../../../../../../datafiles/servicos/bbhive/corporativo/images/rodape_relatorio.jpg";
				
					if(file_exists($imagem))
					{
						//$this->Image($imagem); //Traz a imagem no canto superior esquerdo.
						$this->Image($imagem,27,282, 164, 12,"JPEG", ""); //Traz a imagem no canto superior esquerdo.
					}
				}
			}
		}
		//--
		$arquivos = array();
		if ($handle = @opendir($diretorioDestino.".")) {
			$cont  = 0;
			$dif	= 0;
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if(strtolower($file)!="thumbs.db"){	
						//coloca todos os pdfs no vetor
						if( extensao($file) == "pdf"){
							if(substr($file,0,4) == "rel_"){
								$arquivos[ 0 ] = $diretorioDestino . $file;
							} else {
								$nmArray = explode("_",$file);
								$arquivos[ $nmArray[0] ] = $diretorioDestino . $file;
							}
						}
						//--
						$cont++; 
						$dif = $dif + 1;
						//se chegar a 100 ele para
						if ($cont == 850) { die;}	
					}
				}
			}
			closedir($handle);
		}
		//===================
		
		//Ordena vetor
		ksort($arquivos);
		//--
		//Se tiver apenas dois índices, significa que tenho apenas um PDF
		if(count($arquivos) > 2){
			//senão tenho que descobrir a ordem certa de cada arquivo
			foreach($arquivos as $indice => $valor){
				if($indice > 0){
					$ordem = ordemDoArquivo($indice, $database_bbhive, $bbhive);
					//acabei de recuperar a ordem de inserção agora tenho que mudar no vetor
					$arquivos[ $ordem ] = $valor;
					//removo o vetor com informações anteriores
					unset($arquivos[ $indice ]);
					//--
				}
			}
		}
		//===================
		//Ordena vetor
		ksort($arquivos);
		//--
		//print_r($arquivos);
		//exit;
		//Agora inicio o processo para anexar vários PDF'S
		$pdf = new concat_pdf(); 
		
		//Definição de cabeçalho padrão
		$pdf->textCabecalho = isset($cabeca) ? 1 : 0;//define se usará cabeçalho
		$pdf->textCabecalho2= isset($rodape) ? 1 : 0;//define se usará rodapé
		//--
		$pdf->textCabecalho3= $_POST['chk_numpages']!="chk_n_pages" ? 1 : 0;//Rodapé com paginação
		$pdf->textCabecalho4= "";//Rodapé com paginação e data
		
			if($_POST['chk_numpages']=="chk_data") {
				
				if($_POST['dtHora'] == 1){
					$pdf->textCabecalho4 = date('d/m/Y');
				} else {
					$pdf->textCabecalho4 = $_SESSION['dtCriacaoRel'];
				}
			}
		
		$pdf->AliasNbPages( '{total}' );
		//$pdf->setFiles(array('arquivo.pdf', 'robson_redes.pdf', 'simulado.pdf', 'bbhive.pdf')); 
		$pdf->setFiles($arquivos); 
		$pdf->concat(); 
		 
		//$nPaginas = $pdf->page;
		
		//$pdf->pages = str_replace('@BlackbPages@#','Página ');
		 
		$pdf->Output($diretorioDestino.'relatorio_final.pdf', 'F');
		//--
?>