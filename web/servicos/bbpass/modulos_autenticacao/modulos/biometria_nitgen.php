<?php if(!isset($_SESSION)){session_start();}
//conexão com banco de dados
$dirLock = str_replace("\\","/",dirname(__FILE__));
$dirLock = explode("web", $dirLock);
$rootPath = $dirLock[0]."web";
$caminhoLock = $rootPath."/Connections/bbpass.php";
 require_once($caminhoLock);

// FUNÇÕES GLOBAIS
include($rootPath."/../database/config/globalFunctions.php");

function verificaAcesso($database_bbpass, $bbpass, $Email, $Senha){
	$query_Login = "SELECT * FROM bbp_adm_lock_biometria WHERE bbp_adm_lock_bio_email='$Email' AND bbp_adm_lock_bio_chave='$Senha'";
    list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

		if($totalRows_Login>0){
			$_SESSION['MM_Email_Padrao'] = isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$row_Login['bbp_adm_lock_bio_email'];
    		$_SESSION['MM_BBpass_Codigo']= isset($_SESSION['MM_BBpass_Codigo'])?$_SESSION['MM_BBpass_Codigo']:$row_Login['bbp_adm_lock_bio_codigo'];
		}
	return $totalRows_Login;
}

 @$idLock = isset($_GET['id'])?$_GET['id']:$idLock;
 @$idAplic;
 
 if(isset($_POST['BiometriaNitgen'])){
 	$idAplicacao= $_POST['idAplicacao'];
  	$idLock	 	= $_POST['idLock'];
	$Email	 	= isset($_SESSION['MM_Email_Padrao'])?$_SESSION['MM_Email_Padrao']:$_POST['bbp_adm_lock_bio_email'];
	$_SESSION['MM_Email_Padrao'] = $Email;
	$_SESSION['MM_BBpass_Codigo']= $_POST['idRemoto'];

	$result  = 1;
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
<?php
 if(@!array_key_exists($idLock,$_SESSION['modulosLiberados'])){
	require_once("biometria_nitgen/formulario.php");
 } else { 
    //redireciona para página de sucesso
 	?>
    	<table width="550" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:12px;">
    	  <tr>
    	    <td height="25" align="left" class="sucesso"><img src="/servicos/bbpass/images/accept.gif" width="16" height="16" align="absmiddle" />&nbsp;Parabéns, credencial liberada.</td>
  	    </tr>
   	  </table>
	<?php echo $logoutAction ?>
    <script type="text/javascript">
		window.top.window.limpaMsgPadrao("1");
	    //window.top.window.voltarURL("/servicos/bbpass/home.php");
	</script>
<?php }?>