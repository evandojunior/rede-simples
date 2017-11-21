<?php 

$query_equipe = "SELECT  bbh_mensagens.bbh_usu_codigo_remet as remetente, bbh_mensagens.bbh_usu_codigo_destin as destinatario, bbh_usuario.bbh_usu_codigo, bbh_usuario.bbh_usu_apelido, bbh_mensagens.bbh_men_data_recebida, bbh_usuario.bbh_usu_identificacao FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_mensagens.bbh_usu_codigo_destin = bbh_usuario.bbh_usu_codigo WHERE bbh_mensagens.bbh_usu_codigo_remet = ".$_SESSION['usuCod']." GROUP BY bbh_usu_codigo UNION SELECT  bbh_mensagens.bbh_usu_codigo_remet as remetente, bbh_mensagens.bbh_usu_codigo_destin as destinatario, bbh_usuario.bbh_usu_codigo, bbh_usuario.bbh_usu_apelido, bbh_mensagens.bbh_men_data_recebida, bbh_usuario.bbh_usu_identificacao FROM bbh_mensagens INNER JOIN bbh_usuario ON bbh_mensagens.bbh_usu_codigo_remet = bbh_usuario.bbh_usu_codigo WHERE bbh_mensagens.bbh_usu_codigo_destin = ".$_SESSION['usuCod']." GROUP BY bbh_usu_codigo ORDER BY bbh_men_data_recebida DESC";
list($equipe, $row_equipe, $totalRows_equipe) = executeQuery($bbhive, $database_bbhive, $query_equipe);
?><link rel="stylesheet" href="../includes/bbhive.css" />
<table width="158" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-left:15px;">
  <tr>
    <td height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;&nbsp;<strong>Equipe</strong></td>
  </tr>
  <tr>
    <td style="border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;">&nbsp;</td>
  </tr>
  <tr><?php if($totalRows_equipe==0){ echo "<td align='center' style='border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;' class='verdana_9'>N&atilde;o houve correspond&ecirc;ncias.</td>"; } else { ?>
    <td height="50" align="left" style="border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;">&nbsp;<?php
   
    $Verificador = Array();
    $contador = 0;
	
	do {
	 if(in_array($row_equipe['bbh_usu_codigo'],$Verificador)){
	 echo "";
	 } else {	
		if($contador==3){
			echo "</td> 
				  <tr>
					<td align='left' style='border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;'>&nbsp;";
			$contador=0;
                }
				
				
	?>
    <a href="#" title="<?php echo $row_equipe['bbh_usu_apelido']; ?>" >
    	<?php 
		$IdUsuario = $row_equipe['bbh_usu_codigo'];
			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$IdUsuario."/images/".$IdUsuario.".jpg";

			if(file_exists($ImagemOriginal)){
				//A função acima não deu certo!!!
				list($width, $height) = getimagesize($ImagemOriginal);
				echo imagem($width,$height,$ImagemOriginal,$aprox=51);
			} else {
				echo '<img src="/corporativo/servicos/bbhive/images/icone_H-pequeno.gif" border="0" />';
			}
		?>
    </a><?php
	
	 $contador = $contador + 1;
	 array_push($Verificador,$row_equipe['bbh_usu_codigo']); 		
			}
	 } while ($row_equipe = mysqli_fetch_assoc($equipe));
	 
	 ?></td>
     <?php } ?>
  </tr>
  <tr>
    <td style="border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;">&nbsp;</td>
  </tr>
  <tr>
    <td style="border-left:1px solid #EBEBDA; border-right:1px solid #EBEBDA;">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="verdana_9" style="border-left:1px solid #EBEBDA; border-bottom:1px solid #F4F4F4; border-right:1px solid #EBEBDA;">Veja toda sua equipe&nbsp;</td>
  </tr>
</table>
<br />
<?php
mysqli_free_result($equipe);
?>