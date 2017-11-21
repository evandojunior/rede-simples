<?php
	if(!isset($_SESSION)){session_start();}
if(getCurrentPage()!="/corporativo/servicos/bbhive/equipe/perfil.php"){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
}

	$query_Nomeia = "select bbh_perfil.bbh_per_codigo, bbh_per_nome from bbh_perfil
inner join bbh_usuario_nomeacao on bbh_perfil.bbh_per_codigo = bbh_usuario_nomeacao.bbh_per_codigo
   WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
		order by bbh_per_nome asc";
    list($Nomeia, $row_Nomeia, $totalRows_Nomeia) = executeQuery($bbhive, $database_bbhive, $query_Nomeia);

?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
<?php if($totalRows_Nomeia>0) { ?>
	 <?php  do { ?>
  <tr>
    <td height="5" colspan="2"></td>
  </tr>
  <tr>
    <td width="393" align="left"><a href="#@" onClick="return OpenAjaxPostCmd('/corporativo/servicos/bbhive/equipe/gerencia.php?Ts=<?php echo time(); ?>&bbh_per_codigo=<?php echo $row_Nomeia['bbh_per_codigo']; ?>&titulo=<?php echo $row_Nomeia['bbh_per_nome']; ?>','resto','&1=1','Carregando','resto','2','2');">&nbsp;<img src="/corporativo/servicos/bbhive/images/perfil.gif" width="14" height="14" align="absmiddle" border="0" />&nbsp;<strong><?php echo $row_Nomeia['bbh_per_nome']; ?></strong></a></td>
    <td width="27" align="center"><img src="/corporativo/servicos/bbhive/images/visto.gif" width="14" height="11"></td>
  </tr>
  
<?php
	$query_Profissionais = "select 
bbh_usuario.bbh_usu_codigo, bbh_usu_identificacao, bbh_usu_apelido, DATE_FORMAT(bbh_usu_data_nascimento,'%d/%m/%Y') as bbh_usu_data_nascimento, bbh_usu_sexo, bbh_usu_chefe, 
bbh_usu_tel_celular, DATE_FORMAT(bbh_usu_ultimoAcesso, '%d/%m/%Y %H:%i:%s') as bbh_usu_ultimoAcesso, bbh_dep_nome
 from bbh_usuario
      inner join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
      inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
           Where bbh_per_codigo =".$row_Nomeia['bbh_per_codigo']." and bbh_usu_chefe=".$_SESSION['usuCod']."
		   	order by bbh_usu_apelido asc";
	list($Profissionais, $row_Profissionais, $totalRows_Profissionais) = executeQuery($bbhive, $database_bbhive, $query_Profissionais);
?>
  <tr>
    <td width="393" colspan="2" align="right">
    	<div id="filho_<?php echo $row_Nomeia['bbh_per_codigo']; ?>" align="left" style="margin-left:42px;">
        <?php
		if($totalRows_Profissionais>0){
		  $HTML="";
			do{ 
			$codigo = $row_Profissionais['bbh_usu_codigo'];
					$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";
			
					if(file_exists($ImagemOriginal)){
						//A função acima não deu certo!!!
						list($width, $height) = getimagesize($ImagemOriginal);
						$Foto = imagem($width,$height,$ImagemOriginal,$aprox=51);
					} else {
						if($row_Profissionais['bbh_usu_sexo']=="1"){
							$icone = "icone_H-medio";
						} else {
							$icone = "icone_M-medio";
						} 
						$Foto = '<img src="/corporativo/servicos/bbhive/images/'.$icone.'.gif" border="0" />';
					}
					
			$Idade = determinar_idade($row_Profissionais['bbh_usu_data_nascimento']);
				if($Idade>1){ 
					$Idade = $Idade." Anos";
				} elseif($Idade==1) { 
					$Idade = $Idade." Ano"; 
				} else {
					$Idade = " ---";
				}
							
			$HTML.= $Foto;
			$HTML.= '&nbsp;<label style="position:absolute; margin-left:10px;text-align:left" class="verdana_11 color"><span class="color"><strong>'.$row_Profissionais['bbh_usu_apelido'].'</strong></span><br /><span>'.$row_Profissionais['bbh_dep_nome'].'</span><br /><span>&Uacute;ltimo acesso: '.arrumadata(substr($row_Profissionais['bbh_usu_ultimoAcesso'],0,10))." ".substr($row_Profissionais['bbh_usu_ultimoAcesso'],11,5).'</span></label><br/>';
			
			echo $HTML;
			$HTML="";
			}while($row_Profissionais = mysqli_fetch_assoc($Profissionais));
		} else {
			echo '<span class="verdana_9 color">N&atilde;o h&aacute; registros adicionado</span>';
		}
		?>
        </div>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
     <?php }while($row_Nomeia = mysqli_fetch_assoc($Nomeia)); ?>
<?php } else { ?>
<div align="center" class="verdana_11 color">N&atilde;o h&aacute; perfis adicionados para o  gerenciamento.</div>
<?php } ?>
</table>