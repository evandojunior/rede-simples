<?php

	class GeraGraficoPizza{
			function __construct($dados,$valores,$exibir_legenda){
			//include 'classes/config_grafico.php';
			$diretorio = dirname(__FILE__);
			include ($diretorio.'/config_grafico.php');
			
			// ------ definição dos dados ----------
			$cores 		= array();

			// cria imagem e define as cores
			$imagem = ImageCreate($largura, $altura);
			$fundo 	= ImageColorAllocate($imagem, 255, 255, 255);
			$preto 	= ImageColorAllocate($imagem, 0, 0, 0);
			
			// linhas representam os valores, colunas representam os intervalos
			// obs: NÃO USE VALORES NEGATIVOS!
			$numero_linhas 	= sizeof($dados);

			for($x = 0; $x < $numero_linhas; $x++){
				$primeiro 	= rand(0,255);
				$segundo 	= rand(0,255);
				$terceiro 	= rand(0,255);
				
				$cadaCor 	= ImageColorAllocate($imagem, $primeiro, $segundo, $terceiro);
				$cor[$x] 	= $cadaCor;
				
				//cores das colunas
				array_push($cores,$cadaCor);
			}

			// ------ cálculo do total ----------
			$total = 0;
			$num_linhas = sizeof($dados);

			for($i=0 ; $i<$num_linhas; $i++)
				$total += $valores[$i];
			
				// ------ desenha o gráfico ----------
				ImageEllipse($imagem, $centrox, $centroy, $diametro, $diametro, $preto);
				ImageString($imagem, 3, 3, 3, "Total: $total registros", $preto);
				
				$raio = $diametro/2;
				
					for($i=0 ; $i<$num_linhas; $i++){
						$percentual = ($valores[$i] / $total) * 100;
						$percentual = number_format($percentual, 2);
						$percentual .= "%";
						
						$val = 360 * ($valores[$i] / $total);
						$angulo += $val;
						$angulo_meio = $angulo - ($val / 2);
						
						$x_final = $centrox + $raio * cos(deg2rad($angulo));
						$y_final = $centroy + (- $raio * sin(deg2rad($angulo)));
					
						$x_meio = $centrox + ($raio/2 * cos(deg2rad($angulo_meio))) ;
						$y_meio = $centroy + (- $raio/2 * sin(deg2rad($angulo_meio)));
					
						$x_texto = $centrox + ($raio * cos(deg2rad($angulo_meio))) * 1.2;
						$y_texto = $centroy + (- $raio * sin(deg2rad($angulo_meio))) * 1.2;
					
						ImageLine($imagem, $centrox, $centroy, $x_final, $y_final, $preto);
						ImageFillToBorder($imagem, $x_meio, $y_meio, $preto, $cores[$i]);
						ImageString($imagem, 2, $x_texto, $y_texto, $percentual, $preto);
					}
					
					// ------ CRIAÇÃO DA LEGENDA ----------
					if($exibir_legenda=="sim"){
						// acha a maior string
						$maior_tamanho = 0;
						for($i=0 ; $i<$num_linhas; $i++)
							if(strlen($dados[$i])>$maior_tamanho)
								$maior_tamanho = strlen($dados[$i]);
					
						// calcula os pontos de início e fim do quadrado
						$x_inicio_legenda = $lx - $largura_fonte * ($maior_tamanho+4);
						$y_inicio_legenda = $ly;
					
						$x_fim_legenda = $lx;
						$y_fim_legenda = $ly + $num_linhas * ($altura_fonte + $espaco_entre_linhas) + 2*$margem_vertical;
						ImageRectangle($imagem,	$x_inicio_legenda, $y_inicio_legenda,$x_fim_legenda, $y_fim_legenda, $preto);
					
						// começa a desenhar os dados
						for($i=0 ; $i<$num_linhas; $i++){
							$x_pos = $x_inicio_legenda + $largura_fonte*3;
							$y_pos = $y_inicio_legenda + $i * ($altura_fonte + $espaco_entre_linhas) + $margem_vertical;
					
							ImageString($imagem, $fonte, $x_pos, $y_pos, $dados[$i], $preto);
							ImageFilledRectangle ($imagem, $x_pos-2*$largura_fonte, $y_pos, $x_pos-$largura_fonte, $y_pos+$altura_fonte, $cores[$i]);
							ImageRectangle ($imagem, $x_pos-2*$largura_fonte, $y_pos, $x_pos-$largura_fonte, $y_pos+$altura_fonte, $preto);
						}
					}
					// ------ FIM CRIAÇÃO DA LEGENDA ----------
			//------------------------------------------------------------------------------
			
		 ImagePng($imagem);
		 ImageDestroy($imagem);
		}
	}
?>