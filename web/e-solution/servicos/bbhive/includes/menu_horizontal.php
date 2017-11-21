<table width="992" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if(isset($_SESSION['MM_BBhive_Administrativo']) && $_SESSION['MM_BBhive_Administrativo']>0){ ?>
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onClick="LoadSimultaneo('perfil/index.php?perfil=1|principal.php','menuEsquerda|conteudoGeral');" title="Clique para acessar a página principal do sistema">Principal</td>
<td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|configuracao/index.php?<?php echo $_SERVER['QUERY_STRING']; ?>','menuEsquerda|colCentro');" title="Clique para acessar a página de configurações do sistema">Configurações</td>
  <?php } ?>  
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onclick="location.href='<?php echo $_SERVER['PHP_SELF']."?doLogout=true"; ?>'" title="Clique para sair do sistema">Sair</td>
  <?php if(!isset($_SESSION['MM_BBhive_Administrativo'])){ ?>
    <td width="100" class="menu">&nbsp;</td>
    <td width="100" class="menu">&nbsp;</td>
  <?php } ?>
    <td width="56" class="menu">&nbsp;</td>
    <td width="636" class="menu" align="right" colspan="2">
		<div id="miniMenu" style="float:left"></div>
		<div class="sombra21" id="tagPerfil" style="float:right">&nbsp;</div>
    </td>
  </tr>
</table>