<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 
$modulo 				= new Modulo();

$ondeJava = "http://".$_SERVER['HTTP_HOST'].str_replace("novo.php","",getCurrentPage());
$endJSPBio= $endJSPBio;//variável esta no setup.php -> connections
?>
<?php require_once("../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong>Cadastro - <?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong>
    <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/modulo/config/biometria/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar cadastro" style="float:right;margin-right:10px;margin-top:-19px;background-color:#FFF"/>
    </td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="center" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
    	<table width="386" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="legendaLabel11" align="left">Obs : Preencha todos os campos abaixo e depois coloque o dedo sobre o leitor biom&eacute;trico.</td>
          </tr>
        </table>
        
<iframe allowtransparency="true" src="/e-solution/servicos/bbpass/modulo/config/biometria/formulario.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>" name="autBBPASS" height="350" width="750" frameborder="0"></iframe>

    </td>
  </tr>
</table> 
<?php
/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.1";
	$Evento="Acessou a página de cadastro de usuários do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>