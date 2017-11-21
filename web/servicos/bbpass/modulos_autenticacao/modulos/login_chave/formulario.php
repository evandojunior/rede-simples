<form action="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/login_chave.php" method="post">
  <table width="380" border="0" cellspacing="0" cellpadding="0" class="verdana_12">
    <tr>
      <td height="25" colspan="2" align="left"><strong>Informe o Login e senha de acesso</strong></td>
    </tr>
    <tr>
      <td height="25" colspan="2" align="center" style="color:#F00"><?php if(isset($result)){ ?>Login e/ou senha inv&aacute;lidos.<?php } ?></td>
    </tr>
    <?php if(!isset($_SESSION['MM_BBpass_Chave'])) { ?>
    <tr>
      <td width="21%" height="25" align="right">Login :</td>
      <td width="79%"><label>
        &nbsp;<input name="bbp_adm_lock_log_chave" type="text" class='back_Campos' id="bbp_adm_lock_log_chave" size="31">
      </label></td>
    </tr>
    <?php } ?>
    <tr>
      <td height="25" align="right">Senha :</td>
      <td valign="baseline"><label>
        &nbsp;<input name="bbp_adm_lock_log_senha" type="password" id="bbp_adm_lock_log_senha" size="20" class='back_Campos'>
        &nbsp;
        <input name="button" type="submit" class="back_input" id="button" value="Entrar">
      </label></td>
    </tr>
    <tr>
      <td height="25" align="right"><input type="hidden" name="autenticaLoginSenha" id="autenticaLoginSenha" value="1"><input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:$idAplic; ?>"><input type="hidden" name="idLock" id="idLock" value="<?php echo isset($_POST['idLock'])?$_POST['idLock']:$idLock; ?>"></td>
      <td><label>
      &nbsp; </label></td>
    </tr>
  </table>
</form>