<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$query_modFluxos = "select count(bbh_mod_ati_codigo) as total FROM bbh_modelo_atividade Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
    list($modFluxos, $row_modFluxos, $totalRows_modFluxos) = executeQuery($bbhive, $database_bbhive, $query_modFluxos);
?>
<var style="display:none">txtSimples('tagPerfil', 'Permiss&atilde;o de <?php echo $_SESSION['adm_FluxoNome']; ?>')</var>
<var style='display:none'>OpenAjaxPostCmd('/e-solution/servicos/bbhive/fluxos/modelosFluxos/permissaoFluxo/adicionados.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>','adicionados','&1=1','Carregando dados...','adicionados','2','2');</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_10">
  <tr>
    <td width="55%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg" class="verdana_11_bold"><img src="/e-solution/servicos/bbhive/images/ger-fluxo-16px.gif" width="16" height="16" align="absmiddle" /> Gerenciamento de permiss&atilde;o de <?php echo $_SESSION['adm_FluxoNome']; ?></td>
    <td width="32%" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;</td>
    <td width="13%" align="right" background="/e-solution/servicos/bbhive/images/barra_horizontal.jpg"><a href="#" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral');"><span class="verdana_11_bold color">.:&nbsp;Voltar&nbsp;:.</span></a>&nbsp;</td>
  </tr>
  <tr>
    <td height="8" colspan="3"></td>
  </tr>
</table>
<?php require_once('../modelosAtividades/cabecaModelo.php'); ?>
<br />
<br />
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
      <tr>
        <td height="24" background="/e-solution/servicos/bbhive/images/cabAtiv.gif" class="legandaLabel11"><strong>&nbsp;Gerenciamento de permiss&atilde;o de <?php echo $_SESSION['adm_FluxoNome']; ?> </strong></td>
      </tr>
      <tr>
        <td height="100" valign="top" style="border-left:#CCCCCC solid 1px; border-right:#CCCCCC solid 1px; border-bottom:#CCCCCC solid 1px;"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
          <tr>
            <td height="20" colspan="2" valign="top">&nbsp;<div id="cadastraModelo"></div></td>
          </tr>
          
          <tr>
            <td width="293" height="24" valign="top"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
              <tr>
                <td height="20" background="/e-solution/servicos/bbhive/images/cabFlux.gif">&nbsp;Perfis adicionados</td>
              </tr>
              <tr>
                <td height="100" valign="top" bgcolor="#FBFAF4" id="adicionados">&nbsp;</td>
              </tr>
            </table></td>
            <td width="297" valign="top" style="border-left:#CCCCCC solid 1px;"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="legandaLabel11">
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
                <input name="button" type="button" class="back_input" id="button" value="Voltar"  onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/index.php','menuEsquerda|conteudoGeral');" style="cursor:pointer; background-image:url(/e-solution/servicos/bbhive/images/search.gif); color:#FFFFFF"/>&nbsp;&nbsp;&nbsp;            </div>    </td>
          </tr>
          <tr>
            <td height="5" colspan="2"></td>
          </tr>
        </table></td>
      </tr>
    </table>
