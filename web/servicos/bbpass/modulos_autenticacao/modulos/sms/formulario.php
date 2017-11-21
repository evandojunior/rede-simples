<form action="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/sms.php" method="post" name="sms" id="sms">
    <table width="380" border="0" cellspacing="0" cellpadding="0" class="verdana_12">
        <tr>
          <td height="25" colspan="2" align="left"><strong>Autentica&ccedil;&atilde;o via SMS</strong></td>
        </tr>
        <tr>
          <td height="25" colspan="2" align="center" style="color:#F00"><?php if(isset($erro)){ ?><span style="color:#C33">E-Mail n&atilde;o encontrado.<?php } ?><?php if(isset($enviado)){ ?><span style="color:#00F">Chave gerada e enviada para o celular cadastrado.</span><?php } ?></span></td>
        </tr>
        <?php if(!isset($_SESSION['MM_Email_Padrao'])) { ?>
        <tr>
          <td width="23%" height="25" align="right">E-Mail :</td>
          <td width="77%"><label>
            &nbsp;<input name="bbp_adm_lock_sms_email" type="<?php if(isset($_POST['bbp_adm_lock_sms_email'])){ echo "hidden"; }else { echo "text";}?>" class='back_Campos' id="bbp_adm_lock_sms_email" size="31" value="<?php if(isset($_POST['bbp_adm_lock_sms_email'])){ echo $_POST['bbp_adm_lock_sms_email']; }?>"><strong><?php if(isset($_POST['bbp_adm_lock_sms_email'])){ echo $_POST['bbp_adm_lock_sms_email']; } ?></strong>
          </label></td>
        </tr>
        <?php } ?>
        <tr>
          <td width="23%" height="25" align="right">Chave SMS :</td>
          <td width="77%"><label>
            &nbsp;<input name="bbp_adm_lock_sms_chave" type="text" class='back_Campos' id="bbp_adm_lock_sms_chave" size="20">
          </label></td>
        </tr>
        <tr>
          <td height="25" align="right">&nbsp;</td>
          <td>
          <input name="button" type="submit" class="back_input" id="button" value="N&atilde;o possuo chave">
          <input name="button" type="submit" class="back_input" id="button" value="Entrar" /></td>
        </tr>
      </table>
  <input type="hidden" name="ipCliente" id="ipCliente" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
	<input type="hidden" name="autenticaSMS" id="autenticaSMS" value="1">
			<input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:@$idAplic; ?>">
      		<input type="hidden" name="idLock" id="idLock" value="<?php echo @isset($_POST['idLock'])?$_POST['idLock']:@$idLock; ?>">
</form>