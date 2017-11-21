<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="23" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Logo da institui&ccedil;&atilde;o</strong></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="center">&nbsp;</td>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
        //lista as opções de imagens para gif
        if ($handle = opendir('../../../../datafiles/servicos/bbhive/images/logo/.')) {
             $cont  = 0;
             $dif	= 0;
             while (false !== ($file = readdir($handle))) {
             
                 if ($file != "." && $file != "..") {
                    if(strtolower($file)!="thumbs.db"){	
                       if($cont==6){
                         echo "</tr><tr><td height='7'></td></tr>
						 <tr>";
                        $cont=0;
                       }
					   
						$nmArquivo 	= strtolower($file);
						$ImagemOriginal = "../../../../datafiles/servicos/bbhive/images/logo/".$nmArquivo;
						list($width, $height) = getimagesize($ImagemOriginal);
				
                            $icone		= '<img src="/datafiles/servicos/bbhive/images/logo/'.$nmArquivo.'" border="0" align="absmiddle" />';
                            $check="";
                                if($dif==0){
                                    $check= "checked";
                                }
							
							$caminhoImagens = "/e-solution/servicos/bbhive/configuracao/imagens.php?logo=true&image=".$nmArquivo;
							echo '<td><a href="#" onClick="MM_openBrWindow(\''.$caminhoImagens.'\',\'Imagem\',\'toolbar=yes,scrollbars=yes,resizable=yes\')">'.imagem($width,$height,$ImagemOriginal,$aprox=180)."<a/></td>";
							
                            $cont++; 
                            $dif = $dif + 1;
                            //se chegar a 100 ele para
                        if ($cont == 100) { die;}	
                     }
                  }
            }
            closedir($handle);
        }
    ?>
    </table></td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td class="legandaLabel11"><?php echo $mensagem; ?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="23" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Ambiente administrativo</strong></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="center">&nbsp;</td>
    <td>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
        //lista as opções de imagens para gif
        if ($handle = opendir('../../../../datafiles/servicos/bbhive/e-solution/imagens/sistema/.')) {
             $cont  = 0;
             $dif	= 0;
             while (false !== ($file = readdir($handle))) {
             
                 if ($file != "." && $file != "..") {
                    if(strtolower($file)!="thumbs.db"){	
                       if($cont==6){
                         echo "</tr><tr><td height='7'></td></tr>
						 <tr>";
                        $cont=0;
                       }
					   
						$nmArquivo 	= strtolower($file);
						$ImagemOriginal = "../../../../datafiles/servicos/bbhive/e-solution/imagens/sistema/".$nmArquivo;
						list($width, $height) = getimagesize($ImagemOriginal);
				
                            $icone		= '<img src="/datafiles/servicos/bbhive/e-solution/imagens/sistema/'.$nmArquivo.'" border="0" align="absmiddle" />';
                            $check="";
                                if($dif==0){
                                    $check= "checked";
                                }
							
							$caminhoImagens = "/e-solution/servicos/bbhive/configuracao/imagens.php?adm=true&image=".$nmArquivo;
							echo '<td><a href="#" onClick="MM_openBrWindow(\''.$caminhoImagens.'\',\'Imagem\',\'toolbar=yes,scrollbars=yes,resizable=yes\')">'.imagem($width,$height,$ImagemOriginal,$aprox=180)."<a/></td>";
							
                            $cont++; 
                            $dif = $dif + 1;
                            //se chegar a 100 ele para
                        if ($cont == 100) { die;}	
                     }
                  }
            }
            closedir($handle);
        }
    ?>
    </table>
    
    </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td class="legandaLabel11"><?php echo $mensagem; ?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="23" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Ambiente corporativo</strong></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="center">&nbsp;</td>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
        //lista as opções de imagens para gif
        if ($handle = opendir('../../../../datafiles/servicos/bbhive/corporativo/images/sistema/.')) {
             $cont  = 0;
             $dif	= 0;
             while (false !== ($file = readdir($handle))) {
             
                 if ($file != "." && $file != "..") {
                    if(strtolower($file)!="thumbs.db"){	
                       if($cont==6){
                         echo "</tr><tr><td height='7'></td></tr>
						 <tr>";
                        $cont=0;
                       }
					   
						$nmArquivo 	= strtolower($file);
						$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/images/sistema/".$nmArquivo;
						list($width, $height) = getimagesize($ImagemOriginal);
				
                            $icone		= '<img src="/datafiles/servicos/bbhive/corporativo/imagens/sistema/'.$nmArquivo.'" border="0" align="absmiddle" />';
                            $check="";
                                if($dif==0){
                                    $check= "checked";
                                }
								
							$caminhoImagens = "/e-solution/servicos/bbhive/configuracao/imagens.php?corp=true&image=".$nmArquivo;
							echo '<td><a href="#" onClick="MM_openBrWindow(\''.$caminhoImagens.'\',\'Imagem\',\'toolbar=yes,scrollbars=yes,resizable=yes\')">'.imagem($width,$height,$ImagemOriginal,$aprox=180)."<a/></td>";
							
                            $cont++; 
                            $dif = $dif + 1;
                            //se chegar a 100 ele para
                        if ($cont == 100) { die;}	
                     }
                  }
            }
            closedir($handle);
        }
    ?>
    </table>
    </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td class="legandaLabel11"><?php echo $mensagem; ?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/e-solution/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
  <tr class="legandaLabel11">
    <td width="23" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
    <td background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Ambiente p&uacute;blico</strong></td>
  </tr>
  <tr class="legandaLabel11">
    <td height="25" align="center">&nbsp;</td>
    <td>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <?php
        //lista as opções de imagens para gif
        if ($handle = opendir('../../../../datafiles/servicos/bbhive/servicos/imagens/sistema/.')) {
             $cont  = 0;
             $dif	= 0;
             while (false !== ($file = readdir($handle))) {
             
                 if ($file != "." && $file != "..") {
                    if(strtolower($file)!="thumbs.db"){	
                       if($cont==6){
                         echo "</tr><tr><td height='7'></td></tr>
						 <tr>";
                        $cont=0;
                       }
					   
						$nmArquivo 	= strtolower($file);
						$ImagemOriginal = "../../../../datafiles/servicos/bbhive/servicos/imagens/sistema/".$nmArquivo;
						list($width, $height) = getimagesize($ImagemOriginal);
				
                            $icone		= '<img src="/datafiles/servicos/bbhive/servicos/imagens/sistema/'.$nmArquivo.'" border="0" align="absmiddle" />';
                            $check="";
                                if($dif==0){
                                    $check= "checked";
                                }
								
							$caminhoImagens = "/e-solution/servicos/bbhive/configuracao/imagens.php?publ=true&image=".$nmArquivo;
							echo '<td><a href="#" onClick="MM_openBrWindow(\''.$caminhoImagens.'\',\'Imagem\',\'toolbar=yes,scrollbars=yes,resizable=yes\')">'.imagem($width,$height,$ImagemOriginal,$aprox=180)."<a/></td>";
							
                            $cont++; 
                            $dif = $dif + 1;
                            //se chegar a 100 ele para
                        if ($cont == 100) { die;}	
                     }
                  }
            }
            closedir($handle);
        }
    ?>
    </table>
    </td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
    <td class="legandaLabel11"><?php echo $mensagem; ?></td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
</table>