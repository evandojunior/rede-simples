<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 

//Inicia sessão caso não esteja criada
include("gerencia_usuario.php");
$usuario 				= new usuarios();

if(isset($_GET['exUser'])){

	$usuario->dadosUsuarios($database_bbpass, $bbpass, $_GET['bbp_adm_aut_codigo']);
	$excluido = $usuario->bbp_adm_aut_usuario;
	
	/*==================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="5";
	$_SESSION['nivel']="2.5.3";
	$Evento="Excluiu o e-mail ".$excluido." do bbpass";
	EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
	$usuario->excluiDados($database_bbpass, $bbpass);
}

/*============================PAGINAÇÃO + SELECT===================================*/
$page 		= "1";
$nElements 	= "13";
	if(isset($_GET["page"])){
		$page 	= $_GET["page"];
	}
$Inicio = ($nElements*$page)-$nElements;
$homeDestino	= '/e-solution/servicos/bbpass/usuarios/index.php?1=1';

//busca registros
$compPaginacao 			= " LIMIT $Inicio,$nElements";

						  $usuario->consultaUsuarios($database_bbpass, $bbpass, $compPaginacao);
$row_usuario   			= $usuario->row_User;
$totalRows_usuario 		= $usuario->totalRows_User;

$pages 					= ceil($usuario->totalUsuarios($database_bbpass, $bbpass)/$nElements);
/*============================PAGINAÇÃO==========================================*/
?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Gerenciamento de usu&aacute;rios BBPASS</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>E-mail</strong></td>
            <td width="277" class="fundoTitulo legendaLabel12"><strong>IP de acesso</strong></td>
            <td width="149" class="fundoTitulo  legendaLabel12"><strong>Usu&aacute;rio Adm</strong></td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11"><a href="#" rev="/e-solution/servicos/bbpass/usuarios/novo.php" onclick="enviaURL(this);" title="Clique para cadastrar um usuário BBPASS"><img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Novo</a></td>
          </tr>
          <tr>
            <td height="5" colspan="7"></td>
          </tr>
  <?php if($totalRows_usuario>0){ 
  		 do {
  			?>       
          <tr>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<img src="/e-solution/servicos/bbpass/images/lista.gif" width="16" height="16" border="0" align="absbottom">&nbsp;<?php echo $apl =  $row_usuario['bbp_adm_aut_usuario']; ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" class="legendaLabel11">&nbsp;<?php 
			if($row_usuario['bbp_adm_aut_ip']=="0.0.0.0"){
				echo "Todos os ip's";
			} else {
				echo $row_usuario['bbp_adm_aut_ip'];
			}
			 ?></td>
            <td height="25" style="border-bottom:#EEEEEE solid 1px;" align="center" class="legendaLabel11"><?php 
				if($row_usuario['bbp_adm_user']){
					echo "Sim";	
				}else{
					echo "<strong>N&atilde;o</strong>";
				}
			 ?></td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">&nbsp;</td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            	<a href="#" rev="/e-solution/servicos/bbpass/usuarios/edita.php?bbp_adm_aut_codigo=<?php echo $row_usuario['bbp_adm_aut_codigo']; ?>" onclick="enviaURL(this);" title="Editar usuário">
                	<img src="/e-solution/servicos/bbpass/images/btn_editar.gif" width="15" height="16" border="0" align="absmiddle">
                </a>
            </td>
            <td width="22" height="25" align="center" style="border-bottom:#EEEEEE solid 1px;">
            <?php if($totalRows_usuario>1){ ?>
            	<a href="#" rev="/e-solution/servicos/bbpass/usuarios/index.php?bbp_adm_aut_codigo=<?php echo $row_usuario['bbp_adm_aut_codigo']; ?>&exUser=true" onclick="if(confirm('Tem certeza que deseja excluir este E-mail?\nClique no Ok em caso de confirmação.')){enviaURL(this);}" title="Excluir usuário" >
                	<img src="/e-solution/servicos/bbpass/images/btn_excluir.gif" width="14" height="16" border="0" align="absmiddle">
                </a>
             <?php } else { echo "&nbsp;"; } ?>   
            </td>
          </tr>
     <?php } while($row_usuario = mysqli_fetch_assoc($usuario->myUser));
	 	  } else { ?>     
          <tr>
            <td height="25" colspan="7" align="center" class="legendaLabel11">N&atilde;o &aacute; registros cadastrados</td>
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
$_SESSION['nivel']="1";
$Evento="Acessou a página de gerenciamento de aplicações.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>