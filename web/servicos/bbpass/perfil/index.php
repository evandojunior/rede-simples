<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/servicos/bbpass/includes/function.php");
require_once("gerencia_perfil.php");

	$usuario = new perfil();//instância classe
	$usuario->dadosPerfil($database_bbpass, $bbpass);//chama método responsável pela atribuição das variáveis
	
	if(isset($_GET['foto'])){ //style='display:none'
	   echo "<var style='display:none'>
		     colocaFoto(\"".$usuario->verificaImagem($database_bbpass, $bbpass)."\")
		</var>";
	 }
?><table width="580" border="0" cellspacing="0" cellpadding="0" class="fonteDestaque" align="center">
  <tr>
    <td width="388" height="22"><strong><?php echo $usuario->nomeUsuario; ?></strong> <label><?php if($usuario->nascUsuario!=""){ echo calc_idade(str_replace("/","-",arrumadata($usuario->nascUsuario))); ?> Anos<?php } ?></label></td>
    <td width="192" class="verdana_11" align="right">
    	<a href="#" rev="/servicos/bbpass/perfil/edita.php" onclick="enviaURL(this);" style="color:#F90" title="Clique para atualizar suas informa&ccedil;&otilde;es">
        	<img src="/servicos/bbpass/images/editar.gif" border="0" align="absmiddle" />
            	&nbsp;atualizar informa&ccedil;&otilde;es
        </a>
     </td>
  </tr>
  <tr>
    <td height="22"><?php echo $usuario->cargoUsuario; ?></td>
    <td width="192" class="verdana_11" style="color:#999">&Uacute;ltimo acesso: <?php echo $usuario->lastAcesso; ?></td>
  </tr>
  <tr>
    <td height="22" colspan="2"><?php echo $_SESSION['MM_BBpass_Email']; ?></td>
  </tr>
  <tr>
    <td height="2" colspan="2"></td>
  </tr>
  <tr>
    <td height="22" colspan="2" class="verdana_12"><div style="color:#03C;margin-left:15px; "><?php echo nl2br($usuario->obsUsuario); ?></div></td>
  </tr>
  <tr>
    <td height="22" colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="3" colspan="2"></td>
  </tr>
</table>
