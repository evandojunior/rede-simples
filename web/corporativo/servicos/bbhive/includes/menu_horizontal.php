<table width="992" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <?php if(isset($_SESSION['MM_BBhive_Corporativo']) && $_SESSION['MM_BBhive_Corporativo']>0){ ?>
    <td width="100" height="30" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onClick="LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|principal.php','menuEsquerda|conteudoGeral');limpaAmbiente()" title="Clique para acessar a página principal do sistema">Principal</td>
  <?php } ?>  
    <td width="100" align="center" style="cursor:pointer" class="menu" onmouseover="javascript: this.style.backgroundPosition='0 -30px';" onmouseout="javascript: this.style.backgroundPosition='0 0px';" onclick="location.href='<?php echo getCurrentPage()."?doLogout=true"; ?>'" title="Clique para sair do sistema">Sair</td>
  <?php if(!isset($_SESSION['MM_BBhive_Corporativo'])){ ?>
    <td width="100" class="menu">&nbsp;</td>
  <?php } ?>
    <td width="56" class="menu">&nbsp;</td>
    <td width="636" class="menu" align="right" colspan="2">
		<div id="miniMenu" style="float:left"></div>
		<div class="sombra21" id="tagPerfil" style="float:right">&nbsp;</div>
    </td>
  </tr>
</table>