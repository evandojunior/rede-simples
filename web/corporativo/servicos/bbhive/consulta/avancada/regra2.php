<?php
if(!isset($_SESSION)){ session_start(); } 
require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_per_nome, bbh_usu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_tip_flu_codigo = ".$_GET['bbh_tip_flu_codigo']." AND bbh_mod_flu_sub = '0'
			GROUP by bbh_mod_flu_codigo
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
?><table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
      <tr>
        <td colspan="2" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg">&nbsp;<img src="/corporativo/servicos/bbhive/images/listaIII.gif" border="0" align="absmiddle" />&nbsp;<strong>Console de busca avan&ccedil;ada <?php echo $_SESSION['FluxoNome']; ?></strong>
          <label style="float:right;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="#" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|consulta/avancada/regra.php','menuEsquerda|conteudoGeral')";>
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>        </td>
      </tr>
      <tr>
        <td width="4%" height="22" align="center" bgcolor="#EFEFE7" class="verdana_11">&nbsp;</td>
        <td width="96%" class="verdana_11">
<div style="float:right;">
        <a href="#@" onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|consulta/index.php','menuEsquerda|conteudoGeral');">
       	   <img src="/corporativo/servicos/bbhive/images/busca.gif" border="0" align="absmiddle" />&nbsp;<strong>Busca simples</strong>
        </a>   
        </div>
        </td>
      </tr>
      <tr>
        <td height="22" align="center" bgcolor="#EFEFE7">&nbsp;</td>
        <td width="96%"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
          <tr>
            <td width="12%" height="18" align="right" class="color"><strong>C&oacute;d. tipo :&nbsp;</strong></td>
            <td width="88%">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']); ?></td>
          </tr>
          <tr>
            <td height="18" align="right" class="color"><strong>Tipo :&nbsp;</strong></td>
            <td>&nbsp;<?php echo $row_Fluxos['bbh_tip_flu_nome']; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="22" colspan="2" align="right" bgcolor="#EFEFE7" class="verdana_11"></td>
      </tr>
  </table>
  
<var style="display:none">txtSimples('tagPerfil', 'Consulta avançada')</var>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="830" height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Selecione o modelo desejado</strong></td>
  </tr>

      <tr>
        <td height="22" colspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" colspan="2">
<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
              <tr>
                <td width="48" height="1"></td>
                <td width="270" height="1"></td>
                <td width="48" height="1"></td>
                <td width="280" height="1"></td>
                <td width="48" height="1"></td>
                <td width="296" height="1"></td>
              </tr>
              <tr>
              <?php 
			$complemento= "";
			
				if(isset($_GET['bbh_pro_codigo'])){
					$complemento = "&bbh_pro_codigo=".$_GET['bbh_pro_codigo'];
				}
				if(isset($_GET['bbh_ati_codigo'])){
					$complemento = "&bbh_ati_codigo=".$_GET['bbh_ati_codigo'];
				}
              $contador = 0;
              do {
                if($contador==3){
                    echo "</tr> 
                          <tr>
                            <td  colspan='6' height='8'></td>
                          </tr>
                    <tr>";
                    $contador=0;
                }
                ?>
                <td width="48" height="1" align="center"><img src="/corporativo/servicos/bbhive/images/fluxo_p.jpg" border="0" /></td>
                <td width="270" height="1" valign="top">
                  <a href="#@" title="clique para consultar este modelo" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&perfis=1|consulta/avancada/regra3.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&bbh_mod_flu_codigo=<?php echo $row_Fluxos['bbh_mod_flu_codigo']; ?><?php echo $complemento; ?>','menuEsquerda|conteudoGeral');">
                    <strong>Consultar</strong> <?php echo $row_Fluxos['bbh_mod_flu_nome']; ?>
                  </a>
                </td>
              <?php 
                $contador = $contador + 1;
              } while ($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>
        </tr>
            </table>
        </td>
      </tr>


  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>