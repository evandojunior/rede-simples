<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
?>
<?php

	$onUsuarios   = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');";
	
	$onProtocolos = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|protocolos/index.php','menuEsquerda|colCentro');";
	
	$onMensagens  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|mensagens/index.php','menuEsquerda|colCentro');";
	
	$onStatus	  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|status/index.php','menuEsquerda|colCentro');";
	
	$onPerfis	  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');";
	
	$onDeptos	  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|departamentos/index.php','menuEsquerda|colCentro');";
	
	$onAdms		  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|administradores/index.php','menuEsquerda|colCentro');";
	
	$onWorkflow	  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/modelosFluxos/index.php','menuEsquerda|colCentro');";
	
	$onWorkflow2  = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|fluxos/tiposFluxos/tipos.php','menuEsquerda|colCentro');";
	
	$onDicionario = "showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&amp;menuEsquerda=1|dicionario/index.php','menuEsquerda|colCentro');";
	
?>
<?php if(isset($_SESSION['MM_BBhive_Codigo'])){ ?>
<var style="display:none">txtSimples('tagPerfil', 'Principal')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_9">
  <tr>
    <td height="26" colspan="5" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold">Painel administrativo</td>
  </tr>
  <tr>
    <td height="6" colspan="5"></td>
  </tr>
  <tr>
    <td style="cursor:pointer" onClick="<?php echo $onUsuarios; ?>" width="8%"><img src="/e-solution/servicos/bbhive/images/ger-usuarios.jpg" border="0" /></td>
    <td onClick="<?php echo $onUsuarios; ?>" id="r01" onmouseover="ativaCor('r01');" onmouseout="desativaCor('r01');" width="33%" valign="top"><span class="verdana_9_bold"><br />Gerenciar <?php echo $_SESSION['adm_usuariosNome']; ?></span><br />
      Crie novos usu&aacute;rios. Edite ou exclua os existentes. E vincule-os aos departamentos e perfis existentes.</td>
    <td width="6%">&nbsp;</td>
    <td width="10%" style="cursor:pointer" onclick="<?php echo $onMensagens; ?>"><img src="/e-solution/servicos/bbhive/images/ger-mensagens.jpg" alt="" border="0" /></td>
    <td width="43%" valign="top" id="r03" style="cursor:pointer" onclick="<?php echo $onMensagens; ?>" onmouseover="ativaCor('r03');" onmouseout="desativaCor('r03');"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_MsgNome']; ?></span><br />
      Tenha controle absoluto das mensagens enviadas entre os usu&aacute;rios do sistema.</td>
  </tr>
  <tr>
    <td height="7" colspan="5"></td>
  </tr>
  <tr>
    <td style="cursor:pointer" onclick="<?php echo $onWorkflow; ?>"><img src="/e-solution/servicos/bbhive/images/ger-fluxo.gif" alt="" border="0" /></td>
    <td valign="top" id="r08" style="cursor:pointer" onclick="<?php echo $onWorkflow; ?>" onmouseover="ativaCor('r08');" onmouseout="desativaCor('r08');"><br />
        <span class="verdana_9_bold">Gerenciar modelo de <?php echo $_SESSION['adm_FluxoNome']; ?></span><br />
      Crie e modifique modelos de atividades e workflows.</td>
    <td>&nbsp;</td>
    <td onClick="<?php echo $onStatus; ?>" style="cursor:pointer;"><img src="/e-solution/servicos/bbhive/images/ger-status.jpg" border="0" /></td>
    <td onClick="<?php echo $onStatus; ?>" id="r04" onmouseover="ativaCor('r04');" onmouseout="desativaCor('r04');" valign="top"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_statusNome']; ?></span><br />
      Defina quais ser&atilde;o os nomes dos status referente as atividades repassadas aos usu&aacute;rios.</td>
  </tr>
  <tr>
    <td height="7" colspan="5"></td>
  </tr>
  <tr>
    <td style="cursor:pointer" onClick="<?php echo $onPerfis; ?>"><img src="/e-solution/servicos/bbhive/images/ger-perfis.jpg" border="0" /></td>
    <td onClick="<?php echo $onPerfis; ?>" id="r05" onmouseover="ativaCor('r05');" onmouseout="desativaCor('r05');" valign="top"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_perfNome']; ?></span><br />
      Crie novos perfis, edite os existentes e atribua-os aos usu&aacute;rios existentes.</td>
    <td>&nbsp;</td>
    <td style="cursor:pointer" onClick="<?php echo $onDeptos; ?>"><img src="/e-solution/servicos/bbhive/images/ger-departamentos.jpg" border="0" /></td>
    <td id="r06" onmouseover="ativaCor('r06');" onmouseout="desativaCor('r06');" style="cursor:pointer" onClick="<?php echo $onDeptos; ?>" valign="top"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_deptoNome']; ?></span><br />
      Crie novos departamentos ou edite os existentes para atribui-los aos usu&aacute;rios do sistema.</td>
  </tr>
  <tr>
    <td height="7" colspan="5"></td>
  </tr>
  <tr>
    <td style="cursor:pointer" onClick="<?php echo $onAdms; ?>"><img src="/e-solution/servicos/bbhive/images/ger-administrador.jpg" border="0" /></td>
    <td id="r07" onmouseover="ativaCor('r07');" onmouseout="desativaCor('r07');" style="cursor:pointer" onClick="<?php echo $onAdms; ?>" valign="top"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_admNome']; ?></span><br />
      Defina novos administradores ou revogue os poderes de um.</td>
    <td>&nbsp;</td>
    <td style="cursor:pointer" onclick="<?php echo $onDicionario; ?>"><img src="/e-solution/servicos/bbhive/images/ger-dicionario.gif" alt="" border="0" /></td>
    <td valign="top" id="r09" style="cursor:pointer" onclick="<?php echo $onDicionario; ?>"  onmouseover="ativaCor('r09');" onmouseout="desativaCor('r09');"><span class="verdana_9_bold"><br />
      Gerenciar <?php echo $_SESSION['adm_dicionarioNome']; ?></span><br /><span>
      Defina os termos que ser&atilde;o apresentados aos usu&aacute;rios no sistema.</span></td>
  </tr>
  
  <tr>
    <td height="7" colspan="5"></td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
</table>
<?php }else{ echo "<span class='aviso'>Voc&ecirc; n&atilde;o tem perfil criado no ambiente Administrativo.<br />Entre em contato com um administrador.</span>"; }?>