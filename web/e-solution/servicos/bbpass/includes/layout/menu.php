<div id="bar" class="master-sprite">
    <a class="master-sprite nav-item verdana_12" href="#@" rev="/e-solution/servicos/bbpass/home.php" rel="backsite">Aplica&ccedil;&otilde;es</a>
    <a class="master-sprite nav-item verdana_12" href="#@" rev="/e-solution/servicos/bbpass/modulo/index.php" rel="backsite">M&oacute;dulos de seguran&ccedil;a</a>
    <a class="master-sprite nav-item verdana_12" href="#@" rev="/e-solution/servicos/bbpass/perfil/edita.php" rel="backsite">Trocar minha senha</a>
    <a class="master-sprite nav-item verdana_12" href="#@" rev="/e-solution/servicos/bbpass/temas/index.php" rel="backsite">Tema</a>
    <?php if($_SESSION['MM_BBpassADM_user']=="1"){ ?>
    <a class="master-sprite nav-item verdana_12" href="#@" rev="/e-solution/servicos/bbpass/usuarios/index.php" rel="backsite">Usuários BBPASS</a>
    <?php } ?>
    <a class="master-sprite nav-item verdana_12" href="<?php echo $logoutAction ?>">Sair</a>
</div>