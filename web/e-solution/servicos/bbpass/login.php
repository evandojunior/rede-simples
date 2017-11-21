<?php
 //responsável pela conexao com banco, autenticaçao, logoff
 require_once("includes/autenticacao/index.php");
 
 //verifica se usuário tem sessao aberta
 if(isset($_SESSION['MM_BBpassADM_name'])){
	echo "<script>history.go(1);</script>"; 
 }
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBPASS - Central de Autentica&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="includes/layout/bbpass.css">
<link rel="stylesheet" type="text/css" href="includes/layout/login.css">
<script type="text/javascript" src="includes/javascript_backsite/login.js"></script>

<style type="text/css">
<!--
.style1 {color: #999999}
-->
</style>
</head>

<body onLoad="document.getElementById('bbp_adm_aut_usuario').focus()">
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="420" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F1F3F8" class="borderAlljanela">
      <tr>
        <td width="674" height="89" id="login_cabeca">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">&nbsp;&nbsp;<img src="images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Central de autentica&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td height="25">
        <form ACTION="<?php echo $loginFormAction; ?>" name="autentica" id="autentica" method="POST" style="display:inline">
        	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="border:#FFF solid 1px;">
          <tr>
            <td colspan="2" align="center" bgcolor="#FFFBF4" class="legendaLabel11">Acesse o <strong>BBpass</strong> com sua conta</td>
          </tr>
          <tr>
            <td height="22" colspan="2" align="center" bgcolor="#FFFBF4"><label id="cxErro" class="verdana_11" style="color:#F00;<?php if(!isset($_GET['msg'])){?>display:none<?php } ?>">Falha na autentica&ccedil;&atilde;o</label></td>
          </tr>
          <tr>
            <td width="29%" height="22" align="right" bgcolor="#FFFBF4" class="legendaLabel11">Nome de usu&aacute;rio :&nbsp;</td>
            <td width="71%" align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;
              <input type="text" name="bbp_adm_aut_usuario" id="bbp_adm_aut_usuario" size="30" value="" class='back_Campos' onKeyUp="return tecla(event,'autentica','bbp_adm_aut_usuario');"/></td>
          </tr>
          <tr>
            <td height="22" align="right" bgcolor="#FFFBF4" class="legendaLabel11">Senha :&nbsp;</td>
            <td align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;
              <input type="password" name="bbp_adm_aut_senha" id="bbp_adm_aut_senha" size="18" value="" class='back_Campos' onKeyUp="return tecla(event,'autentica','bbp_adm_aut_senha');"/></td>
          </tr>
          <tr>
            <td height="22" align="right" bgcolor="#FFFBF4" class="legendaLabel11">Seu IP :&nbsp;</td>
            <td align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;<strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong><input name="bbp_adm_aut_ip" type="hidden" id="bbp_adm_aut_ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>"></td>
          </tr>
          <tr>
            <td colspan="2" align="center" bgcolor="#FFFBF4"><table cellspacing=0 cellpadding=0 align=center  class="signup_btn" onClick="javascript: if(document.getElementById('bbp_adm_aut_usuario').value=='' || document.getElementById('bbp_adm_aut_senha').value==''){document.getElementById('cxErro').style.display='block';}else{document.autentica.submit();}">
              <tr>
                <td class="SPRITE_button_1_1"></td>
                <td class="SPRITE_button_1_2"><img src="images/clear.gif" /></td>
                <td class="SPRITE_button_1_3"></td>
              </tr>
              <tr>
                <td class="SPRITE_button_2_1"></td>
                <td width="100" class="SPRITE_button_2_2" align="center"><a class="signup_btn_link" href="#"> Entrar &#187; </a></td>
                <td class="SPRITE_button_2_3"></td>
              </tr>
              <tr>
                <td class="SPRITE_button_3_1"></td>
                <td class="SPRITE_button_3_2"><img src="images/clear.gif" /></td>
                <td class="SPRITE_button_3_3"></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="25" colspan="2" align="right" valign="bottom" bgcolor="#FFFBF4" class="legendaLabel11"><a href="/servicos/bbpass/login.php"
style="color:#F90">Acessar console operacional</a>&nbsp;</td>
          </tr>
        </table>
        </form>
        </td>
        </tr>

    </table></td>
  </tr>
</table>
</body>
</html>
