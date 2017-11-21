<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$SQL		= "100";
$SQLAjuste	= "";

foreach($_GET as $indice => $valor){
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $cdFluxo = $bbh_flu_codigo=$valor; }
}

foreach($_GET as $indice => $valor){
	if(($indice=="amp;caixaEntrada")||($indice=="caixaEntrada")){ 
		$caixaEntrada=$valor; 
		require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/mensagens/menu/cxEntrada.php");
	}
	
	if(($indice=="amp;caixaSaida")||($indice=="caixaSaida")){  
		$caixaSaida=$valor; 
		require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/mensagens/menu/cxSaida.php");
	}
	if(($indice=="amp;caixaLixeira")||($indice=="caixaLixeira")){ 
		$caixaLixeira=$valor;
		require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/mensagens/menu/cxLixeira.php");
		
	}
}

  require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/mensagens/menu/menu_ordem.php");
  $exibeAgrupamentoMensagem = true;
?>
<?php require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/fluxo/mensagens/menu/menu.php"); ?>
<var style="display:none">document.getElementById('ico_Mensagens').className = 'ico_Mensagens_Selecionado'</var>
<form name="frmListMessages" id="frmListMessages">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_9">
  <tr>
    <td height="20" colspan="5" align="right" style="border-bottom:1px dotted #CCCCCC"><?php if($totalRows_mensagens>0){ echo "Voc&ecirc; tem um total de <strong>".$totalRows_contadormsg."</strong> mensagens"; } ?></td>
  </tr>
<?php if($totalRows_mensagens>0){ ?>
<?php 	do {   ?>
  <tr id="linha<?php echo $row_mensagens['bbh_men_codigo'];?>" onmouseover="return Ativa('linha<?php echo $row_mensagens['bbh_men_codigo'];?>')" onmouseout="return Desativa('linha<?php echo $row_mensagens['bbh_men_codigo'];?>')" <?php if($row_mensagens['data_leitura']=="00/00/0000" || $row_mensagens['data_leitura']===NULL){	echo " style='color:#993300;'";} ?>>
    <td width="1%" height="25" style="border-bottom:1px solid #CCC;"><input name="chk_<?php echo $row_mensagens['bbh_men_codigo']; ?>" type="checkbox" id="chk_<?php echo $row_mensagens['bbh_men_codigo']; ?>" value="<?php echo $row_mensagens['bbh_men_codigo']; ?>|<?php echo $row_mensagens['cddestinatario']; ?>|<?php echo $row_mensagens['cdremetente']; ?>"/></td>
    <td width="28%" height="22" style="border-bottom:1px solid #CCC;; cursor:pointer;" onclick="return  OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/mensagens/mensagem.php?bbh_men_codigo=<?php echo $row_mensagens['bbh_men_codigo']; ?>&bbh_flu_codigo=<?php echo $cdFluxo; ?>','mensagem','&1=1','Aguarde...','mensagem','2','2');">
	<?php if(isset($caixaSaida)){echo "para: "; }
		if(strlen($row_mensagens['remetente'])>25){
        	echo $d=substr($row_mensagens['remetente'],0,22)."...";
		}else{
        	echo $d=$row_mensagens['remetente'];
		}
	?>
    </td>
    <td width="52%" style="border-bottom:1px solid #CCC; cursor:pointer;" onclick="return  OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/mensagens/mensagem.php?bbh_men_codigo=<?php echo $row_mensagens['bbh_men_codigo']; ?>&bbh_flu_codigo=<?php echo $cdFluxo; ?>','mensagem','&1=1','Aguarde...','mensagem','2','2');">
		<?php
        if(strlen($row_mensagens['assunto'])>40){
			echo $a=substr($row_mensagens['assunto'],0,37)."...";
		}else{
			echo $a=$row_mensagens['assunto'];
		}
		?>
    </td>
    <td width="19%" style="border-bottom:1px solid #CCC; cursor:pointer;" align="right" class="verdana_9_cinza" onclick="return  OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/mensagens/mensagem.php?bbh_men_codigo=<?php echo $row_mensagens['bbh_men_codigo']; ?>&bbh_flu_codigo=<?php echo $cdFluxo; ?>','mensagem','&1=1','Aguarde...','mensagem','2','2');"><?php echo $dt=$row_mensagens['momento']; ?></td>
  </tr>
 <?php } while ($row_mensagens = mysqli_fetch_assoc($mensagens)); ?>
<?php }else{ ?>
  <tr>
    <td colspan="4">N&atilde;o h&aacute; mensagens em sua caixa de entrada.</td>
  </tr>
<?php } ?>
</table>
<input name="lixo" type="hidden" id="lixo" value="0|0|0" />
    <?php if(isset($caixaLixeira)) {?>
        <input name="MM_exdefinitivo" type="hidden" id="MM_exdefinitivo" value="1" />
    <?php } else { ?>    
    	<input name="MM_exclusao" type="hidden" id="MM_exclusao" value="1" />
    <?php } ?>
    <input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $cdFluxo; ?>" />
    <input name="bbh_usu_codigo_destin" type="hidden" id="bbh_usu_codigo_destin" value="0" />
<label style="position:absolute" id="enviaMSG" class="color">&nbsp;</label>
</form>