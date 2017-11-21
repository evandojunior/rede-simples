<?php
//Indicios deste protocolo
	$query_relTipo = "select tp.bbh_tip_nome, tp.bbh_tip_codigo
						 from bbh_indicio as i 
						  inner join bbh_tipo_indicio as tp on i.bbh_tip_codigo = tp.bbh_tip_codigo
						  where i.bbh_pro_codigo=$bbh_pro_codigo
						   group by tp.bbh_tip_codigo
						    order by i.bbh_tip_codigo, i.bbh_ind_codigo asc";
    list($relTipo, $rows, $totalRows_relTipo) = executeQuery($bbhive, $database_bbhive, $query_relTipo, $initResult = false);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="4" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">&nbsp;<img src="/corporativo/servicos/bbhive/images/caixa.gif" border="0" align="absmiddle" />&nbsp;<strong>(<label id="totInd"><?php echo $totalRows_relTipo; ?></label>) <?php echo $_SESSION['componentesNome']; ?>(s) cadastrado(s)</strong></td>
  </tr>
</table>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#cccccc solid 1px;">
  <tr>
    <td width="566" height="22">
   <?php
//--
$vrUniTot 	= 0;
$vrTotTot 	= 0;
$QtdTot 	= 0;
$tipoAgora	= 0;
$total_ind	= 0;
$openAjax	= "";
//--
	while($row_relTipo = mysqli_fetch_assoc($relTipo)){
	 $cd = $row_relTipo['bbh_tip_codigo'];
	//--
	?>
	<?php if($tipoAgora != $cd){ ?>
    <?php if($tipoAgora>0){ ?>
    	<div style="border-bottom:#000 solid 1px; font-size:1px;">&nbsp;</div>
    <?php } ?>
    <table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin:3px;<?php echo $tipoAgora>0? "margin-top:20px;" : ""; ?>" class="verdana_12">
      <tr>
        <td style="font-weight:bold" align="left"><img src="/servicos/bbhive/images/arrow_right.gif" alt="" align="absmiddle" />&nbsp;<?php echo $row_relTipo['bbh_tip_nome']; ?></td>
      </tr>
    </table>
	<?php } ?>
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" class="verdana_11" bgcolor="#E6E6E6">
    <?php 
	//--SQL baseado no tipo para descobrir as colunas
	$query_campos_detalhamento = "select * from bbh_campo_tipo_indicio tp
							 inner join bbh_campo_indicio cp on tp.bbh_cam_ind_codigo = cp.bbh_cam_ind_codigo
							  where tp.bbh_tip_codigo = $cd
							   order by tp.bbh_ordem_exibicao ASC";
    list($campos_detalhamento, $rows, $totalRows_campos_detalhamento) = executeQuery($bbhive, $database_bbhive, $query_campos_detalhamento, $initResult = false);

	$camposVisiveis = array();
	while ($row = mysqli_fetch_array($campos_detalhamento, MYSQL_ASSOC)) {
		$camposVisiveis[$row["bbh_cam_ind_nome"]] = $row["bbh_cam_ind_titulo"];
	}
	//--
	$limite 	= 3;
	$visiveis 	= array();
	//--
	foreach($camposVisiveis as $i=>$v){
	  if($i!="bbh_ind_quantidade" && $i!="bbh_ind_valor_unitario" && $i!="bbh_ind_valor_total" && $limite> 0){
		   $visiveis[] = array($i,$v); 
		   $limite--;
	  }
	}
	
	//--SQL baseado no tipo para descobrir os dados
	$query_relDados = "select tp.bbh_tip_nome, i.*
						 from bbh_indicio as i 
						  inner join bbh_tipo_indicio as tp on i.bbh_tip_codigo = tp.bbh_tip_codigo
						  where i.bbh_pro_codigo=$bbh_pro_codigo and i.bbh_tip_codigo=$cd
						    order by i.bbh_tip_codigo, i.bbh_ind_codigo asc";
    list($relDados, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relDados, $initResult = false);
	//--
	$limite = 3;
	if($tipoAgora != $row_relTipo['bbh_tip_codigo']){ ?>
      <tr>
        <?php foreach($visiveis as $i=>$v){ ?>
        	<td width="15%" height="22" bgcolor="#F5F5F5"><strong><?php echo $v[1]; ?></strong></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
        	<td width="13%" align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_quantidade"]; ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
        	<td width="14%" align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_unitario"]; ?> (R$)</strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
        	<td width="14%" align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_total"]; ?> (R$)</strong></td>
        <?php } ?>
        <td width="1%" bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
    <?php } ?>
    <?php 
	while($row_relDados = mysqli_fetch_assoc($relDados)){
		$tem = true;
		$vrUnitario = $row_relDados['bbh_ind_valor_unitario'];
		$vrTotal 	= $row_relDados['bbh_ind_valor_total'];
		$Qtd 		= $row_relDados['bbh_ind_quantidade'];
		$codigoItem = $row_relDados['bbh_ind_codigo'];
		//--
		$vrUniTot+= $vrUnitario;
		$vrTotTot+= $vrTotal;
		$QtdTot+= $Qtd;
		$total_ind++;
		//--
		$limite = 3;
		$colspan= 0;
		//--Inteligência para abrir dinamicamente
		$openAjax.="OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/includes/detalheIndicio.php','item_".$codigoItem."','?item=".$codigoItem."','Aguarde...','item_".$codigoItem."','2','2');";
	  ?>
      <tr>

        <?php foreach($visiveis as $i=>$v){ $colspan++; ?>
        	<td width="15%" height="22" bgcolor="#FFFFFF"><?php echo $row_relDados[$v[0]]; ?></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){ $colspan++; ?>
        	<td width="13%" align="center" bgcolor="#FFFFFF"><?php echo !empty($Qtd) ? $Qtd : 0; ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){ $colspan++; ?>
        	<td width="14%" align="right" bgcolor="#FFFFFF"><?php echo real($vrUnitario); ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){ $colspan++; ?>
        	<td width="14%" align="right" bgcolor="#FFFFFF"><?php echo real($vrTotal); ?></td>
        <?php } ?>
        <td width="1%" align="center" bgcolor="#FFFFFF">
        <?php $colspan++; ?>
        <a href="#@" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/includes/detalheIndicio.php','item_<?php echo $codigoItem; ?>','?item=<?php echo $codigoItem; ?>','Aguarde...','item_<?php echo $codigoItem; ?>','2','2')"><img src="/corporativo/servicos/bbhive/images/mais_detalhe.gif" alt="Clique para visualizar todos os detalhes deste item" title="Clique para visualizar todos os detalhes deste item" border="0" align="absmiddle" /></a>
        </td>
      </tr>
      <tr>
        <td width="15%" colspan="<?php echo $colspan; ?>" height="1" bgcolor="#FFFFFF" id="item_<?php echo $codigoItem; ?>"></td>
      </tr>
    <?php } ?>  
    <?php if($tem == true){?>
      <tr>
        <?php foreach($visiveis as $i=>$v){ ?>
        	<td width="15%" height="22" bgcolor="#F5F5F5">&nbsp;</td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
        	<td width="13%" align="center" bgcolor="#F5F5F5"><strong><?php echo ($QtdTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
        	<td width="14%" align="right" bgcolor="#F5F5F5"><strong><?php echo real($vrUniTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
        	<td width="14%" align="right" bgcolor="#F5F5F5"><strong><?php echo real($vrTotTot); ?></strong></td>
        <?php } ?>
        <td width="1%" bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
    <?php } ?>  
    </table>
<?php  	$tipoAgora 	= $cd;
		$tem 		= false;
		$vrUniTot 	= 0;
		$vrTotTot 	= 0;
		$QtdTot 	= 0;
	} ?>
	<div style="border-bottom:#000 solid 1px; font-size:1px;">&nbsp;</div>
	<br />
    </td>
  </tr>
<?php if($totalRows_relTipo==0){?>
  <tr>
    <td height="20" align="center" class="legandaLabel11" style="color:#090">Não existem registros cadastrados</td>
  </tr>
<?php } ?>
</table>
<var style="display:none">document.getElementById('totInd').innerHTML='<?php echo $total_ind; ?>';</var>
<var style="display:none"><?php //echo $openAjax; ?></var>