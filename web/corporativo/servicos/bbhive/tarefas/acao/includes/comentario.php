<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once('functionsAtividades.php');


if(isset($_GET['addComent'])){
	$comentario = $_POST['comentario_'.$_GET['bbh_ati_codigo']];
	atualizaXML($_GET['bbh_ati_codigo'], $comentario);
}

if(isset($_GET['viewComent'])){ ?>
<table width="350" align="center" border="0" cellspacing="0" cellpadding="0" style="border:#000000 solid 1px; position:absolute">
	<tr>
        <td height="17" colspan="3" background="/corporativo/servicos/bbhive/images/back_cabeca_label.gif" style="color:#FFFFFF">&nbsp;<strong>Recados</strong> : <?php echo $_GET['title']; ?>
        <label style="float:right; margin-top:-13px; margin-right:5px;">
         <a href="#" onclick="javascript: document.getElementById('load_<?php echo $_GET['bbh_ati_codigo']; ?>').innerHTML=''">
        	<img src="/corporativo/servicos/bbhive/images/closeII.gif" border="0" />         </a>        </label>    </td>
  	</tr>
		<?php echo leXMLRecados($_GET['bbh_ati_codigo']); ?>
    <tr>
        <td height="3" colspan="3" valign="top" bgcolor="#FFFFFF"></td>
    </tr>
</table>
<?php } ?>