<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

//TROCA DE RESPONSÁVEL=====================================================================================
	if(isset($_POST['bbh_trocaResponsavel'])){
		$bbh_ind_codigo 		= $_POST['bbh_ind_codigo'];
		$bbh_ind_responsavel	= $_SESSION['MM_User_email'];
		$bbh_ind_dt_recebimento	= date("Y-m-d H:i:s");
		
		$updateSQL = "UPDATE bbh_indicio SET bbh_ind_responsavel='$bbh_ind_responsavel', bbh_ind_dt_recebimento='$bbh_ind_dt_recebimento' WHERE bbh_ind_codigo = $bbh_ind_codigo";
        list($Result1, $rows, $totalRowss) = executeQuery($bbhive, $database_bbhive, $updateSQL);
		
		$retorno = "showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|central_indicios/busca_profissional/regra.php','menuEsquerda|colPrincipal');";
		echo "<var style='display:none'>".$retorno."</var>";
	}
//========================================================================================================

foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_ind_codigo")||($indice=="bbh_ind_codigo")){ $bbh_ind_codigo = $valor; }
}

	$query_ind = "select d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome, t.bbh_tip_campos, u.bbh_usu_nome, x.bbh_usu_nome as profissional from bbh_indicio i
 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
 left join bbh_usuario x on i.bbh_ind_profissional = x.bbh_usu_identificacao
 		where bbh_ind_codigo = ".$bbh_ind_codigo."
    order by d.bbh_dep_codigo, t.bbh_tip_codigo asc";
    list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind);
	
	$cod 		= $row_ind['bbh_ind_codigo'];
	$realizado	= !empty($row_ind['bbh_ind_dt_exame']) ? 1 : 0;
	
	$acao = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/central_indicios/indicio.php','resultIndicios','trocaResponsavel','Alterando informa&ccedil;&otilde;es...','resultIndicios','1','2');";
	
	$bbh_pro_codigoInd = $row_ind['bbh_pro_codigo'];

	/*===============================INICIO AUDITORIA POLICY=========================================*/
	$_SESSION['relevancia']="0";
	$_SESSION['nivel']="1";
	$Evento="Visualizou as informações do indício ($cod) - (".$row_ind['bbh_tip_nome'].") - BBHive corporativo.";
	EnviaPolicy($Evento);
	/*===============================FIM AUDITORIA POLICY============================================*/
	
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";	
?>
<table width="600" border="0" cellspacing="0" cellpadding="0" class="legandaLabel11">
  <tr>
    <td height="25" colspan="3" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/visualizar_indicio.gif" width="16" height="16" border="0" align="absmiddle" style="margin-left:2px;"/>&nbsp;<strong>Detalhes do ind&iacute;cio</strong></td>
  </tr>
  <tr>
    <td height="22" colspan="2" style="border-left:#cccccc solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" /> <strong>&nbsp;<?php echo !empty($row_ind['bbh_usu_nome']) ? $row_ind['bbh_usu_nome'] : $row_ind['bbh_ind_responsavel']; ?></strong></td>
    <td width="187" style="border-right:#cccccc solid 1px;"><strong>Desde</strong>:&nbsp;<?php echo $dt=arrumadata(substr($row_ind['bbh_ind_dt_recebimento'],0,10)) ." ".substr($row_ind['bbh_ind_dt_recebimento'],11,5); ?></td>
  </tr>
  <tr>
    <td height="22" colspan="3" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><img src="/corporativo/servicos/bbhive/images/departamentoII.gif" width="16" height="16" border="0" align="absmiddle" title="Departamento" style="margin-left:15px;" /><strong>&nbsp;<?php echo $row_ind['bbh_dep_nome']; ?></strong></td>
  </tr>
  <tr>
    <td height="22" colspan="3" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><img src="/corporativo/servicos/bbhive/images/tipo.gif" width="16" height="16" border="0" align="absmiddle" title="Tipo do indício" style="margin-left:25px;" /> &nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <tr>
    <td height="22" align="right" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td colspan="2" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?></td>
  </tr>
  <tr>
    <td height="22" align="right" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td colspan="2" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?></td>
  </tr>
  <tr>
    <td height="22" align="right" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td colspan="2" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;">
      	<div style="float:left"><strong>Quantidade</strong>:&nbsp;<?php echo $row_ind['bbh_ind_quantidade']; ?></div>
        <div style="float:left; margin-left:100px;"><strong>Unidade de medida</strong>:&nbsp;<?php echo unidadeMedida($row_ind['bbh_ind_unidade'], 1); ?></div>
    </td>
  </tr>
  <tr>
    <td width="49" height="22" align="right" class="legandaLabel11" style="border-left:#cccccc solid 1px;"><img src="/corporativo/servicos/bbhive/images/circulo.gif" width="16" height="16" border="0" align="absmiddle" title="Indício" /></td>
    <td width="324" align="left" class="legandaLabel11">
        <div style="margin-left:5px">
            <span class="color"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></span>
        </div>
    </td>
    <td class="legandaLabel11" style="border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="22" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td colspan="2" class="legandaLabel11" style="border-right:#cccccc solid 1px;">
    	<div style="margin-left:10px;">
    <table width="540" border="0" cellspacing="0" cellpadding="0" style="border:#E1E1E1 solid 1px;margin-bottom:2px;">
              <tr>
                <td height="25" colspan="3" style="border-bottom:#E1E1E1 solid 1px;">
                  <table width="100%" style="background:#DFEFDF; border:#FFF solid 1px; height:100%;" class="legandaLabel11">
                    <tr>
                        <td width="89%" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/busca_indicios.gif" width="16" height="16" align="absbottom">&nbsp;<strong style="color:#339900">Ind&iacute;cio
                          
                        </strong></td>
                        <td width="6%" align="center">&nbsp;</td>
                        <td width="5%" align="center">&nbsp;</td>
                    </tr>
                  </table>  
                </td>
              </tr>
              <tr>
                <td width="231" height="22" align="left" valign="middle">&nbsp;<?php if($realizado==1){ echo "<strong>Exame efetuado</strong>"; } else { echo "Exame n&atilde;o efetuado"; } ?></td>
                <td width="277" align="left" valign="middle">
                <div id="dtExame">Data do exame :&nbsp;<?php echo !empty($row_ind['bbh_ind_dt_exame']) ? arrumadata(substr($row_ind['bbh_ind_dt_exame'],0,10)) : "---";?></div></td>
              </tr>
              <tr>
                <td height="22" colspan="3" align="left">
                    <div style="margin-left:3px;" id="qtdExame_<?php echo $cod; ?>">
        <strong>Responsável pela análise: <?php echo !empty($row_ind['profissional']) ? $row_ind['profissional'] : $row_ind['bbh_ind_profissional']; ?></strong>
        <div>&nbsp;</div>
        
        
                    <span>Quantidade de procedimentos realizados:&nbsp;<strong><?php echo $row_ind['bbh_ind_qt_procedimento']; ?></strong></span></div>
                </td>
              </tr>
              <tr>
                <td height="60" colspan="3" align="left" valign="top">
                    <div style="margin-left:3px;margin-top:5px;" id="nmProcedimentos_<?php echo $cod; ?>">
                        <u>Procedimentos realizados :</u><br>
                        <span style="color:#339900">
                        <strong><?php echo $row_ind['bbh_ind_procedimentos']; ?></strong>
                        </span>
                    </div>
                </td>
              </tr>
          </table>
      </div>
    </td>
  </tr>
  <tr>
    <td height="22" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td colspan="2" class="legandaLabel11" style="border-right:#cccccc solid 1px;">&nbsp;</td>
  </tr>
  <tr>
    <td height="22" colspan="3" style="border-left:#cccccc solid 1px;border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;">
    	<?php 
		$titIndicio = "Protocolo deste indício";
		require_once("../consulta/includes/protocolos.php"); ?>
    </td>
  </tr>
</table>
<p>
  <input name="cadastrar2" style="background:url(/servicos/bbhive/images/pesquisar.gif);background-repeat:no-repeat;background-position:left;height:23px;width:250px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar" value="&nbsp;Voltar para p&aacute;gina de ind&iacute;cios" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|central_indicios/busca_profissional/regra.php','menuEsquerda|colPrincipal');"/>
  <input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/trocar.gif);background-repeat:no-repeat;background-position:left;height:23px;width:200px;margin-right:5px; cursor:pointer;background-color:#FFFFFF;" type="button" class="back_input" id="cadastrar2" value="&nbsp;Assumir responsabilidade" onclick="if(confirm('Tem certeza que deseja assumir a responsabilidade deste indício?\n              Clique em OK em caso de confirmação.')){ <?php echo $acao; ?> }"/>
</p>
<div class="legandaLabel11"><span class="color" id="resultIndicios">&nbsp;</span><span style="font-size:14px;">&nbsp;</span></div>
<form name="trocaResponsavel" id="trocaResponsavel">
	<input name="bbh_ind_codigo" id="bbh_ind_codigo" type="hidden" value="<?php echo $cod; ?>" />
    <input name="bbh_trocaResponsavel" id="bbh_trocaResponsavel" type="hidden" value="1" />
</form>