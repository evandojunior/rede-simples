<table width="990" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if(isset($_SESSION['MM_BBhive_Publico']) && $_SESSION['MM_BBhive_Publico']>0){ ?>
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onClick="LoadSimultaneo('protocolos/regra.php','conteudoGeral');" title="Clique para acessar a página principal do sistema">Principal</td>
  <?php } ?>  
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onclick="return showHome('includes/completo.php','conteudoGeral', 'consulta/regra.php','colPrincipal');" title="Clique para acessar a página de utilitários">Utilit&aacute;rios</td>
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onclick="location.href='<?php echo $_SERVER['PHP_SELF']."?doLogout=true"; ?>'" title="Clique para sair do sistema">Sair</td>
    <td class="menu">&nbsp;</td>
    <td class="menu">&nbsp;</td>
    <?php if(!isset($_SESSION['MM_BBhive_Publico'])){ ?>
    <td width="100" class="menu">&nbsp;</td>
    <?php } ?>
  </tr>
</table>