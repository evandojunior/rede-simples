<?php require_once('../../../../Connections/bbhive.php'); ?>
<?php

$query_usuario = "SELECT bbh_adm_sexo FROM bbh_administrativo";
list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);

 if(!isset($_SESSION)){ session_start(); }

?>
 <table width="142" border="0" cellspacing="0" cellpadding="0" style="margin-top:-18px;">
  <tr>
    <td height="25" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11 color"><strong><span id="nomeLogadoPerfil"><?php echo $_SESSION['es_usuNome']; ?></span></strong></td>
  </tr>
  <tr>
    <td height="100" align="center" valign="middle">
    	<table style="height:103px; width:79px; border:1px groove #CCCCCC; margin-top:5px">
        	<tr>
            	<td>
                	<a href="#" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/editar.php?bbh_adm_codigo=<?php echo $_SESSION['es_usuCod']; ?>','menuEsquerda|colCentro');"><?php
					
					//novo caminho para buscar a imagem do perfil	
						$imagem = $_SESSION['caminhoFisico'].'/datafiles/servicos/bbhive/e-solution/perfis/'.$_SESSION['es_usuCod'].'/images/'.$_SESSION['es_usuCod'].'.jpg';
						
					 if(file_exists($imagem)){
					 
					 ?><img src="/datafiles/servicos/bbhive/e-solution/perfis/<?php echo $_SESSION['es_usuCod']; ?>/images/<?php echo $_SESSION['es_usuCod']; ?>.jpg?TimeStamp=<?php echo $_SERVER['REQUEST_TIME']; ?>" width="128" height="125" border="0" align="absmiddle" style="margin-top:2px;" /><?php } else { 
					 
					 //de acordo com o sexo
					 if($row_usuario['bbh_adm_sexo'] == 1){
					 ?>
                     	<img src="/e-solution/servicos/bbhive/images/icone_M.gif" border="0" align="absmiddle" style="margin-top:2px;" />
				    <?php
					} else {
					?>
                     	<img src="/e-solution/servicos/bbhive/images/icone_H.gif" border="0" align="absmiddle" style="margin-top:2px;" />
					<?php
					}
					}  ?>
              </a> </td>
          </tr>
        </table>
    
		</td>
  </tr>
  
  <tr>
    <td height="1"></td>
  </tr>
  <tr>
    <td height="8"></td>
  </tr>
<?php if($_SESSION['es_acesso']!=0){ ?>  
  <tr>
    <td height="19" class="verdana_9">
    	&nbsp;<img src="/e-solution/servicos/bbhive/images/editar.gif" width="17" height="17" align="absmiddle">&nbsp;
        	<a href="#" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|administradores/editar.php?bbh_adm_codigo=<?php echo $_SESSION['es_usuCod']; ?>','menuEsquerda|colCentro');">Editar dados</a></td>
  </tr>
<?php } ?>  
  <tr>
    <td height="19" class="verdana_9">
    	&nbsp;<img src="/e-solution/servicos/bbhive/images/acesso.gif" width="16" height="16" align="absmiddle">&nbsp;
        	<?php echo $_SERVER['REMOTE_ADDR']; ?>    </td>
  </tr>

</table>
 <?php
mysqli_free_result($usuario);
?>
