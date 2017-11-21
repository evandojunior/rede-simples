<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


$codUsu = -1;
if(isset($_GET['bbh_usu_codigo'])){
	$codUsu = $_GET['bbh_usu_codigo'];
}

	$query_usuario = "SELECT bbh_usu_nome, bbh_usu_codigo FROM bbh_usuario WHERE bbh_usu_codigo = $codUsu";
    list($usuario, $row_usuario, $totalRows_usuario) = executeQuery($bbhive, $database_bbhive, $query_usuario);
?>
<var style="display:none">carregaAdicionados();</var>
<var style="display:none">carregaDisponiveis('on');</var>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['adm_usuariosNome']; ?>')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-usuarios-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_usuariosNome']; ?>
    <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&menuEsquerda=1|usuarios/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Atribui&ccedil;&atilde;o de perfis para <span class="verdana_11_bold"><?php echo $row_usuario['bbh_usu_nome']; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td id="erroDep2"><input type="hidden" name="usuCod" id="usuCod" value="<?php echo $_GET['bbh_usu_codigo']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #F1F3F8;">
        <tr style="font-weight:bold; background-color:#F1F3F8">
          <td width="50%" height="20">Perfis adicionados</td>
          <td width="50%">&nbsp;Perfis dispon&iacute;veis</td>
        </tr>
        <tr>
          <td height="280" valign="top" style="border-right:#F1F3F8 solid 1px;" id="adicionados">&nbsp;</td>
          <td valign="top" id="disponiveis">&nbsp;</td>
        </tr>
          </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
