<form action="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/firewall.php" method="post" name="firewall" id="firewall">
    <table width="380" border="0" cellspacing="0" cellpadding="0" class="verdana_12">
        <tr>
          <td width="100%" height="25" colspan="2" align="left"><strong>Aguarde o acesso</strong></td>
        </tr>
        <tr>
          <td height="25" colspan="2" align="center" style="color:#F00"><?php if(isset($result)){ ?><a href="#" onclick="javascript: document.firewall.submit();" class="verdana_12"><span style="color:#C33">Erro ao efetuar login, tentar novamente.</span></a><?php } ?></td>
        </tr>
        <?php if(!isset($_SESSION['MM_Email_Padrao'])) { ?>
        <?php } ?>
      </table>
	<input type="hidden" name="ipCliente" id="ipCliente" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>" />
	<input type="hidden" name="autenticaFirewall" id="autenticaFirewall" value="1">
      <input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:@$idAplic; ?>">
      <input type="hidden" name="idLock" id="idLock" value="<?php echo @isset($_POST['idLock'])?$_POST['idLock']:@$idLock; ?>">
</form>
<?php if(!isset($result)){ ?>
<span style="font-family:verdana;font-size:11px;color:#099">Aguarde redirecionando...</span>
    <script type="text/javascript">
        document.firewall.submit();
    </script>
<?php } ?>