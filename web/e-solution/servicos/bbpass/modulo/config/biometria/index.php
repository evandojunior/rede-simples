<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

//Inicia sessão caso não esteja criada
include("gerencia_biometria.php");
$biometria 				= new Biometria();
if(isset($_GET['exBio'])){
	$biometria->bbp_adm_lock_bio_codigo	= $_GET['bbp_adm_lock_bio_codigo'];
	$biometria->excluiDados($database_bbpass, $bbpass);
}

/*============================PAGINAÇÃO + SELECT===================================*/
$page 		= "1";
$nElements 	= "100";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbpass/modulo/config/biometria/index.php?bbp_adm_loc_codigo='.$_GET['bbp_adm_loc_codigo'];

//busca registros
$compPaginacao 			= " LIMIT $Inicio,$nElements";

						  $biometria->consultaBiometria($database_bbpass, $bbpass, $compPaginacao);
$row_biometria		   	= $biometria->row_Bio;
$totalRows_biometria 	= $biometria->totalRows_Bio;

$pages 			= ceil($biometria->totalBiometria($database_bbpass, $bbpass)/$nElements);
/*============================PAGINAÇÃO==========================================*/

$modulo 				= new Modulo();
?>
<?php require_once("../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong><?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>&nbsp;Email do usu&aacute;rio</strong></td>
            <td width="423" class="fundoTitulo legendaLabel12"><strong>Nome do usu&aacute;rio</strong></td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11"><a href="#" title="Clique para cadastrar um novo IP" rev="/e-solution/servicos/bbpass/modulo/config/biometria/novo.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>" onclick="enviaURL(this);"><img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Novo</a></td>
          </tr>
          <tr>
            <td height="5" colspan="6"></td>
          </tr>
     <?php if($totalRows_biometria>0){ 
	 		 do {	
	 	?>
          <tr>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<img src="/e-solution/servicos/bbpass/images/table.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $row_biometria['bbp_adm_lock_bio_email']; ?></td>
            <td height="25" class="legendaLabel11" style="border-bottom:#EEEEEE solid 1px;">&nbsp;<?php echo $row_biometria['bbp_adm_lock_bio_nome']; ?></td>
            <td width="17" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="#" rev="/e-solution/servicos/bbpass/modulo/config/biometria/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>&bbp_adm_lock_bio_codigo=<?php echo $row_biometria['bbp_adm_lock_bio_codigo']; ?>&exBio=true" onclick="if(confirm('Tem certeza que deseja excluir este Registro?\nClique no Ok em caso de confirmação.')){enviaURL(this);}" title="Excluir este IP" >
                	<img src="/e-solution/servicos/bbpass/images/btn_excluir.gif" width="14" height="16" border="0" align="absmiddle">
                </a>
            </td>
          </tr>
     <?php   } while($row_biometria = mysqli_fetch_assoc($biometria->myBio));
	 	   } else { ?>     
          <tr>
            <td height="25" colspan="6" align="center" class="legendaLabel11">N&atilde;o h&aacute; registros cadastrados</td>
          </tr>
     <?php } ?>     
          <tr>
            <td height="25" colspan="6" class="legendaLabel11"><?php include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/paginacao/paginacao.php");?></td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<?php 

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="2.5";
$Evento="Acessou a página de gerenciamento de usuários do módulo ".$modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']).".";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>