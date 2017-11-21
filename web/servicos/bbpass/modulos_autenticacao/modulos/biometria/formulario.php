<script type="text/javascript">function acaoForm(vrEmail, vrChave){document.getElementById('bbp_adm_lock_bio_email').value = vrEmail;		document.getElementById('bbp_adm_lock_bio_chave').value = vrChave;document.biometria.submit();}</script>
  <form action="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/biometria.php" id="biometria" name="biometria" method="post">
  <input name="ondeJar" type="hidden" id="ondeJar" value="<?php echo $ondeJar; ?>">

  <?php require_once($_SESSION['caminhoFisico'].'/servicos/bbpass/modulos_autenticacao/modulos/biometria/index.php'); ?>
  <input name="acaoBiometria" type="hidden" id="acaoBiometria" value="<?php echo $_SESSION['EndURL_BBPASS']; ?>/servicos/bbpass/modulos_autenticacao/modulos/biometria.php">
  <input name="bbp_adm_lock_bio_email" type="hidden" id="bbp_adm_lock_bio_email" value="">
  <input name="bbp_adm_lock_bio_chave" type="hidden" id="bbp_adm_lock_bio_chave" value="">
    <input type="hidden" name="idAplicacao" id="idAplicacao" value="<?php echo isset($_POST['idAplicacao'])?$_POST['idAplicacao']:@$idAplic; ?>">
    <input type="hidden" name="idLock" id="idLock" value="<?php echo @isset($_POST['idLock'])?$_POST['idLock']:@$idLock; ?>">
</form>