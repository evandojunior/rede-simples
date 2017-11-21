<?php
//conexão com banco de dados
$dirLock = str_replace("\\","/",dirname(__FILE__));
$dirLock = explode("web", $dirLock);
$rootPath = $dirLock[0]."web";
$caminhoLock = $rootPath."/Connections/bbpass.php";

require_once($caminhoLock);

// FUNÇÕES GLOBAIS
include($rootPath."/../database/config/globalFunctions.php");

if(isset($_POST['atualizaLoginSenha'])){
	$senhaAtual = md5($_POST['atual']);
	$novaSenha	= md5($_POST['nova1']);
	//--
	$query_Login = "SELECT * FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_email='".$_SESSION['MM_Email_Padrao']."' AND bbp_adm_lock_log_senha='$senhaAtual' AND bbp_adm_lock_log_ativo='1'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

		if($totalRows_Login > 0){
			//--UPDATE
		  	$updateSQL = "UPDATE bbp_adm_lock_loginsenha SET bbp_adm_lock_log_senha='".$novaSenha."' Where bbp_adm_lock_log_email='".$_SESSION['MM_Email_Padrao']."' AND bbp_adm_lock_log_codigo=".$row_Login['bbp_adm_lock_log_codigo'];
            list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
			//--
			?>
				<span style="font-family:verdana;font-size:11px;color:#0C0">Aguarde redirecionando...</span>
				<script type="text/javascript">
				  alert('Senha alterada com sucesso!!!');
				  window.top.window.location.href="/servicos/bbpass/index.php?doLogout=true";
				</script>
			<?php
			exit;
		} else {
			?>
				<span style="font-family:verdana;font-size:11px;color:#F00">Aguarde redirecionando...</span>
				<script type="text/javascript">
				  alert('Senha incorreta!');
				  location.href="login.php?id=<?php echo $_POST['codigo']; ?>";
				</script>
			<?php
			exit;
		}
	//--
	exit;	
}

function verificaAcesso($database_bbpass, $bbpass, $Email, $Senha){
	$query_Login = "SELECT * FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_email='$Email' AND bbp_adm_lock_log_senha='$Senha' AND bbp_adm_lock_log_ativo='1'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

		if($totalRows_Login>0){
			$_SESSION['MM_Email_Padrao'] = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$row_Login['bbp_adm_lock_log_email'];
    		$_SESSION['MM_BBpass_Codigo']= isset($_SESSION['MM_BBpass_Codigo'])?$_SESSION['MM_BBpass_Codigo']:$row_Login['bbp_adm_lock_log_codigo'];
		}
	return $totalRows_Login;
}

 @$idLock = isset($_GET['id'])?$_GET['id']:$idLock;
 @$idAplic;
 
 if(isset($_POST['autenticaLoginSenha'])){
 $idAplicacao= $_POST['idAplicacao'];
  $idLock	 = $_POST['idLock'];
	$Email	 = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$_POST['bbp_adm_lock_log_email'];
	$Senha	 = md5($_POST['bbp_adm_lock_log_senha']);
	$result  = verificaAcesso($database_bbpass, $bbpass, $Email, $Senha);
	$liberado= 0;
		if($result==1){
			//efetua a baixa dos locks na sessão da aplicação
			include($dirLock[0]."web/servicos/bbpass/includes/function.php");
			$_SESSION['EmailTratado'] = trataEmail($Email);

			include($dirLock[0]."web/servicos/bbpass/perfil/gerencia_perfil.php");
			$usuario = new perfil();//instância classe
			$usuario->atualizaLogon($database_bbpass, $bbpass);
			
			//monta XML de sessão para autenticação das demais aplicações
			$idLockLiberado = $idLock;
			include($dirLock[0]."web/servicos/bbpass/credencial/gerencia_credencial/libera_credencial.php");
			?>
				<span style="font-family:verdana;font-size:11px;color:#0C0">Aguarde redirecionando...</span>
				<script type="text/javascript">
				  <?php if($idAplicacao==""){ ?>
						window.top.window.limpaMsgPadrao("<?php echo $result; ?>");
						window.top.window.voltarURL("/servicos/bbpass/home.php");
				  <?php } else { ?>		
						location.href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php?idApl=<?php echo @$idAplicacao; ?>";
				 <?php } ?>		
				</script>
			<?php
			exit;
		}
 }
 
  if($_SERVER['SCRIPT_NAME']=="/servicos/bbpass/modulos_autenticacao/autenticaRemoto.php"){	
	$liberado = 0;
  }
?>
<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/autenticacao.css">
<?php  
 if(@!array_key_exists($idLock,$_SESSION['modulosLiberados'])){
	require_once("login/formulario.php"); 
 } else { 
    //redireciona para página de sucesso
 	?>
    <script type="text/javascript" src="/servicos/bbpass/includes/javascript_backsite/ajax/projeto.js"></script>
    <form id="formAlteraLoginSenha" name="formAlteraLoginSenha" method="post" action="login.php">
    	<input name="atualizaLoginSenha" type="hidden" value="true" readonly="readonly" />
    	<table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
    	  <tr>
    	    <td height="25" align="left" class="sucesso"><img src="/servicos/bbpass/images/accept.gif" width="16" height="16" align="absmiddle" />&nbsp;Parabéns, credencial liberada.</td>
  	    </tr>
    	  <tr>
    	    <td height="25" align="left" class="legendaLabel12"><a href="#@" onclick="if(document.getElementById('formAltera').style.display=='none'){ document.getElementById('formAltera').style.display='block'; document.getElementById('btnAltera').style.display='block'; } else { document.getElementById('formAltera').style.display='none'; document.getElementById('btnAltera').style.display='none'; }"><img src="/servicos/bbpass/images/editar.gif" width="16" height="16" border="0" align="absmiddle" />&nbsp;Desejo alterar minha senha.</a></td>
  	    </tr>
      </table>
        
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" style="margin-top:30px; display:none" id="formAltera">
          <tr>
            <td height="25" colspan="2" bgcolor="#EFEFEF" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;">&nbsp;&nbsp;<img src="/servicos/bbpass/images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Trocar senha</td>
        </tr>
          <tr>
            <td width="126" height="25" align="right" bgcolor="#FFFFFF" class="legendaLabel12">Senha atual :&nbsp;</td>
            <td width="421" bgcolor="#FFFFFF">&nbsp;<input name="atual" type="password" class="back_Campos" id="atual" size="30"/></td>
        </tr>
          <tr>
            <td height="25" align="right" bgcolor="#FFFFFF" class="legendaLabel12">Nova senha:&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;<input name="nova1" type="password" class="back_Campos" id="nova1" size="30"/></td>
        </tr>
          <tr>
            <td height="25" align="right" bgcolor="#FFFFFF" class="legendaLabel12">Repetir senha :&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;<input name="nova2" type="password" class="back_Campos" id="nova2" size="30"/>
            <input type="hidden" name="codigo" id="codigo" value="<?php echo $_GET['id']; ?>" readonly="readonly" /></td>
        </tr>
      </table>
      <table width="550" border="0" align="center" cellpadding="0" cellspacing="0" id="btnAltera" style="display:none">
        <tr>
          <td height="25" align="right"><input name="cadastrar" type="button" class="botaoAvancar back_input" id="cadastrar" value="Atualizar senha" onclick="javascript: if(document.getElementById('atual').value=='' || document.getElementById('nova1').value=='' || document.getElementById('nova2').value==''){ alert('Preencha todos os campos.'); } else { if((retiraEspacos(document.getElementById('nova1').value)!='' && retiraEspacos(document.getElementById('nova2').value)!='') && document.getElementById('nova1').value == document.getElementById('nova2').value){ document.formAlteraLoginSenha.submit(); } else { alert('A senha é diferente da confirmação!'); }} "/></td>
        </tr>
      </table>
    </form><?php //echo $logoutAction ?>
    <script type="text/javascript">
		window.top.window.limpaMsgPadrao("1");
	    //window.top.window.voltarURL("/servicos/bbpass/home.php");
	</script>
<?php }?>
