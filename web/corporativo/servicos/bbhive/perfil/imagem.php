<?php if(!isset($_SESSION)){ session_start(); } ?>
 <table width="142" border="0" cellspacing="0" cellpadding="0" style="margin-top:-18px;">
  <tr>
    <td height="100" align="center" valign="middle">
    	<table style="height:103px; width:79px; border:1px groove #CCCCCC; margin-top:5px">
        	<tr>
            	<td>
                	<a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&equipe=1|perfil/regra.php|includes/colunaDireita.php?equipeArquivos=1&tarefasDireita=1&fluxosDireita=1','menuEsquerda|colCentro|colDireita');"><?php
						$imagem = $_SESSION['caminhoFisico'].'/datafiles/servicos/bbhive/corporativo/perfis/'.$_SESSION['usuCod'].'/images/'.$_SESSION['usuCod'].'.jpg';
						
						
					 if(file_exists($imagem)){
					 
					 ?><img src="/datafiles/servicos/bbhive/corporativo/perfis/<?php echo $_SESSION['usuCod']; ?>/images/<?php echo $_SESSION['usuCod']; ?>.jpg?TimeStamp=<?php echo $_SERVER['REQUEST_TIME']; ?>" width="128" height="125" border="0" align="absmiddle" style="margin-top:2px;" /><?php } else { ?><img src="/corporativo/servicos/bbhive/images/icone_H.gif" border="0" align="absmiddle" style="margin-top:2px;" /><?php }  ?></a> </td>
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
<?php if($_SESSION['acesso']!=0){ ?>  
  <?php } ?>  
  <tr>
    <td height="19" class="verdana_9">
    	&nbsp;<img src="/corporativo/servicos/bbhive/images/acesso.gif" width="16" height="16" align="absmiddle">&nbsp;
        	<?php echo $_SERVER['REMOTE_ADDR']; ?>    </td>
  </tr>
</table>
 <div id="imgNovaFoto" style="display:none">&nbsp;</div>
 <span id="nomeLogadoPerfil" style="display:none"><?php echo $_SESSION['usuApelido']; ?></span>