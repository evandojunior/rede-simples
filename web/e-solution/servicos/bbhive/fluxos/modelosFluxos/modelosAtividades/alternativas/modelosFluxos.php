<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	$query_modFluxo = "select 
bbh_modelo_fluxo.bbh_mod_flu_codigo, bbh_mod_flu_nome, bbh_mod_flu_sub
 from bbh_modelo_fluxo
      inner join bbh_modelo_atividade on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_modelo_atividade.bbh_mod_flu_codigo
       group by bbh_modelo_fluxo.bbh_mod_flu_codigo
        order by bbh_mod_flu_nome asc";
    list($modFluxo, $row_modFluxo, $totalRows_modFluxo) = executeQuery($bbhive, $database_bbhive, $query_modFluxo);
	
	$idMensagemFinal= 'carregaModelo';
	$infoGet_Post	= '?1=1&bbh_mod_flu_codigo=xxx';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/alternativas/atividades.php';
	$homeDestinoII	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/alternativas/novo.php';
	
	$onClick = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')";
	
	$acao = "OpenAjaxPostCmd('".$homeDestinoII."','cadatraAlternativa','cadatraAlt','Cadastrando dados...','cadatraAlternativa','1','".$TpMens."');";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#000000 solid 1px; background:#FFFFFF;">
  <tr>
    <td width="96%" height="19" background="/e-solution/servicos/bbhive/images/back_cabeca_label.gif" class="verdana_11" style="color:#FFFFFF">Modelos dispon&iacute;veis</td>
    <td width="4%" align="center" background="/e-solution/servicos/bbhive/images/back_cabeca_label.gif"><a href="#@" onClick="document.getElementById('bbh_atividade_predileta').className='show'; document.getElementById('carregaModelo').innerHTML='';"><img src="/e-solution/servicos/bbhive/images/close.gif" alt="Fechar" width="13" height="13" border="0" align="absmiddle"></a></td>
  </tr>
  <tr>
    <td height="200" colspan="2" valign="top">
    <fieldset style="margin-left:5px; margin-right:5px;">
        <legend class="verdana_11"><strong>Escolha o modelo</strong></legend>
            <br>
                
                <?php if($totalRows_modFluxo>0){?>
                 <?php do{ 
                    $CodigoPai 	= $row_modFluxo['bbh_mod_flu_codigo'];
                    $complemento= "";
                    ?>    
                    
                        <div>
                            <div style="display:inline">
                                <a href="#@" onClick=" return elementoArvore('Tagfilho_<?php echo $CodigoPai; ?>','<?php echo $homeDestino."?bbh_mod_flu_codigo=$CodigoPai&mod_ati_nome=".$row_modFluxo['bbh_mod_flu_nome']; ?>');">
                                    <img src="/e-solution/servicos/bbhive/images/debito.gif" id="icone_<?php echo $CodigoPai; ?>" border="0" align="absmiddle" />
                                </a>
                            </div>
                            <div style="display:inline;margin-left:3px;" class="verdana_9_bold">

                            <?php echo "&nbsp;&nbsp;".$row_modFluxo['bbh_mod_flu_nome']; ?>

                            <input name="cont_populado_<?php echo $CodigoPai; ?>" type="hidden" id="cont_populado_<?php echo $CodigoPai; ?>" value="0" size="10" /></div>
                        </div>
                        
                        <!--FILHO-->
                        <div id="Tagfilho_<?php echo $CodigoPai; ?>" style="margin-left:15px;display:none">
                            <div id="conteudo_<?php echo $CodigoPai; ?>">
                            	&nbsp;
                            </div>
                        </div>

                 <?php } while ($row_modFluxo = mysqli_fetch_assoc($modFluxo));  ?>
                <?php } ?>
               
    </fieldset>
</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#E0DFE3" style="border-top:#CCCCCC solid 1px;">&nbsp;</td>
  </tr>
</table>