<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

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
	
?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Iniciar <?php echo $_SESSION['FluxoNome']; ?></strong></span>
      <label style="float:right;">
     <a href="#" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/regra.php?1=1<?php if(isset($_GET['bbh_pro_codigo'])){ echo "&bbh_pro_codigo=".$_GET['bbh_pro_codigo']; } ?><?php if(isset($_GET['bbh_ati_codigo'])){ echo "&bbh_ati_codigo=".$_GET['bbh_ati_codigo']; } ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<?php
//se tiver setado nº de protocolo exibe o cabeçalho do mesmo
 if(isset($_GET['bbh_pro_codigo'])){	
	require_once('../protocolo/cabecaProtocolo.php');
 }
//se veio da atividade 
 if(isset($_GET['bbh_ati_codigo'])){
 	require_once('../tarefas/includes/cabecalhoAtividade.php');
 }
?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td width="15%" height="18" align="right" class="color"><strong>C&oacute;d. tipo :&nbsp;</strong></td>
    <td width="85%">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']); ?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Tipo :&nbsp;</strong></td>
    <td>&nbsp;<?php echo $row_Fluxos['bbh_tip_flu_nome']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['FluxoNome']; ?>')</var>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="830" height="26" colspan="2" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Selecione o processo desejado</strong></td>
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
                  <a href="#" title="clique para iniciar este procedimento" onClick="return LoadSimultaneo('perfil/index.php?perfil=1&fluxo=1|fluxo/regra3.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?>&bbh_mod_flu_codigo=<?php echo $row_Fluxos['bbh_mod_flu_codigo']; ?><?php echo $complemento; ?>','menuEsquerda|colPrincipal');">
                    <strong>Iniciar</strong> <?php echo $row_Fluxos['bbh_mod_flu_nome']; ?>
                  </a>
                </td>
              <?php 
                $contador = $contador + 1;
              } while ($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>
        </tr>
<!--     
              <tr>
                <td width="48" height="1" align="center"><img src="/corporativo/servicos/bbhive/images/fluxo_p.jpg" border="0" /></td>
                <td width="270" height="1" valign="top"></td>
                <td width="48" height="1" align="center"><img src="/corporativo/servicos/bbhive/images/fluxo_p.jpg" border="0" /></td>
                <td width="280" height="1"></td>
                <td width="48" height="1" align="center"><img src="/corporativo/servicos/bbhive/images/fluxo_p.jpg" border="0" /></td>
                <td width="296" height="1"></td>
              </tr> -->
            </table>
        </td>
      </tr>


  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
