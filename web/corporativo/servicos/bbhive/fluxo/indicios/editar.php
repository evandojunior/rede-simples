<?php
if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
 	//recuperação de variáveis do GET e SESSÃO
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;bbh_ind_codigo")||($indice=="bbh_ind_codigo")){ $bbh_ind_codigo=$valor; }
		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
	}

	$query_ind = "select d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome, t.bbh_tip_campos, bbh_usu_nome from bbh_indicio i
 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
 		where bbh_ind_codigo = ".$bbh_ind_codigo;
    list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind);
	
	$cod 		= $row_ind['bbh_ind_codigo'];
	$realizado	= !empty($row_ind['bbh_ind_dt_exame']) ? 1 : 0;
			
	$acao = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/executa.php','resultIndicios','nomeForm','Alterando informa&ccedil;&otilde;es...','resultIndicios','1','2');";

	$execExame	= str_replace("nomeForm","exameRealizado", $acao);
	
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";
?>
<table width="560" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="5" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['componentesNome']; ?> cadastrados</strong></td>
  </tr>
  <tr>
    <td height="20" colspan="5" align="left" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>

  <tr>
    <td height="20" colspan="5" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;&nbsp;&nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?></td>
  </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?></td>
  </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;">
      	<div style="float:left"><strong>Quantidade</strong>:&nbsp;<?php echo $row_ind['bbh_ind_quantidade']; ?></div>
        <div style="float:left; margin-left:100px;"><strong>Unidade de medida</strong>:&nbsp;<?php echo unidadeMedida($row_ind['bbh_ind_unidade'], 1); ?></div>
    </td>
  </tr>
  <tr>
    <td width="33" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="2" align="left" class="legandaLabel11"><span class="color"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></span></td>
    <td width="121" height="20" colspan="2" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; <?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>">&nbsp;</td>
    <td width="339" height="20" align="left" class="legandaLabel11" style="<?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>">&nbsp;<img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" /> <strong>&nbsp;<?php echo !empty($row_ind['bbh_usu_nome']) ? $row_ind['bbh_usu_nome'] : $row_ind['bbh_ind_responsavel']; ?></strong></td>
    <td height="20" colspan="3" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px; <?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>"><strong>Desde</strong>:&nbsp;<?php echo $dt=arrumadata(substr($row_ind['bbh_ind_dt_recebimento'],0,10)) ." ".substr($row_ind['bbh_ind_dt_recebimento'],11,5); ?></td>
  </tr>
  <tr>
    <td width="33" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;">
    	<div style="margin-left:10px;">
        	<table width="510" border="0" cellspacing="0" cellpadding="0" style="border:#E1E1E1 solid 1px;margin-bottom:2px;">
              <tr>
                <td height="25" colspan="2" style="border-bottom:#E1E1E1 solid 1px;">
                  <table width="100%" style="background:#DFEFDF; border:#FFF solid 1px; height:100%;" class="legandaLabel11">
                    <tr>
                        <td width="89%" align="left">&nbsp;<img src="/corporativo/servicos/bbhive/images/detalhesIndicios.gif" width="16" height="16" align="absbottom">&nbsp;<strong style="color:#339900">Gerenciamento deste ind&iacute;cio
                          <input name="realizado_<?php echo $cod; ?>" type="hidden" id="realizado_<?php echo $cod; ?>" value="<?php if($realizado==1){ echo 1; } else { echo 0; } ?>">
                        </strong></td>
                        <td width="6%" align="center"><a href="#@" onClick="document.getElementById('bbh_ind_codigoReal').value='<?php echo $cod; ?>'; document.getElementById('bbh_ind_dt_exame').value = document.getElementById('bbh_ind_dt_exame_<?php echo $cod; ?>').value; document.getElementById('bbh_ind_procedimentos').value = document.getElementById('bbh_ind_procedimentos_<?php echo $cod; ?>').value; document.getElementById('bbh_ind_qt_procedimento').value = document.getElementById('bbh_ind_qt_procedimento_<?php echo $cod; ?>').value; document.getElementById('bbh_realizado').value = document.getElementById('realizado_<?php echo $cod; ?>').value; <?php echo $execExame; ?>"><img src="/corporativo/servicos/bbhive/images/salvar.gif" width="16" height="16" border="0" align="absmiddle" title="Atualizar informações deste indício"></a></td>
                        <td width="5%" align="center"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&exibeIndicios=true|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $bbh_flu_codigo; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');"><img src="/corporativo/servicos/bbhive/images/painel/fechar.gif" width="18" height="18" border="0" align="absmiddle" title="Fechar edição de indício" /></a></td>
                    </tr>
                  </table>  
                </td>
              </tr>
              <tr>
                <td width="231" height="22" align="left" valign="middle"><input type="checkbox" name="chk_exame_<?php echo $cod; ?>" id="chk_exame_<?php echo $cod; ?>" <?php if($realizado==1){ echo "checked"; } ?> onClick="javascript: if(this.checked==true){ document.getElementById('realizado_<?php echo $cod; ?>').value='1'; } else { document.getElementById('realizado_<?php echo $cod; ?>').value='0'; }">
                  Efetuei exame neste ind&iacute;cio</td>
                <td width="277" align="left" valign="middle">
                <div id="dtExame">
                Data do exame :<input name="bbh_ind_dt_exame_<?php echo $cod; ?>" class="back_Campos" type="text" id="bbh_ind_dt_exame_<?php echo $cod; ?>" size="11" maxlength="10" onKeyPress="MascaraData(event, this)" style="height:15px;" value="<?php echo !empty($row_ind['bbh_ind_dt_exame']) ? arrumadata(substr($row_ind['bbh_ind_dt_exame'],0,10)) : "";?>"></div></td>
              </tr>
              <tr>
                <td height="22" colspan="2" align="left">
                    <div style="margin-left:3px;" id="qtdExame_<?php echo $cod; ?>">
                        Quantos procedimentos foram realizados:
                        <select name="bbh_ind_qt_procedimento_<?php echo $cod; ?>" id="bbh_ind_qt_procedimento_<?php echo $cod; ?>" class="verdana_9">
                         <?php for($a=1; $a<=100; $a++){ if($a<10){ $a="0".$a;}?>
                            <option value="<?php echo $a; ?>" <?php if($row_ind['bbh_ind_qt_procedimento']==$a){echo "selected"; }?>><?php echo $a; ?></option>
                         <?php } ?>>   
                        </select>
                    </div>
                    </td>
              </tr>
              <tr>
                <td height="60" colspan="2" align="left" valign="top">
                <div style="margin-left:3px;" id="nmProcedimentos">
                    Procedimentos realizados :<br>
                    <textarea class="formulario2" name="bbh_ind_procedimentos_<?php echo $cod; ?>" id="bbh_ind_procedimentos_<?php echo $cod; ?>" cols="90" rows="3"><?php echo $row_ind['bbh_ind_procedimentos']; ?></textarea>
                </div>
                </td>
              </tr>
              </table>
        </div>
    </td>
  </tr>
</table>
<div class="legandaLabel11"><span class="color" id="resultIndicios">&nbsp;</span><span style="font-size:14px;">&nbsp;</span></div>