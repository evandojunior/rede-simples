<?php
if(!isset($_SESSION)){ session_start(); }
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

 	//recuperação de variáveis do GET e SESSÃO
  	foreach($_GET as $indice => $valor){
		
		// Indice
		$nome = str_replace("amp;","", $indice);
		
		// Valor
		$_GET[$nome] = $valor;
		

		if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
	}
		
//Indicios deste protocolo
 	$query_relTipo = "select tp.bbh_tip_nome, tp.bbh_tip_codigo, i.bbh_pro_codigo
						 from bbh_indicio as i 
						  inner join bbh_tipo_indicio as tp on i.bbh_tip_codigo = tp.bbh_tip_codigo
						  inner join bbh_protocolos as p on i.bbh_pro_codigo = p.bbh_pro_codigo
						  where p.bbh_flu_codigo=$bbh_flu_codigo
						   group by tp.bbh_tip_codigo
						    order by i.bbh_tip_codigo, i.bbh_ind_codigo asc";
	$query_relTipo = "
	SELECT tp.bbh_tip_nome, tp.bbh_tip_codigo, i.bbh_pro_codigo, p.*,
	(
	  select count(i.bbh_pro_codigo) from bbh_indicio i where i.bbh_pro_codigo = p.bbh_pro_codigo
	 ) as total
	FROM bbh_indicio AS i
	INNER JOIN bbh_tipo_indicio AS tp ON i.bbh_tip_codigo = tp.bbh_tip_codigo
	INNER JOIN bbh_protocolos AS p ON i.bbh_pro_codigo = p.bbh_pro_codigo
	WHERE p.bbh_flu_codigo=$bbh_flu_codigo
	GROUP BY tp.bbh_tip_codigo
	#ORDER BY i.bbh_tip_codigo, i.bbh_ind_codigo ASC
	#GROUP BY p.bbh_pro_codigo
	ORDER BY p.bbh_pro_codigo, i.bbh_ind_codigo ASC
	";
    list($relTipo, $rows, $totalRows_relTipo) = executeQuery($bbhive, $database_bbhive, $query_relTipo, $initResult = false);
?>


<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="4" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg" class="legandaLabel12">
    &nbsp;
    <img src="/corporativo/servicos/bbhive/images/caixa.gif" border="0" align="absmiddle" />
    &nbsp;
    <strong>(<label id="totInd"><?php echo $totalRows_relTipo; ?></label>
    ) <?PHP echo strtolower($_SESSION['componentesNome']); ?>(s) cadastrado(s)</strong></td>
  </tr>
</table>
<div style="padding-left:10px;padding-top:10px;">
<form name="novoIndicioFluxo" id="novoIndicioFluxo" style="margin-top:5px;width:98%; align:center;" onsubmit="return false;">
<strong>Novo <?PHP echo strtolower($_SESSION['componentesNome']); ?>:</strong>
<?PHP
$adicional = "";
if( isset($_GET['tarefas'] ) ) $adicional = "tarefas=true&bbh_ati_codigo=".$_GET['bbh_ati_codigo']."&";
?>
<select name="bbh_pro_codigo" style="width:200px;" onchange='if(this.value!="0") OpenAjaxPostCmd("/corporativo/servicos/bbhive/fluxo/indicios/cadastrar.php?<?PHP echo $adicional; ?>","novoindicio",this.value,"Aguarde...","loadMsg","2","2");'>
    <option value="bbh_pro_codigo=0" selected>Selecione o protocolo</option>
    <?PHP
    $query_relProtocolos = "
    SELECT 
        bbh_pro_codigo, bbh_pro_titulo
                        
    FROM 
        bbh_protocolos 
    
    WHERE
        bbh_flu_codigo=$bbh_flu_codigo
    
    ORDER BY bbh_pro_titulo ASC";
    list($relProtocolo, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_relProtocolos, $initResult = false);
    
    while( $fetch = mysqli_fetch_assoc($relProtocolo) )
    {
        $selected = '';
        $option = sprintf("<option value='bbh_pro_codigo=%s'%s>%s</option>", $fetch['bbh_pro_codigo'], $selected, $fetch['bbh_pro_titulo']);
        echo $option;
    }
    ?>
    </select>
</form>
</div>
<div id="loadMsg">&nbsp;</div>
<div id="novoindicio">&nbsp;</div>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#cccccc solid 1px;">
  <tr>
    <td  height="22">
   <?php
//--
$vrUniTot 	= 0;
$vrTotTot 	= 0;
$QtdTot 	= 0;
$tipoAgora	= 0;
$total_ind	= 0;
$openAjax	= "";
$protocoloAnterior = '';
//--
	while($row_relTipo = mysqli_fetch_assoc($relTipo)){
	 $cd 			= $row_relTipo['bbh_tip_codigo'];
	 $bbh_pro_codigo= $row_relTipo['bbh_pro_codigo'];
	//--
	?>
    
    <?PHP
	if($row_relTipo['bbh_pro_codigo'] != $protocoloAnterior ){
	$espacamento = $protocoloAnterior!=""? "margin-top:20px;" : "";
	$protocoloAnterior = $row_relTipo['bbh_pro_codigo'];
	$tipoAgora = 0;
	?>
    <table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin:3px;<?php echo $espacamento; ?>" class="verdana_12">
      <!--tr>
        <td style="font-weight:bold" align="left"><img src="/servicos/bbhive/images/arrow_right.gif" alt="" align="absmiddle" />&nbsp;<?php echo $row_relTipo['bbh_pro_titulo']; ?></td>
      </tr-->
<tr>
    <td width="55" height="25" align="left" bgcolor="#F0F0F0"><strong>&nbsp;N.&ordm;</strong></td>
    <td width="164" align="left" bgcolor="#F0F0F0"><strong><?php echo ($_SESSION['ProtOfiNome']);?></strong></td>
    <td width="197" align="left" bgcolor="#F0F0F0"><strong><?php echo($_SESSION['ProtSolNome']);?></strong></td>
    <td width="115" align="left" bgcolor="#F0F0F0"><strong>Criado em</strong></td>
    <td colspan="3" align="center" bgcolor="#F0F0F0">&nbsp;</td>
</tr>
    <?PHP
    //--
	$codProtocolo = $row_relTipo['bbh_pro_codigo'];
	//status com base no vetor
	$codSta		= $row_relTipo['bbh_pro_status'];
	$cada	 	= explode("|",$status[$codSta]);
	$situacao 	= $cada[0];
	$corFundo 	= $cada[1];
	//--
	$corFonte	= $row_relTipo['bbh_pro_flagrante'] == "1" ? "#F00" : "#000";
	$situacao	= $row_relTipo['bbh_pro_flagrante'] == "1" ? "Flagrante - ".$situacao : $situacao;
	//--	
	//		if($p == 0 && $row_Fluxo['bbh_flu_finalizado']=='1'){//recupero informações do primeiro protocolo
		if(!isset($bbh_pro_codigoInd)){
			if($row_relTipo['bbh_flu_codigo'] == $bbh_flu_codigo){//recupero informações do protocolo
				$nv_bbh_pro_flagrante 		= $row_relTipo['bbh_pro_flagrante'];
				$nv_bbh_pro_identificacao 	= $row_relTipo['bbh_pro_identificacao'];
				$nv_bbh_pro_autoridade 		= $row_relTipo['bbh_pro_autoridade'];
				$nv_bbh_pro_titulo 			= $row_relTipo['bbh_pro_titulo'];
				$nv_bbh_pro_data 			= arrumadata($row_relTipo['bbh_pro_data']);
				$nv_bbh_pro_descricao 		= $row_relTipo['bbh_pro_descricao'];
			}
		}
		
		//conta quantos arquivos tenho anexado a este protocolo
		$cont = 0;
		if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$codProtocolo."/.")) {
		
		while (false !== ($file = readdir($handle))) {
		  if ($file != "." && $file != "..") {
					$cont++; 
				if ($cont == 800) {
				die;
				}
			 }
		  }
		 closedir($handle);
		}
	?>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td rowspan="2" align="left" valign="top">&nbsp;<strong><?php echo $codProtocolo; ?></strong></td>
    <td rowspan="2" align="left" valign="top"><img src="/corporativo/servicos/bbhive/images/setaIII.gif" width="4" height="8">&nbsp;<?php echo $a=$row_relTipo['bbh_pro_titulo']; ?></td>
    <td rowspan="2" align="left" valign="top"><?php echo $a=$row_relTipo['bbh_pro_identificacao']; ?></td>
    <td rowspan="2" align="left" valign="top"><?php echo arrumadata(substr($row_relTipo['bbh_pro_momento'],0,10))." ".substr($row_relTipo['bbh_pro_momento'],11,5); ?></td>
    <td width="23" height="25" align="center">
    	<img src="/corporativo/servicos/bbhive/images/caixa.gif" border="0" align="absmiddle" />
    </td>
    <td width="23" align="center"><img src="/corporativo/servicos/bbhive/images/clipes.gif" border="0" align="absmiddle" /></td>
    <td width="21" align="center"><a href="#@"  onclick="return showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $row_relTipo['bbh_pro_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para visualizar todos os detalhes deste protocolo"><img src="/corporativo/servicos/bbhive/images/editarII.gif" alt="" width="16" height="16" border="0" align="absmiddle" /></a></td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="10" align="center" title="<?php echo $row_relTipo['total']; echo $_SESSION['componentesNome'];?>">
	    (<?php echo $row_relTipo['total']; ?>)
    </td>
    <td align="center" title="<?php echo $cont; ?> arquivos digitalizado">(<?php echo $p=$cont; ?>)</td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr title="<?php echo $situacao; ?>" style="cursor:pointer; background-color:<?php echo $corFundo; ?>;color:<?php echo $corFonte; ?>">
    <td height="2" colspan="7" align="left" valign="top" bgcolor="#FFFFFF"></td>
  </tr>
    </table>
    <?PHP
	}
	?>
    
    
	<?php if($tipoAgora != $cd){ ?>
    <?php if($tipoAgora>0){ ?>
    	<div style="border-bottom:#000 solid 1px; font-size:1px;">&nbsp;</div>
    <?php } ?>
        
    <table width="99%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin:3px;<?php echo $tipoAgora>0? "margin-top:20px;" : ""; ?>" class="verdana_12">
      <tr>
        <td style="font-weight:bold" align="left">
        <!--img src="/servicos/bbhive/images/arrow_right.gif" alt="" align="absmiddle" /-->
        &nbsp;<?php echo $row_relTipo['bbh_tip_nome']; ?></td>
      </tr>
    </table>
	<?php } ?>
    <table width="99%" border="0" align="center" cellpadding="0" cellspacing="1" class="verdana_11" bgcolor="#E6E6E6" style="display:block;">
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
        	<td height="22" bgcolor="#F5F5F5"><strong><?php echo $v[1]; ?></strong></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
        	<td  align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_quantidade"]; ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
        	<td  align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_unitario"]; ?> (R$)</strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
        	<td align="center" bgcolor="#F5F5F5"><strong><?php echo $camposVisiveis["bbh_ind_valor_total"]; ?> (R$)</strong></td>
        <?php } ?>
        <td width="1%" bgcolor="#F5F5F5">&nbsp;</td>
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
        	<td height="22" bgcolor="#FFFFFF"><?php echo $row_relDados[$v[0]]; ?></td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){ $colspan++; ?>
        	<td align="center" bgcolor="#FFFFFF"><?php echo !empty($Qtd) ? $Qtd : 0; ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){ $colspan++; ?>
        	<td align="right" bgcolor="#FFFFFF"><?php echo real($vrUnitario); ?></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){ $colspan++; ?>
        	<td align="right" bgcolor="#FFFFFF"><?php echo real($vrTotal); ?></td>
        <?php } ?>
        <td  align="center" bgcolor="#FFFFFF">
        <?php $colspan++; ?>
        <a href="javascript:void(0);" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/includes/detalheIndicio.php','item_<?php echo $codigoItem; ?>','?item=<?php echo $codigoItem; ?>','Aguarde...','item_<?php echo $codigoItem; ?>','2','2')"><img src="/corporativo/servicos/bbhive/images/mais_detalhe.gif" alt="Clique para visualizar todos os detalhes deste item" title="Clique para visualizar todos os detalhes deste item" border="0" align="absmiddle" /></a>
        </td>
        <td  align="center" bgcolor="#FFFFFF">
        <?php $colspan++; ?>
        <a href="javascript:void(0);" onclick="OpenAjaxPostCmd('/corporativo/servicos/bbhive/protocolo/includes/detalheIndicioFluxo.php','item_<?php echo $codigoItem; ?>','?item=<?php echo $codigoItem; ?>','Aguarde...','item_<?php echo $codigoItem; ?>','2','2')"><img src="/corporativo/servicos/bbhive/images/editar.gif" alt="Clique para editar todos os detalhes deste item" title="Clique para editar todos os detalhes deste item" border="0" align="absmiddle" /></a>
        </td>
      </tr>
      <tr>
        <td colspan="<?php echo $colspan; ?>" height="1" bgcolor="#FFFFFF" id="item_<?php echo $codigoItem; ?>"></td>
      </tr>
    <?php } ?>  
    <?php if($tem == true){?>
      <tr>
        <?php foreach($visiveis as $i=>$v){ ?>
        	<td height="22" bgcolor="#F5F5F5">&nbsp;</td>
		<?php } ?>
        
        <?php if(array_key_exists("bbh_ind_quantidade",$camposVisiveis)){?>
        	<td align="center" bgcolor="#F5F5F5"><strong><?php echo ($QtdTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_unitario",$camposVisiveis)){?>
        	<td align="right" bgcolor="#F5F5F5"><strong><?php echo real($vrUniTot); ?></strong></td>
        <?php } ?>
        <?php if(array_key_exists("bbh_ind_valor_total",$camposVisiveis)){?>
        	<td align="right" bgcolor="#F5F5F5"><strong><?php echo real($vrTotTot); ?></strong></td>
        <?php } ?>
        <td width="1%" bgcolor="#F5F5F5">&nbsp;</td>
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