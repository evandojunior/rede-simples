<?php
 //responsável pela conexao com banco, autenticaçao, logoff
 require_once("includes/autenticacao/index.php");
 
 //verifica se usuário tem sessao aberta
 if(isset($_SESSION['MM_BBpass_name'])){
	exit("<script>history.go(1);</script>"); 
 }
 //--
 require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/modulo/gerencia_modulo.php");
 //--
 $modulo = new Modulo();
 $modulo->dadosModulo($database_bbpass, $bbpass, (int)$_SESSION['idLockLoginSenha']);
 //--
 $campos 	= array("0"=>"Nome de usu&aacute;rio");
	 if($modulo->bbp_adm_loc_arquivo=='login_chave.php'){
		 $campos[0] = "Login";
	 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>BBPASS - Central de Autentica&ccedil;&atilde;o</title>
<link rel="stylesheet" type="text/css" href="includes/layout/bbpass.css">
<link rel="stylesheet" type="text/css" href="includes/layout/login.css">
<script type="text/javascript" src="includes/javascript_backsite/login.js"></script>
</head>

<body onload="document.getElementById('email').focus()">
    <table width="777" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="margin-top:25px;">
      <tr>
        <td colspan="2"><?php require_once("includes/layout/cabLogin.php"); ?></td>
      </tr>
      <tr>
        <td height="25" colspan="2" valign="middle" bgcolor="#FFFBF4" style="font-family:arial;text-align:left;font-weight:bold;padding:5 0;border-bottom:1px solid #FFECC7;">&nbsp;&nbsp;<img src="images/key.gif" width="16" height="16" align="absmiddle" />&nbsp;&nbsp;Central de autentica&ccedil;&atilde;o</td>
      </tr>
      <tr>
        <td width="458" height="490" valign="top" style="border-left:#EDDD92 solid 1px; border-bottom:#EDDD92 solid 1px;">
            <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" style="margin-top:35px; text-align: justify;">
              <tr>
                <td><img src="images/bbpass.png" width="310" height="160" /></td>
              </tr>
              <tr>
                <td class="legendaLabel12"><br />
                Num mundo  onde seguran&ccedil;a de acesso &eacute; fundamental, que tal controlar de forma  segura e completa todas as aplica&ccedil;&otilde;es utilizando diversas tecnologias  garantindo integridade, disponibilidade e a confiabilidade dos dados.<br />
                <br />
                O  BBpass &eacute; uma ferramenta de gest&atilde;o de acesso que conta com tecnologias  diversas de autentica&ccedil;&atilde;o incluindo firewall, biometria, cart&otilde;es  magn&eacute;ticos e certificados digitais diretamente controlados pela solu&ccedil;&atilde;o  o que faz do BBPASS um portal de autentica&ccedil;&atilde;o centralizado e seguro.</td>
              </tr>
            </table>
        </td>
        <td width="319" align="center" valign="top" style="border-right:#EDDD92 solid 1px; border-bottom:#EDDD92 solid 1px;">
<form ACTION="<?php echo $loginFormAction; ?>" name="autentica" id="autentica" method="POST">
<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:#EDDD92 solid 1px; margin-top:35px;">
              <tr>
                <td height="180">

                    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="border:#FFF solid 1px;">
                      <tr>
                        <td colspan="2" align="center" bgcolor="#FFFBF4" class="legendaLabel11">Acesse o <strong>BBpass</strong> com sua conta</td>
                      </tr>
                      <tr>
                        <td colspan="2" bgcolor="#FFFBF4">&nbsp;</td>
                      </tr>
                      <tr>
                        <td width="37%" align="right" bgcolor="#FFFBF4" class="legendaLabel11"><?php echo $campos[0]; ?> :&nbsp;</td>
                        <td width="63%" align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;<input type="text" name="email" id="email" size="23" value="" class='back_Campos'/></td>
                      </tr>
                      <tr>
                        <td align="right" bgcolor="#FFFBF4" class="legendaLabel11">Senha :&nbsp;</td>
                        <td align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;<input type="password" name="senha" id="senha" size="18" value="" class='back_Campos' onkeyup="return tecla(event,'autentica','password');"/></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center" bgcolor="#FFFBF4">
                        
<table cellspacing=0 cellpadding=0 align=center  class="signup_btn" onclick="javascript: if(document.getElementById('email').value=='' || document.getElementById('senha').value==''){document.getElementById('cxErro').style.display='block';}else{document.autentica.submit();}">
<tr>
  <td class="SPRITE_button_1_1"></td>
  <td class="SPRITE_button_1_2"><img src="images/clear.gif" /></td>

  <td class="SPRITE_button_1_3"></td>
  </tr><tr>
  <td class="SPRITE_button_2_1"></td>
  <td width="100" class="SPRITE_button_2_2" align="center"><a class="signup_btn_link" href="#">
  Entrar &#187;
  </a></td>
  <td class="SPRITE_button_2_3"></td>
  </tr><tr>

  <td class="SPRITE_button_3_1"></td>
  <td class="SPRITE_button_3_2"><img src="images/clear.gif" /></td>
  <td class="SPRITE_button_3_3"></td>
  </tr>

    <tr>
        <td align="right" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;</td>
        <td align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;</td>
    </tr>
</table>
                        
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" bgcolor="#FFFBF4" class="legendaLabel11"><a href="#"
       target="_top" style="display:none">N&atilde;o consigo acessar a minha conta </a></td>
                      </tr>
                        <tr>
                            <td colspan="2" bgcolor="#FFFBF4" class="legendaLabel11"><a href="/e-solution/servicos/bbpass/login.php"
                                                                                        style="color:#F90">Acessar console administrativo</a></td>
                        </tr>
                    </table>
                    
                </td>
              </tr>
            </table>
</form>  
          
<table width="300" border="0" cellspacing="0" cellpadding="0" style="border:#EDDD92 solid 1px; margin-top:5px; <?php if(!isset($_GET['msg'])){?>display:none<?php } ?>" id="cxErro">
      <tr>
        <td height="60">
        <table width="300" height="100%" border="0" cellspacing="0" cellpadding="0" style="border:#F90 solid 1px;">
          <tr>
            <td height="20" align="center" bgcolor="#FFFBF4" class="legendaLabel11"><img src="images/exclamation.png" width="16" height="16" align="absmiddle" />&nbsp;Erro ao acessar o <strong>BBpass</strong></td>
          </tr>
          <tr>
            <td height="20" align="left" bgcolor="#FFFBF4" class="legendaLabel11"> &nbsp;Campo &quot;<strong><?php echo $campos[0]; ?></strong>&quot; inv&aacute;lido <strong>e/ou</strong></td>
          </tr>
          <tr>
            <td height="20" align="left" bgcolor="#FFFBF4" class="legendaLabel11">&nbsp;Campo &quot;<strong>Senha</strong>&quot; inv&aacute;lido</td>
          </tr>
        </table>
        </td>
     </tr>
</table>            
        </td>
      </tr>
    </table>
</body>
</html>
