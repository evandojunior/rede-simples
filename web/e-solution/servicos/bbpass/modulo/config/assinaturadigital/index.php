<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

//Inicia sessão caso não esteja criada
include("gerencia_assinatura.php");
$assinatura				= new Assinatura();
$modulo 				= new Modulo();
if(isset($_GET['exAss'])){

	$assinatura->dadosAssinatura($database_bbpass, $bbpass, $_GET['bbp_adm_lock_ass_codigo']);
	$excluido = $assinatura->bbp_adm_lock_ass_email;
/*==================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.3";
	$Evento="Excluiu o usuário ".$excluido." do módulo " . $modulo->nomeAplicacao($database_bbpass, $bbpass,$_GET['bbp_adm_loc_codigo']);
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	$assinatura->excluiDados($database_bbpass, $bbpass);
}
/*============================PAGINAÇÃO + SELECT===================================*/
$page 		= "1";
$nElements 	= "100";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbpass/modulo/config/assinaturadigital/index.php?bbp_adm_loc_codigo='.$_GET['bbp_adm_loc_codigo'];

//busca registros
$compPaginacao 			= " LIMIT $Inicio,$nElements";
						  $assinatura->consultaAssinatura($database_bbpass, $bbpass, $compPaginacao);
$row_Ass		   		= $assinatura->row_Ass;
$totalRows_Ass	 		= $assinatura->totalRows_Ass;

$pages 			= ceil($assinatura->totalAssinatura($database_bbpass, $bbpass)/$nElements);
/*============================PAGINAÇÃO==========================================*/


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
            <td width="277" class="fundoTitulo legendaLabel12"><strong>Nome do usu&aacute;rio</strong></td>
            <td width="149" class="fundoTitulo  legendaLabel12"><strong>CPF do usu&aacute;rio</strong></td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11"><a href="#" title="Clique para cadastrar um novo CPF" rev="/e-solution/servicos/bbpass/modulo/config/assinaturadigital/novo.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>" onclick="enviaURL(this);"><img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Novo</a></td>
          </tr>
          <tr>
            <td height="5" colspan="7"></td>
          </tr>
     <?php if($totalRows_Ass>0){ 
	 		 do {	
	 	?>
          <tr>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<img src="/e-solution/servicos/bbpass/images/table.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $row_Ass['bbp_adm_lock_ass_email']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<?php echo $row_Ass['bbp_adm_lock_ass_nome']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" align="left" class="legendaLabel11"><?php echo $row_Ass['bbp_adm_lock_ass_cpf']; ?></td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
   	    <a href="#" rev="/e-solution/servicos/bbpass/modulo/config/assinaturadigital/index.php?bbp_adm_loc_codigo=<?php echo $_GET['bbp_adm_loc_codigo']; ?>&bbp_adm_lock_ass_codigo=<?php echo $row_Ass['bbp_adm_lock_ass_codigo']; ?>&exAss=true" onclick="if(confirm('Tem certeza que deseja excluir este CPF?\nClique no Ok em caso de confirmação.')){enviaURL(this);}" title="Excluir dados" >
                	<img src="/e-solution/servicos/bbpass/images/btn_excluir.gif" width="14" height="16" border="0" align="absmiddle">
                </a>
            </td>
          </tr>
     <?php   } while($row_Ass = mysqli_fetch_assoc($assinatura->myAss));
	 	   } else { ?>     
          <tr>
            <td height="25" colspan="7" align="center" class="legendaLabel11">N&atilde;o h&aacute; registros cadastrados</td>
          </tr>
     <?php } ?>     
          <tr>
            <td height="25" colspan="7" class="legendaLabel11"><?php include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/paginacao/paginacao.php");?></td>
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
