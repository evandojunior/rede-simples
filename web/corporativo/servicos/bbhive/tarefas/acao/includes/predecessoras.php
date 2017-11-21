<?php
$TimeStamp 		= time();
$homeDestino	= '/corporativo/servicos/bbhive/tarefas/acao/includes/comentario.php?bbh_ati_codigo=XXXX&addComent=true&Ts='.$TimeStamp."&";
$carregaPagina	= "OpenAjaxPostCmd('".$homeDestino."','yyyyyyyyyyyyy','updateAticidade','&nbsp;Carregando dados...','yyyyyyyyyyyyy','1','2');";

$carregaComentario	= "OpenAjaxPostCmd('".$homeDestino."','yyyyyyyyyyyyy','&1=1','&nbsp;Carregando dados...','yyyyyyyyyyyyy','2','2');";
?><br />
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="584" height="33" background="/corporativo/servicos/bbhive/images/backTopII.jpg" style="border-left:#D7D7D7 solid 1px;">
    <div id="pred" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>Predecessoras </strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label></td>
  </tr>
  <tr>
    <td height="30" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="predecessoras" class="verdana_11 color">
    
        <table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
        <?php for($pred=0; $pred<$totPredecessora; $pred++){ ?>  
          <tr>
            <td height="22" colspan="3">&nbsp;<img src="/corporativo/servicos/bbhive/images/setaIII.gif" align="absmiddle" />&nbsp;<?php echo $Predecessoras[$pred]->nome; ?>
	<label style="float:right; margin-top:-13px;color:#666666">
		<?php 
			if($Predecessoras[$pred]->pesoStatus == "100"){
				$andamento = "Conclu&iacute;do em ".arrumadata($Predecessoras[$pred]->finalReal);
			} else {
				$andamento = "Final previsto : ".arrumadata($Predecessoras[$pred]->finalPrevisto);
			}
		echo $andamento; ?>
	</label>            </td>
          </tr>
          <tr>
            <td height="22" colspan="3" ><table width="98%" border="0" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td width="322" height="22"><img src="/corporativo/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;<?php
            
				if($Predecessoras[$pred]->codDepartamento==$atividade->meuDepartamento){
					echo $Predecessoras[$pred]->usuNome;
				} else {
					echo $Predecessoras[$pred]->nmDepartamento;
				}
			?></td>
                <td width="208" align="right"><label class="color"><?php echo $Predecessoras[$pred]->nmStatus; ?></label></td>
              </tr>
            </table></td>
          </tr>

          <?php
		  $codPredecessora = $Predecessoras[$pred]->codigo;
		  $link = str_replace("bbh_ati_codigo=XXXX","bbh_ati_codigo=".$codPredecessora,$carregaPagina);
		  $link = str_replace("yyyyyyyyyyyyy","load_".$codPredecessora,$link);
		  
		  $linkComent = str_replace("bbh_ati_codigo=XXXX","bbh_ati_codigo=".$codPredecessora,$carregaComentario);
		  $linkComent = str_replace("yyyyyyyyyyyyy","load_".$codPredecessora,$linkComent);
		  $linkComent = str_replace("addComent=true","viewComent=true&title=".$Predecessoras[$pred]->nome,$linkComent);
		  ?>
         
         <?php if($atividade->bbh_flu_finalizado=='0'){ ?>
          <tr>
            <td height="1" colspan="3">
            <label style="margin-left:15px;">
            	<a href="#<?php echo $codPredecessora; ?>" onclick="javascript: if(document.getElementById('comen_<?php echo $codPredecessora; ?>').className=='hide'){document.getElementById('comen_<?php echo $codPredecessora; ?>').className='show'; document.getElementById('load_<?php echo $codPredecessora; ?>').innerHTML='';} else {document.getElementById('comen_<?php echo $codPredecessora; ?>').className='hide'}"><span style="color:#666666">Enviar recado</span></a>
                &nbsp;|&nbsp;
                <a href="#<?php echo $codPredecessora; ?>" onclick="return <?php echo $linkComent; ?>"><span style="color:#666666">Exibir recados anteriores</span></a>            </label>
            <label id="load_<?php echo $codPredecessora; ?>" style="margin-left:15px;" class="color">&nbsp;</label>            </td>
          </tr>
          <tr class="hide" id="comen_<?php echo $codPredecessora; ?>">
            <td height="1" colspan="3">
            <label style="margin-left:15px;">
            	<textarea name="comentario_<?php echo $codPredecessora; ?>" cols="75" id="comentario_<?php echo $codPredecessora; ?>" rows="3" class="formulario2"></textarea><br />
                <label style="margin-left:15px;">
                 <a href="#<?php echo $codPredecessora; ?>" onclick="javascript: document.getElementById('comen_<?php echo $codPredecessora; ?>').className='hide'">
                	<img src="/corporativo/servicos/bbhive/images/canMen.gif" border="0" />                  </a>                </label>
				<label style="margin-left:5px;">
                 <a href="#<?php echo $codPredecessora; ?>" onclick="return <?php echo $link; ?>">
                	<img src="/corporativo/servicos/bbhive/images/envMen.gif" border="0" />                 </a>                </label>
            </label>            </td>
          </tr>
          <?php } ?>
          <tr>
            <td height="1" colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
          </tr>
        <?php } ?>  
        </table>

    </td>
  </tr>
</table>