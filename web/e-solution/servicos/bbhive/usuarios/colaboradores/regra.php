<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

	$query_usuario = "SELECT bbh_usu_nome, bbh_usu_codigo FROM bbh_usuario WHERE bbh_usu_codigo = ".$_GET['bbh_usu_codigo'];
    list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_usuariosNome']; ?>')</var>
<var style='display:none'>OpenAjaxPostCmd('/e-solution/servicos/bbhive/usuarios/colaboradores/adicionados.php?bbh_usu_codigo=<?php echo $_GET['bbh_usu_codigo']; ?>','adicionados','&1=1','Carregando dados...','adicionados','2','2');</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td width="98%" height="26"

background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento perfis para colaboradores
    <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      
      <tr>
        <td height="24" class="legandaLabel11">Selecione abaixo os perfis que o usu&aacute;rio <strong><?php echo $row_usuario['bbh_usu_nome']; ?></strong> poder&aacute; atribuir a seus colaboradores.</td>
      </tr>
      <tr>
        <td height="24" class="legandaLabel11">&nbsp;</td>
      </tr>
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Perfis </strong></td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="590" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="20" colspan="2" valign="top">&nbsp;<div id="cadastraModelo"></div></td>
          </tr>
          
          <tr>
            <td width="293" height="24" valign="top"><table width="280" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
              <tr>
                <td height="20" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Perfis adicionados</td>
              </tr>
              <tr>
                <td height="100" valign="top" bgcolor="#FBFAF4" id="adicionados">&nbsp;</td>
              </tr>
            </table></td>
            <td width="297" valign="top" style="border-left:#CCCCCC solid 1px;"><table width="280" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
              <tr>
                <td height="20" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Perfis n&atilde;o adicionados</td>
              </tr>
              <tr>
                <td height="100" valign="top" bgcolor="#FBFAF4" id="nAdicionados">&nbsp;</td>
              </tr>
            </table></td>
          </tr>

          <tr>
            <td height="5" colspan="2"></td>
          </tr>
          <tr>
            <td height="24" colspan="2" class="legandaLabel11"><div style="float:right;">
                <input name="button" type="button" class="back_input" id="button" value="Voltar"  onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>&nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
        </table></td>
      </tr>
</table>
