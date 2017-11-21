<?php
if(!isset($_SESSION)){ session_start();}
$_SESSION['totNosXml']=0;
	require_once('functionsAtividades.php'); 
	$CodAtividade= $_GET['bbh_ati_codigo'];
	
//totais de nohs no xml	
//echo "<var style='display:none'>txtSimples('totAtividade', '<strong>".$_SESSION['totNosXml']." coment&aacute;rios</strong>')</var>";
	$totFilhos = contaNohs($CodAtividade);
	if($totFilhos>1){ $Nohs = $totFilhos." coment&aacute;rios"; } else { $Nohs = $totFilhos." coment&aacute;rio"; }

echo "<var style='display:none'>txtSimples('totAtividadeII', '<strong>".$Nohs."</strong>')</var>";	
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/tarefas/acao/includes/executa.php?addComentario=true&Ts='.$TimeStamp;
	$idMensagemFinal= 'menLoad';
	$infoGet_Post	= 'updateAticidade';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Atualizando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?>
<?php if(statusAtividade($CodAtividade)!=2){ ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
      <tr>
        <td height="25" valign="middle" align="left"><label class="color">Digite um coment&aacute;rio para esta  atividade</label> <!--  - <label id="totAtividade"><strong>0 coment&aacute;rios</strong></label></label>--></td>
      </tr>
      <tr>
        <td height="30" valign="top" style="border:#D4D7C6 solid 1px; margin-top:5px;">

            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="84%"><textarea name="bbh_comentario" cols="70" rows="4" class="formulario3 verdana_11" id="bbh_comentario" style=" margin-left:0px;"></textarea></td>
                <td width="16%" align="center">
                <div style="margin-top:5px;">
                <?php //if($avisoAtividade==""){ 
							//if($Finalizada!=""){
						?>
                    <a href="#@" onclick="return <?php echo $acao; ?>" style="cursor:pointer;">
                    	<img src="/corporativo/servicos/bbhive/images/save.gif" border="0" />
                    </a>
                <?php 	/*	//}
				//} else { ?>
                		<img src="/corporativo/servicos/bbhive/images/saveOFF.gif" border="0" />
                <?php // } */ ?>
                </div>
                <div style="margin-top:5px;">    
                    <a href="#@" onclick="return limpaSimples('bbh_comentario', 'updateAticidade')">
                    	<img src="/corporativo/servicos/bbhive/images/cancel.gif" border="0" />
                    </a>
                </div>     
                    </td>
              </tr>
            </table>
           <?php } else { echo "&nbsp;"; }?> 
        </td>
      </tr>
      <tr>
        <td height="30" align="left">
          <div style="margin-top:3px;" id="menHistorico">
        	<?php echo leXML($CodAtividade); ?>
          </div>
       </td>
      </tr>
  </table>
