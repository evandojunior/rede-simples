<script type="text/javascript" src="<?php echo $ondeJar; ?>assinatura.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $ondeJar; ?>/assinatura.css">
	<center>
		<label class="verdana_12">Autentica&ccedil;&atilde;o por desafio resposta na assinatura digital</label><br />
         <label class="aviso">Certifique-se que o dispositivo esteja conectado ao computador</label>
         <?php if(isset($result) && $result==0){ ?>
         <br /><br />
	         <label class="erro">E-mail n&atilde;o cadastrado no sistema, tente novamente.</label>
         <?php } ?>
		<br><form method="post" action="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/assinatura.php" name="challengeForm" onsubmit="return(generateResponse());">
        <table width="380" border="0" cellspacing="0" cellpadding="0" class="verdana_12">
        <?php if(!isset($_SESSION['MM_Email_Padrao'])) { ?>
        <tr>
          <td width="23%" height="25" align="right">E-Mail :</td>
          <td width="77%"><label>
            &nbsp;<input name="bbp_adm_lock_ass_email" type="<?php if(isset($_POST['bbp_adm_lock_ass_email'])){ echo "hidden"; }else { echo "text";}?>" class='back_Campos' id="bbp_adm_lock_ass_email" size="31" value="<?php if(isset($_POST['bbp_adm_lock_ass_email'])){ echo $_POST['bbp_adm_lock_ass_email']; }?>"><strong><?php if(isset($_POST['bbp_adm_lock_ass_email'])){ echo $_POST['bbp_adm_lock_ass_email']; } ?></strong>
          </label></td>
        </tr>
        <?php } ?>
        <tr>
          <td height="25" colspan="2" align="center">
		  <input type="hidden" name="action" value="ProcessResponse">
			<input type="hidden" name="response" value="">
			<input type="hidden" name="cert" value="">
			<input type="submit" value="Acessar" class="button" name="sign">
			<input type="button" onClick="showConfig()" value="Configurar" class="button" name="config">
            
			<input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:@$idAplic; ?>">
      		<input type="hidden" name="idLock" id="idLock" value="<?php echo @isset($_POST['idLock'])?$_POST['idLock']:@$idLock; ?>">
          </td>
          </tr>
        </table>

		</form>
	</center>
	<script>enableButtons(false);</script>
    <applet id="oApplet" code="br/com/esec/signapplet/ChallangeAuthApplet.class" archive="<?php echo $ondeJar; ?>sdk-web.jar" width="1" height="1">
        <param name="cache_version" value="1.5.1.07">
        <param name="cache_archive" value="<?php echo $ondeJar; ?>sdk-web.jar">
        <param name="sdk-base-version" value="1.5.1.07">
        <param name="remoteMessages" value="false">
        <param name="messagesURL" value="<?php echo $ondeJar; ?>sdk-web_pt_BR.properties">
        <param name="config.type" value="local">
        <param name="userid" value="sdk-web">
        <param name="challenge" value="SODMeMDADRZMjiJMFiafghq0eMU=">
        <param name="checkLibs" value="true">
    </applet>
    <script>checkAppletStarted();</script>