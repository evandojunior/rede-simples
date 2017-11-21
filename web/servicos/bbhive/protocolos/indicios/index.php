<?php
//Indicios deste protocolo
	$query_relTipo = "select *
						 from bbh_indicio as i 
						  inner join bbh_tipo_indicio as tp on i.bbh_tip_codigo = tp.bbh_tip_codigo
						  where i.bbh_pro_codigo=".$_SESSION['idProtocolo']."
						   group by tp.bbh_tip_codigo
						    order by i.bbh_tip_codigo, i.bbh_ind_codigo asc";
    list($relTipo, $rows, $totalRows_relTipo) = executeQuery($bbhive, $database_bbhive, $query_relTipo, $initResult = false);

 if(isset($cabecalhoInd) && ($cabecalhoInd==false)){	
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="4" background="/servicos/bbhive/images/back_top.gif" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;" class="legandaLabel11">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['componentesNome']; ?> cadastrados</strong></td>
  </tr>
</table>
<?php } ?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#cccccc solid 1px;">
  <tr>
    <td width="566" height="22">
   <?php
//--
$vrUniTot 	= 0;
$vrTotTot 	= 0;
$QtdTot 	= 0;
$tipoAgora	= 0;
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
						  where i.bbh_pro_codigo=".$_SESSION['idProtocolo']." and i.bbh_tip_codigo=$cd
						    order by i.bbh_tip_codigo, i.bbh_ind_codigo asc";
    list($relDados, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relDados, $initResult = false);
	//--
	$limite = 3;
	if($tipoAgora != $row_relTipo['bbh_tip_codigo']){ ?>
      <tr>
        <?php foreach($visiveis as $i=>$v){ ?>
        	<td width="15%" height="22" valign="top" bgcolor="#F5F5F5"><strong><?php echo $v[1]; ?></strong></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
       	  <td width="13%" align="center" valign="top" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_quantidade"]; ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
       	  <td width="14%" align="center" valign="top" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_unitario"]; ?> (R$)</strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
       	  <td width="14%" align="center" valign="top" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_total"]; ?> (R$)</strong></td>
        <?php } ?>
        <td width="1%" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
      </tr>
    <?php } ?>
    <?php while($row_relDados = mysqli_fetch_assoc($relDados)){
		$tem = true;
		$vrUnitario = $row_relDados['bbh_ind_valor_unitario'];
		$vrTotal 	= $row_relDados['bbh_ind_valor_total'];
		$Qtd 		= $row_relDados['bbh_ind_quantidade'];
		$codigoItem = $row_relDados['bbh_ind_codigo'];
		//--
		$vrUniTot+= $vrUnitario;
		$vrTotTot+= $vrTotal;
		$QtdTot+= $Qtd;
		//--
		$limite = 3;
		$colspan= 0;
		
		if(!isset($formulario)) {
			//--Inteligência para abrir dinamicamente
			$openAjax.="OpenAjaxPostCmd('/servicos/bbhive/protocolos/indicios/detalheIndicio.php','item_".$codigoItem."','?item=".$codigoItem."&noIco=true','Aguarde...','item_".$codigoItem."','2','2');";
			//echo "<var style='sdisplay:none;'>$openAjax</var>";
		}
	  ?>
      <tr>

        <?php foreach($visiveis as $i=>$v){ $colspan++; ?>
        	<td width="15%" height="22" valign="top" bgcolor="#FFFFFF"><?php echo $row_relDados[$v[0]]; ?></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){ $colspan++;?>
       	  <td width="13%" align="center" valign="top" bgcolor="#FFFFFF"><?php echo !empty($Qtd) ? $Qtd : 0; ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){ $colspan++;?>
       	  <td width="14%" align="right" valign="top" bgcolor="#FFFFFF"><?php echo real($vrUnitario); ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){ $colspan++;?>
       	  <td width="14%" align="right" valign="top" bgcolor="#FFFFFF"><?php echo real($vrTotal); ?></td>
        <?php } $colspan++; ?>
        <td width="1%" align="center" valign="top" bgcolor="#FFFFFF">
        <?php if(isset($formulario)) {?>
        <img src='/corporativo/servicos/bbhive/images/excluir.gif' alt='Excluir registro' width='17' height='17' border='0' onClick="if(confirm('Tem certeza que deseja remover este registro? Após a exclusão o mesmo não poderá ser recuperado.\nClique em OK em caso de confirmação.')){document.removeRegistro.bbh_ind_codigo.value='<?php echo $row_relDados['bbh_ind_codigo']; ?>'; <?php echo $remove;//esta variável esta no arquivo que inclui este ?>;}" style="cursor:pointer">&nbsp;
		
        <?php } else { echo "&nbsp;"; } ?>
        
        <?PHP
		if( !isset($impressao) ){
		?>
        <a href="#@" onclick="OpenAjaxPostCmd('/servicos/bbhive/protocolos/indicios/detalheIndicio.php','item_<?php echo $codigoItem; ?>','?item=<?php echo $codigoItem; ?>','Aguarde...','item_<?php echo $codigoItem; ?>','2','2')">
        <img src="/corporativo/servicos/bbhive/images/mais_detalhe.gif" alt="Clique para visualizar todos os detalhes deste item" title="Clique para visualizar todos os detalhes deste item" border="0" align="absmiddle" />
        </a>
        <?PHP
		}
		?>
        </td>
      </tr>
      <tr>
        <td width="15%" height="1" colspan="<?php echo $colspan; ?>" valign="top" bgcolor="#FFFFFF" id="item_<?php echo $codigoItem; ?>"></td>
      </tr>
    <?php } ?>  
    <?php if($tem == true){?>
      <tr>
        <?php foreach($visiveis as $i=>$v){ ?>
        	<td width="15%" height="22" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
       	  <td width="13%" align="center" valign="top" bgcolor="#F5F5F5"><strong><?php echo ($QtdTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
       	  <td width="14%" align="right" valign="top" bgcolor="#F5F5F5"><strong><?php echo real($vrUniTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
       	  <td width="14%" align="right" valign="top" bgcolor="#F5F5F5"><strong><?php echo real($vrTotTot); ?></strong></td>
        <?php } ?>
        <td width="1%" valign="top" bgcolor="#F5F5F5">&nbsp;</td>
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
<?php if(isset($formulario)) {?>
  <tr>
    <td height="30" align="right" valign="bottom" class="legandaLabel11"><input name="cadastrar" style="background:url(/corporativo/servicos/bbhive/images/05_.gif);background-repeat:no-repeat;background-position:left;height:23px;width:100px;cursor:pointer;background-color:#FFFFFF; margin:2px;" type="button" class="back_input" id="cadastrar2" value="&nbsp;Prosseguir" onclick="LoadSimultaneo('protocolos/cadastro/passo2.php?naoCadastroIndicios=true','conteudoGeral');"/></td>
  </tr>
<?php } ?>
</table>

<?php /*if($_SERVER['PHP_SELF']=="/servicos/bbhive/protocolos/imprime/imprimir.php"){ ?>
<var style="display:none"><?php echo $openAjax; ?></var>
<script type="text/javascript"><?php echo $openAjax; ?></script>
<?php }*/ ?>