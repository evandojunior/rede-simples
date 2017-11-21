<?php 
require_once("../includes/autenticacao/index.php");
require_once("../perfil/index.php"); 

//recupera dados do lock
require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php");
$modulo 				= new Modulo();
$modulo->dadosModulo($database_bbpass, $bbpass, $_GET['id']);

$url = "/servicos/bbpass/modulos_autenticacao/modulos/".$modulo->bbp_adm_loc_arquivo;
?>
<table width="580" border="0" align="center" cellpadding="0" cellspacing="0" class="fonteDestaque">
  <tr>
    <td height="25" align="left" bgcolor="#FFFBF4" class="legendaLabel14" style="border-bottom:1px solid #FFECC7; border-top:1px solid #FFECC7; font-weight:bold">&nbsp;<img src="/servicos/bbpass/images/modulos.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $modulo->bbp_adm_loc_nome;?>
    <input type="hidden" name="lock_liberado" id="lock_liberado" value="0" />
    <input type="hidden" name="idLockAcao" id="idLockAcao" value="<?php echo $_GET['id']; ?>" /></td>
  </tr>
  <tr>
    <td height="120" bgcolor="#FFFFFF" valign="top">
    	<label id="msgLock" class="legendaLabel12" style="position:absolute">Aguarde o carregamento.</label>
		<iframe allowtransparency="true" src="<?php echo $url; ?>?id=<?php echo $_GET['id']; ?>" name="autBBPASS" height="270" width="579" frameborder="0"></iframe>
    </td>
  </tr>
</table>