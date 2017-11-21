<?php
	//lista as opções de imagens para gif
	if ($handle = opendir($_SESSION['caminhoFisico'].'/datafiles/servicos/bbpass/images/sistema/modulos_on/.')) {
		$cont  = 0;
		$dif	= 0;
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if(strtolower($file)!="thumbs.db"){	
					if($cont==6){
						echo "<div style='height:10px'></div>";
						$cont=0;
					}
					$alt = explode(".",$file);
					$nmArquivo 	= strtolower($file);
					$icone		= '<img src="/datafiles/servicos/bbpass/images/sistema/modulos_on/'.$nmArquivo.'" alt="'.$alt[0].'" title="'.$alt[0].'" border="0" align="absmiddle" />';
					$check="";
					if(isset($nmIcone) && $nmIcone==$nmArquivo){
						$check= "checked";
					}
					echo '<input name="bbp_adm_loc_icone" id="bbp_adm_loc_icone'.$dif.'" type="radio" value="'.$nmArquivo.'" '.$check.'>'.$icone."&nbsp;";
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