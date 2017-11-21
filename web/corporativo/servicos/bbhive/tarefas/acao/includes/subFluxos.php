<br />
<table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="584" height="33" style="background-image:url(/corporativo/servicos/bbhive/images/backTopII.jpg); background-repeat:no-repeat; border-left:#D7D7D7 solid 1px;">
    <div id="sub" style="width:117px; height:25px; margin-top:5px; vertical-align:middle;font-weight:bold;" class="verdana_12 color">&nbsp;<strong>Fluxos (<?php echo $totalRows_subFluxo; ?>)</strong></div>
    
	<label style="position:absolute; margin-top:-25px; margin-left:130px;" class="verdana_12"></label></td>
  </tr>
  <tr>
    <td height="30" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#EBEFF0 solid 1px; border-bottom:#D7D7D7 solid 1px" id="sub" class="verdana_11 color">
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
     
 <?php 
 $totStatus=0;
 do{ 
 	//atividades finalizadas
	$query_Finalizadas = "select count(bbh_ati_codigo) as Total from bbh_atividade
		  Where bbh_flu_codigo=".$row_subFluxo['bbh_flu_codigo']." and bbh_sta_ati_codigo=2";
     list($Finalizadas, $row_Finalizadas, $totalRows_Finalizadas) = executeQuery($bbhive, $database_bbhive, $query_Finalizadas);
	
	$codFluPai 		= $row_subFluxo['bbh_flu_codigo'];
	$exibe			= "conteudoFilho_".$codFluPai;
	$homeDestinoV	= '/corporativo/servicos/bbhive/tarefas/acao/includes/subAtividades.php?bbh_flu_codigo='.$codFluPai.'&Ts='.$TimeStamp."&title=";
	$acaoDecisao 	= "OpenAjaxPostCmd('".$homeDestinoV."','".$exibe."','".$infoGet_Post."','".$Mensagem."','".$exibe."','2','2');";
 ?>    
      <tr>
        <td height="22" colspan="2" bgcolor="#FAFAFA"  <?php if(($atividade->usuarioAtividade==$_SESSION['usuCod'])||($atividade->responsavelFluxo==$_SESSION['usuCod'])){?>style="cursor:pointer" onclick="javascript: if(document.getElementById('filho_<?php echo $codFluPai; ?>').className=='hide') { document.getElementById('filho_<?php echo $codFluPai; ?>').className='show'; <?php echo $acaoDecisao; ?> } else { document.getElementById('filho_<?php echo $codFluPai; ?>').className='hide'; }" <?php } ?>>&nbsp;<img src="/corporativo/servicos/bbhive/images/listaII.gif" border="0" align="absmiddle" />&nbsp;<?php echo $row_subFluxo['bbh_flu_titulo']; ?>
        <label style="margin-top:-13px; float:right; margin-right:10px;">Status: <?php echo round($row_subFluxo['Peso'],2); ?>%</label>
        </td>
        </tr>
      <tr>
        <td width="299"><table width="270" border="0" align="center" cellpadding="0" cellspacing="0">

          <tr class="legandaLabel">
            <td width="43%" height="15">&nbsp;<?php echo strtolower($_SESSION['TarefasNome']); ?></td>
            <td width="57%">&nbsp;<?php echo strtolower($_SESSION['TarefasNome']); ?> finalizadas</td>
          </tr>
          <tr class="legandaLabel">
            <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle" />&nbsp;<?php echo $s=$row_subFluxo['Tarefas']; ?></td>
            <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/carimbo16.gif" border="0" align="absmiddle" />&nbsp;<?php echo $t=$row_Finalizadas['Total']; ?></td>
          </tr>
        </table></td>
        <td width="297">
        
        <table width="270" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr class="legandaLabel">
            <td width="43%" height="15">&nbsp;Iniciado em</td>
            <td width="57%">&nbsp;T&eacute;rmino previsto</td>
          </tr>
          <tr class="legandaLabel">
            <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendarioII.gif" border="0" align="absmiddle" />&nbsp;<?php echo $i=arrumadata($row_subFluxo['bbh_flu_data_iniciado']); ?></td>
            <td height="15">&nbsp;<img src="/corporativo/servicos/bbhive/images/calendario.gif" border="0" align="absmiddle" />&nbsp;<?php echo $p=arrumadata($row_subFluxo['tPrevisto']); ?></td>
          </tr>

        </table>  
        
        </td>
      </tr>
      <!--Atividades-->
      <tr id="filho_<?php echo $codFluPai; ?>" class="hide">
      	<td height="1" colspan="2" id="conteudoFilho_<?php echo $codFluPai; ?>"></td>
      </tr>
      <tr>
        <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
<?php 
	$totStatus = $totStatus + $row_subFluxo['Peso'];
} while ($row_subFluxo = mysqli_fetch_assoc($subFluxo)); ?>
    </table></td>
  </tr>
</table>
<?php
if(round($totStatus/$totalRows_subFluxo,2)!=100.00){
	$subFilho=1;
}
?>