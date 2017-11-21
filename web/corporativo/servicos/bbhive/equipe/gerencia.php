<?php  if(!isset($_SESSION)){session_start();}
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
?>
<table width="418" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_9" style="position:absolute; margin-left:2px; margin-top:40px;" bgcolor="#FFFFFF" id="tbPerfil">
  <tr>
    <td height="30" colspan="2" background="/corporativo/servicos/bbhive/images/cabecaPerfil.gif">
    <div class="verdana16 color" style="margin-left:180px; margin-top:-3px; position:absolute"><strong><?php echo $_GET['titulo']; ?></strong></div>
    <label style="margin-left:290px; position:absolute" id="loadPerfil"></label>
    <div style="float:right; margin-right:5px;">
    	<a href="#@" onClick="javacript: document.getElementById('tbPerfil').style.display='none'" style=" width:30px; height:35px;" title="Clique para fechar esta janela">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </a></div>
    </td>
  </tr>
  <tr>
    <td width="214" height="200" align="center" valign="top" id="esquerda" style="border-left:#D8DCDF solid 1px">
	  <?php require_once('adicionados.php'); ?>
    </td>
    <td width="204" align="center" valign="top" id="direita" style="border-right:#D8DCDF solid 1px">
	  <?php require_once('profissionais.php'); ?>
    </td>
  </tr>
  <tr>
    <td height="8" colspan="2" background="/corporativo/servicos/bbhive/images/rodapePerfil.gif"></td>
  </tr>
</table>