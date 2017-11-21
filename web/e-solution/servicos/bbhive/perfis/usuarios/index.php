<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

$codigo = -1;
if(isset($_GET['bbh_per_codigo'])){
	$codigo = $_GET['bbh_per_codigo'];
}

	$query_perfil = "SELECT bbh_per_nome, bbh_per_codigo FROM bbh_perfil WHERE bbh_per_codigo = $codigo";
    list($perfil, $row_perfil, $totalRows_perfil) = executeQuery($bbhive, $database_bbhive, $query_perfil);
?>
<var style="display:none">per_carregaAdicionados();</var>
<var style="display:none">per_carregaDisponiveis('on');</var>
<var style="display:none">txtSimples('tagPerfil', 'Perfis')</var>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="26" colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-perfis-16px.gif" width="14" height="14" align="absmiddle" /> Gerenciamento de <?php echo $_SESSION['adm_perfNome']; ?>
      <div style="float:right;"><a href="#@" 

onClick="showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&menuEsquerda=1|perfis/index.php','menuEsquerda|colCentro');"><span 

class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="14" colspan="2"></td>
  </tr>
  <tr>
    <td width="7%">&nbsp;</td>
    <td width="93%"><img 

src="/e-solution/servicos/bbhive/images/apontadireita.gif" alt="" width="4" height="8" align="absmiddle" /> Atribui&ccedil;&atilde;o de usu&aacute;rios para <span class="verdana_11_bold"><?php echo $row_perfil['bbh_per_nome']; ?></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="hidden" name="perfCod" id="perfCod" value="<?php echo $_GET['bbh_per_codigo']; ?>"></td>
  </tr>
  <tr>
    <td colspan="2">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #F1F3F8;">
        <tr style="font-weight:bold; background-color:#F1F3F8">
          <td width="50%" height="20">Usu&aacute;rios adicionados</td>
          <td width="50%">&nbsp;Usu&aacute;rios dispon&iacute;veis</td>
        </tr>
        <tr>
          <td height="280" valign="top" style="border-right:#F1F3F8 solid 1px;" id="per_adicionados">&nbsp;</td>
          <td valign="top" id="per_disponiveis">&nbsp;</td>
        </tr>
          </table></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
