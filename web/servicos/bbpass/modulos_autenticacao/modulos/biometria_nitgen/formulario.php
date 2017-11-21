<?php
$broserAtual = $_SERVER["HTTP_USER_AGENT"];
$retorno 	 = strpos($broserAtual, 'MSIE');
if($retorno !== false){
	
	//--
	if(isset($_POST['FIRTextData'])){
		//--Recupera dados do banco com o email fornecido
		//conexão com banco de dados
		$dirLock = str_replace("\\","/",dirname(__FILE__));
		$dirLock = explode("web", $dirLock);
		$caminhoLock = $dirLock[0]."web";
		$caminhoLock = $caminhoLock."/Connections/bbpass.php";
		include($caminhoLock);
		//--
		$email = $_POST['bbp_adm_lock_bio_email'];
		//--

		$query_Login = "SELECT l.bbp_adm_lock_log_codigo, b.bbp_adm_lock_bio_chave 
							FROM bbp_adm_lock_biometria as b
		inner join bbp_adm_lock_loginsenha as l on b.bbp_adm_lock_bio_email = l.bbp_adm_lock_log_email 
							WHERE bbp_adm_lock_bio_email='$email'";
        list($Login, $row_Login, $totalRows_Login) = executeQuery($bbpass, $database_bbpass, $query_Login);

			if($totalRows_Login==0){
			echo "<var style='display:none'>
				 alert('Email inválido ou inexistente na base de dados!');
				</var>";
				exit;
			}
		
		$digital 		= $_POST['FIRTextData'];
		$digitalBanco 	= $row_Login['bbp_adm_lock_bio_chave'];
		//--
		?>
		<input type="hidden" name="digital" id="digital" value="<?php echo($digital);?>">
		<input type="hidden" name="digitalBanco" id="digitalBanco" value="<?php echo($digitalBanco);?>">
		<input type="hidden" name="BiometriaNitgen" id="BiometriaNitgen" value="-1">
		<input type="hidden" name="idRemoto" id="idRemoto" value="<?php echo($row_Login['bbp_adm_lock_log_codigo']);?>" readonly>
		<var style='display:none'>
			compara('<?php echo $_SESSION['EndURL_BBPASS']; ?>');
		</var>
		<?php
		//--
		exit;
	}
	?><html>
	<!-- NBioBSP Component -->
	<OBJECT classid="CLSID:F66B9251-67CA-4d78-90A3-28C2BFAE89BF"		 
			height=0 width=0 VIEWASTEXT>
	</OBJECT>
	<link rel="stylesheet" type="text/css" href="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/autenticacao.css">
	<script type="text/javascript" src="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/javascript_backsite/ajax/ajax.js"></script>
	<script type="text/javascript" src="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/includes/javascript_backsite/ajax/projeto.js"></script>
	
	<body <?php if(isset($_SESSION['MM_Email_Padrao'])) { ?>onLoad="captura('<?php echo $_SESSION['EndURL_BBPASS']; ?>');"<?php } ?>>
	<form action='<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/biometria_nitgen.php' name="MainForm" id="MainForm" method="post" OnSubmit="javascript: captura('<?php echo $_SESSION['EndURL_BBPASS']; ?>'); return false;">
	<div class="verdana_12">
	<table width="380" border="0" cellspacing="0" cellpadding="0" class="verdana_12">
		<?php if(!isset($_SESSION['MM_Email_Padrao'])) { ?>   
		<tr>
		  <td height="25" colspan="2" align="left"><strong>Informe o E-mail para o acesso</strong></td>
		</tr>
		<tr>
		  <td height="25" align="right">&nbsp;</td>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td width="21%" height="25" align="right">E-Mail :</td>
		  <td width="79%"><label>
			&nbsp;<input name="bbp_adm_lock_bio_email" type="text" class='back_Campos' id="bbp_adm_lock_bio_email" size="31">
			<input name="cadastrar" type="submit" class="botaoAvancar back_input" id="cadastrar" value="&nbsp;Entrar" />
		  </label></td>
		</tr>
		</table>
		<input type=hidden name="FIRTextData" id="FIRTextData">
		<textarea name="id" cols="70" rows="8" id="id" style="display:none"></textarea>
		<?php } else { ?>
			<div class="verdana_12"><strong>Acesso biométrico</strong></div>
			<input name="bbp_adm_lock_bio_email" type="hidden" class="back_Campos" id="bbp_adm_lock_bio_email" readonly value="<?php echo $_SESSION['MM_Email_Padrao']; ?>"/>
			<input type=hidden name="FIRTextData" id="FIRTextData">
			<textarea name="id" cols="70" rows="8" id="id" style="display:none"></textarea>
		<?php } ?>
		
		<input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:$idAplic; ?>">
		<input type="hidden" name="idLock" id="idLock" value="<?php echo isset($_POST['idLock'])?$_POST['idLock']:$idLock; ?>">
	   <input type=hidden name="autenticaBiometriaNitgen" id="autenticaBiometriaNitgen"> 
	   <span id="mensagemBio"></span>
	   <span id="mensagem"></span>
	</div>
	</form>
	<br>
	</body>
	</html>
<?php
}else{ ?>
	<div style="font-family:Verdana, Geneva, sans-serif; font-size:12px; color:#F00" align="center"><strong>Sistema de autenticação disponível apenas para o<br>Internet Explorer</strong></div>
<?php }
?>