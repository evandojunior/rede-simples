<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");

	$query_Fluxos = "select bbh_flu_codigo, bbh_mod_flu_codigo, bbh_flu_data_iniciado, bbh_flu_titulo, bbh_flu_oculto from bbh_fluxo
      Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_flu_tarefa_pai is NULL
           order by bbh_flu_codigo desc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
	
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1.1";
$Evento="Acessou a ".mysqli_fetch_assoc("página")." para o tipo de ".$_SESSION['FluxoNome']." - BBHive.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['FluxoNome']; ?>')</var>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;<?php echo $_SESSION['FluxoNome']; ?></strong></span>
      <label style="float:right;">
     <a href="#@" onClick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1|includes/colunaDireita.php?arquivosFluxos=1&equipeFluxos=1&arquivos=1&relatorios=1','menuEsquerda|colCentro|colDireita');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
        <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<fieldset>
	<legend class="verdana_11"><strong>Selecione</strong></legend>
    	<br>
<table width="98%" center="center" border="0" align="left" cellpadding="0" cellspacing="0">
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
                <td width="48" height="1" align="center"><img src="/corporativo/servicos/bbhive/images/fluxo_p2.jpg" border="0" /></td>
                <td width="270" height="1" valign="top" class="verdana_11">
                  <a href="#" title="clique para iniciar este procedimento" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_Fluxos['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');">
        <?php if($row_Fluxos['bbh_flu_oculto']=='1') { ?>
        &nbsp;<img src="/corporativo/servicos/bbhive/images/cadeado_off.gif" border="0" align="absmiddle" title="<?php echo $_SESSION['FluxoNome']; ?> oculto" />
        <?php } ?> 
					<?php echo $row_Fluxos['bbh_flu_titulo']; ?>
                  </a>
                </td>
              <?php 
                $contador = $contador + 1;
              } while ($row_Fluxos = mysqli_fetch_assoc($Fluxos)); ?>
        </tr>
      </table>
</fieldset>