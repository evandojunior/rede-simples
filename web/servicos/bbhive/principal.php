<?php if(!isset($_SESSION)){ session_start(); } 
//se o usuário já está logado redireciono para página de protocolos
if(isset($_SESSION['publLogado'])){
   //envia página de confirmação na tela
	//$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1|protocolos/regra.php','menuEsquerda|colPrincipal')";
	$carregaPagina= "showHome('includes/completo.php','conteudoGeral', 'protocolos/regra.php','colPrincipal')";
	echo '<var style="display:none">'.$carregaPagina.'</var>';
}
?>
<table width="570" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="28" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/listaIII.gif" align="absmiddle" />&nbsp;<strong>Console p&uacute;blico</strong></td>
  </tr>
  <tr>
    <td height="80" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">
        <table width="99%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#FFFFFF solid 2px;">
          <tr>
            <td height="300" valign="top" bgcolor="#F6F6F6" class="legandaLabel12">
            <div align="center" style="margin-top:15px;"><strong><?php echo $_SESSION['pub_TextoNome']; ?></strong></div>
            <div align="justify" style="margin-top:15px; margin-left:5px; margin-right:5px;"><?php echo nl2br($_SESSION['pub_TextoLeg']); ?></div>
            </td>
          </tr>
          <tr>
            <td height="1" bgcolor="#EDEDED"></td>
          </tr>
        </table>
    </td>
  </tr>
</table>