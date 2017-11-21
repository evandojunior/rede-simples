<?php
	//lista as opções de imagens para gif
	if ($handle = opendir($_SESSION['caminhoFisico'].'/corporativo/servicos/bbhive/images/painel/icones/.')) {
		$cont  = 0;
		$dif	= 0;
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(strtolower($file)!="thumbs.db"){	
					if($cont==3){
						echo "<div style='height:20px'></div>";
						$cont=0;
					}
					$alt = explode(".",$file);
					$nmArquivo 	= strtolower($file);
					$icone		= '<img src="/corporativo/servicos/bbhive/images/painel/icones/'.$nmArquivo.'" alt="'.$alt[0].'" title="'.$alt[0].'" border="0" align="absmiddle"/>';
					$check="";
					if(isset($nmIcone) && $nmIcone==$nmArquivo){
						$check= "checked";
					}
					echo '<input name="bbh_par_tipo_anexo" id="bbh_par_tipo_anexo'.$dif.'" type="radio" value="'.$nmArquivo.'" '.$check.' onclick="document.getElementById(\'bbh_tipo\').value=this.value">'.$icone."&nbsp;<span style='margin-right:18px;'>".strtoupper($alt[0])."</span>";
					$cont++; 
					$dif = $dif + 1;
					//se chegar a 100 ele para
					if ($cont == 250) { die;}	
				}
			}
		}
		closedir($handle);
	}
?>