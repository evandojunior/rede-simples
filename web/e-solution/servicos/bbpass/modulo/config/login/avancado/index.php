<?php
 //responsável pela conexao com banco, autenticaçao, logoff
 require_once("../../../../includes/autenticacao/index.php");
 //
 $_GET['bbp_adm_loc_codigo'] = (int)$_GET['lock'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBPASS - Central de Autentica&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/bbpass.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/login.css">
<link rel="stylesheet" type="text/css" href="/e-solution/servicos/bbpass/includes/layout/menu.css">
<!-- GERAL DE TODOS OS LOCKS-->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/geral.js"></script>
<!-- FIM GERAL DE TODOS OS LOCKS-->
<!-- AJAX -->
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/ajax.js"></script>
	<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/ajax/projeto.js"></script>
<!-- AJAX-->
<!-- TRATAMENTO DE IMAGENS -->
<script type="text/javascript" src="/e-solution/servicos/bbpass/includes/javascript_backsite/historico/jquery.js"></script>
<!-- FIM TRATAMENTO DE IMAGENS -->
</head>

<body>
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:25px;">
      <tr>
        <td><?php require_once("../../../../includes/layout/cabLogin.php"); ?></td>
      </tr>
      <tr>
        <td height="25" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7; ">&nbsp;&nbsp;<img src="../../../../images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Central de autentica&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td height="490" valign="top" style="border-left:#EDDD92 solid 1px; border-bottom:#EDDD92 solid 1px;">
          
<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php"); 

//Inicia sessão caso não esteja criada
include("../gerencia_login.php");

/*============================PAGINAÇÃO + SELECT===================================*/
$page 		= "1";
$nElements 	= "100";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= 'index.php?lock='.$_GET['lock'];

//busca registros
$compPaginacao 			= " LIMIT $Inicio,$nElements";
$login 				= new Login();
						  $login->consultaLogin($database_bbpass, $bbpass, $compPaginacao);
$row_login		   		= $login->row_Log;
$totalRows_login	 	= $login->totalRows_Log;

$pages 			= ceil($login->totalLogin($database_bbpass, $bbpass)/$nElements);
/*============================PAGINAÇÃO==========================================*/

$modulo 				= new Modulo();
?>
<?php require_once("../../../../perfil/index.php"); ?>

<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6">
    <div style="float:left">
    <img src="/e-solution/servicos/bbpass/images/engrenagem.gif" width="17" height="16" align="absmiddle" />&nbsp;<strong><?php echo $modulo->nomeAplicacao($database_bbpass, $bbpass, $_GET['bbp_adm_loc_codigo']); ?></strong>
    </div>
    <div style="float:right" class="fonteDestaque">
   	  <a href="/e-solution/servicos/bbpass/index.php#2f652d736f6c7574696f6e2f7365727669636f732f6262706173732f6d6f64756c6f2f696e6465782e706870"> M&oacute;dulos de seguran&ccedil;a</a> </div>
    </td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>&nbsp;Email do usu&aacute;rio</strong></td>
            <td width="277" class="fundoTitulo legendaLabel12"><strong>Nome do usu&aacute;rio</strong></td>
            <td width="149" class="fundoTitulo  legendaLabel12"><strong>Usu&aacute;rio ativo</strong></td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11"><a href="novo.php?lock=<?php echo $_GET['bbp_adm_loc_codigo']; ?>" title="Clique para cadastrar um novo usuário"><img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Novo</a></td>
          </tr>
          <tr>
            <td height="5" colspan="7"></td>
          </tr>
     <?php if($totalRows_login>0){ 
	 		 do {	
	 	?>
          <tr>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<img src="/e-solution/servicos/bbpass/images/table.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;<?php echo $row_login['bbp_adm_lock_log_email']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<?php echo $row_login['bbp_adm_lock_log_nome']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" align="center" class="legendaLabel11"><?php 
				if($row_login['bbp_adm_lock_log_ativo']){
					echo "Sim";	
				}else{
					echo "<strong>N&atilde;o</strong>";
				}
			 ?></td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="editar.php?lock=<?php echo $_GET['bbp_adm_loc_codigo']; ?>&log_codigo=<?php echo $row_login['bbp_adm_lock_log_codigo']; ?>" title="Editar este usuário">
                	<img src="/e-solution/servicos/bbpass/images/btn_editar.gif" width="15" height="16" border="0" align="absmiddle">
                </a>
            </td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="excluir.php?lock=<?php echo $_GET['bbp_adm_loc_codigo']; ?>&log_codigo=<?php echo $row_login['bbp_adm_lock_log_codigo']; ?>" title="Excluir usuário" >
                	<img src="/e-solution/servicos/bbpass/images/btn_excluir.gif" width="14" height="16" border="0" align="absmiddle">
                </a>
            </td>
          </tr>
     <?php   } while($row_login = mysqli_fetch_assoc($login->myLog));
	 	   } else { ?>     
          <tr>
            <td height="25" colspan="7" align="center" class="legendaLabel11">N&atilde;o h&aacute; registros cadastrados</td>
          </tr>
     <?php } ?>     
          <tr>
            <td height="25" colspan="7" class="legendaLabel11"><?php include('paginacao.php'); ?></tr>
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
          
        </td>
      </tr>
</table>