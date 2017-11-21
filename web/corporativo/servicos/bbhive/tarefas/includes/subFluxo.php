<?php 
//exibe informação na parte de decisões de tarefas

	/*$titulo = '';
	$filho	= '';*/
if(!isset($_SESSION)){ session_start(); }
if((getCurrentPage()!="/corporativo/servicos/bbhive/fluxo/index.php")&&(getCurrentPage()!="/corporativo/servicos/bbhive/tarefas/index.php")){
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
	
	$titulo = $_GET['titulo'];
	$filho	= $_GET['filho'];
}

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;bbh_mod_flu_codigo")||($indice=="bbh_mod_flu_codigo")){ $bbh_mod_flu_codigo=$valor; }
		if(($indice=="amp;titulo")||($indice=="titulo")){ $titulo=$valor; }
		if(($indice=="amp;filho")||($indice=="filho")){ $filho=$valor; }
	}

$query_Sub = "select 
bbh_flu_alt_codigo, bbh_flu_alt_titulo, bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_flu_alt_icone, 
bbh_fluxo_alternativa.bbh_mod_flu_codigo, bbh_fluxo_alternativa.bbh_mod_ati_ordem, bbh_tip_flu_codigo, bbh_mod_ati_nome , bbh_mod_ati_icone

 from bbh_fluxo_alternativa
      left join bbh_modelo_fluxo on bbh_fluxo_alternativa.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
          inner join bbh_modelo_atividade on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_modelo_atividade.bbh_mod_flu_codigo
          
               Where bbh_modelo_fluxo.bbh_mod_flu_codigo = ".$bbh_mod_flu_codigo." and bbh_modelo_atividade.bbh_mod_ati_ordem>=bbh_fluxo_alternativa.bbh_mod_ati_ordem
               
                    group by bbh_modelo_atividade.bbh_mod_ati_codigo
					
						order by bbh_modelo_atividade.bbh_mod_ati_ordem asc
					";
list($Sub, $row_Sub, $totalRows_Sub) = executeQuery($bbhive, $database_bbhive, $query_Sub);

?>
<table width="98%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FDF7EE" class="verdana_11">
  <tr>
    <td height="26" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg">
    <label class="color"><strong>Decis&otilde;es da alternativa - <?php echo $titulo; ?></strong></label>
    <label style="float:right; ">
    	<a href="#" onClick="javascript: eval(document.getElementById('<?php echo $filho; ?>').innerHTML='');">
        	<img src="/corporativo/servicos/bbhive/images/fecharII.gif" align="absmiddle" border="0" />
        </a>
    </label>
    </td>
  </tr>
<?php do{ 
	$Icone = '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$row_Sub['bbh_mod_ati_icone'].'" border="0" align="absmiddle" />';
	
	$codModAti = $row_Sub['bbh_mod_ati_codigo'];
	//verifica se tem alternativas
	$query_Alternativas = "select bbh_flu_alt_codigo, bbh_mod_flu_codigo from bbh_fluxo_alternativa Where bbh_mod_ati_codigo=$codModAti and bbh_mod_flu_codigo<>'NULL'";
    list($Alternativas, $row_Alternativas, $totalRows_Alternativas) = executeQuery($bbhive, $database_bbhive, $query_Alternativas);
	
	if($totalRows_Alternativas>0){
		$TimeStamp 			= time();
		$homeDestino		= '/corporativo/servicos/bbhive/tarefas/includes/subFluxo.php?Ts='.$TimeStamp."&filho=sub_".time().'_'.$row_Sub['bbh_mod_ati_codigo']."&titulo=".$row_Sub['bbh_mod_ati_nome']."&bbh_mod_flu_codigo=".$row_Sub['bbh_mod_flu_codigo'];
		$idMensagemFinal 	= 'sub_'.time().'_'.$row_Sub['bbh_mod_ati_codigo'];
		$infoGet_Post		= '&bbh_mod_flu_codigo='.$row_Sub['bbh_mod_flu_codigo'];//Se envio for POST, colocar nome do formulário
		$Mensagem			= "Carregando...";
		$idResultado		= $idMensagemFinal;
		$Metodo				= '2';//1-POST, 2-GET
		$TpMens				= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
		
		$onClick 			= "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
		
		$linkComplemento 	= "<a href='#sub_".time().'_'.$row_Sub['bbh_mod_ati_codigo']."' onClick=\"".$onClick."\" title='Clique para vizualizar o subfluxo'>$Icone</a>";
		$Icone				= $linkComplemento;
	}
?>  
  <tr>
    <td width="96%" height="26"align="left">&nbsp;<?php echo $Icone; ?>&nbsp;<img src="/corporativo/servicos/bbhive/images/setaIII.gif" align="absmiddle" /> <?php echo $row_Sub['bbh_mod_ati_nome']; ?></td>
  </tr>
  <tr>
    <td height="1" colspan="3" id="sub_<?php echo time()."_".$row_Sub['bbh_mod_ati_codigo']; ?>" align="right"></td>
  </tr>
  <tr>
    <td height="1" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
<?php } while ($row_Sub = mysqli_fetch_assoc($Sub)); ?>
</table><br>
