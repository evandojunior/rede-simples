<?php
//CAMPOS DE DETALHAMENTO
	$query_Campos = "select 
					 bbh_cam_det_flu_codigo,
					 bbh_cam_det_flu_nome,
					 bbh_cam_det_flu_titulo,
					 bbh_cam_det_flu_tipo,
					 bbh_cam_det_flu_tamanho
					 from bbh_detalhamento_fluxo 
					 inner join bbh_campo_detalhamento_fluxo on bbh_detalhamento_fluxo.bbh_det_flu_codigo = bbh_campo_detalhamento_fluxo.bbh_det_flu_codigo
					  Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'];
    list($Campos, $rows, $totalRows_Campos) = executeQuery($bbhive, $database_bbhive, $query_Campos, $initResult = false);
//======================

	function comboComparacao($CodigoCampo){
			return	"<select name='condicao_$CodigoCampo' id='condicao_$CodigoCampo' class='verdana_9'>
							  <option value='='>=</option>
							  <option value='&lt;'>&lt;</option>
							  <option value='&gt;'>&gt;</option>
							  <option value='&lt;&gt;'>&lt;&gt;</option>
							  <option value='inicio'>inicie com</option>
							  <option value='fim'>termine com</option>
							  <option value='contenha'>contenha</option>
					</select>";
	}
	
	function combo($CodigoCampo, $inicio, $fim, $atual){
		$combo ="<select name='$CodigoCampo' class='verdana_11' id='$CodigoCampo'>";
			for($a=$inicio; $a<$fim; $a++){
				$selected 	= $a == $atual ? "selected" : "";
				$a 			= $a < 10 ? "0".$a : $a;
				
				$combo.= "<option value='$a' $selected>$a</option>";
			}
		return 	$combo.= "</select>";
	}
	function comboData($CodigoCampo, $dataHora){
		$html = "<label>&nbsp;<strong>Inicio :</strong><br>";
		//Monta Dia
		$html.= combo("dia_inicial_".$CodigoCampo, 1, 32, date('d')) . " / ";
		//Monta Mês
		$html.= combo("mes_inicial_".$CodigoCampo, 1, 13, date('m')) . " / ";
		//Monta Ano
		$html.= combo("ano_inicial_".$CodigoCampo,  date('Y')-20, date('Y')+2, date('Y'));
		
		if($dataHora == 1){
			//Monta Hora
			$html.= "&nbsp;" . combo("hora_inicial_".$CodigoCampo, 0, 24, date('H')) . " : ";
			
			//Monta Minuto
			$html.= "&nbsp;" . combo("minuto_inicial_".$CodigoCampo, 0, 60, date('i'));
		}
		
		$html.= "<br><label>&nbsp;&nbsp;<strong>Final :</strong><br>";
		//Monta Dia
		$html.= combo("dia_final_".$CodigoCampo, 1, 32, date('d')) . " / ";
		//Monta Mês
		$html.= combo("mes_final_".$CodigoCampo, 1, 13, date('m')) . " / ";
		//Monta Ano
		$html.= combo("ano_final_".$CodigoCampo,  date('Y')-20, date('Y')+2, date('Y'));
		
		if($dataHora == 1){
			//Monta Hora
			$html.= "&nbsp;" . combo("hora_final_".$CodigoCampo, 0, 24, date('H')) . " : ";
			
			//Monta Minuto
			$html.= "&nbsp;" . combo("minuto_final_".$CodigoCampo, 0, 60, date('i'));
		}
		return $html;
	}
	function InputPadrao($CodigoCampo){
		return '<input name="campo_'.$CodigoCampo.'" type="text" class="back_Campos" id="campo_'.$CodigoCampo.'" size="40">';
	}
	
	//Ação FORM
	$TimeStamp 		= time();
	$homeDestino	= '/corporativo/servicos/bbhive/consulta/avancada/detalhamento/executa.php?Ts='.$TimeStamp;
	$idMensagemFinal= 'resultBusca';
	$infoGet_Post	= 'formConsulta';//Se envio for POST, colocar nome do formulário
	$Mensagem		= "Consultando informa&ccedil;&otilde;es...";
	$idResultado	= $idMensagemFinal;//'menHistorico';
	$Metodo			= "1";//1-POST, 2-GET
	$TpMens			= "2";//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	
	$acao = "OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."');";
?><form name="formConsulta" id="formConsulta" style="margin-top:-1px;">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
   <?php while($row_Campos = mysqli_fetch_assoc($Campos)){
		   $CodigoCampo = $row_Campos['bbh_cam_det_flu_codigo'];
		   $tituloCampo	= $row_Campos['bbh_cam_det_flu_titulo'];
		   $nomeCampo	= $row_Campos['bbh_cam_det_flu_nome'];
		   $tipoCampo	= $row_Campos['bbh_cam_det_flu_tipo']; 
		   
		   $exibe = 1;
		   if($tipoCampo=="time_stamp"){
				$oInput = comboData($CodigoCampo, 1); $exibe = 0;
		   } elseif ($tipoCampo=="horario_editavel") {
				$oInput =  comboData($CodigoCampo, 0); $exibe = 0;
		   } else {
			    $oInput = InputPadrao($CodigoCampo);
		   }
   	  ?>   
      <tr>
        <td width="3%" height="23" align="center" bgcolor="#EFEFE7" class="verdana_11"><label>
          <input type="checkbox" name="chk_<?php echo $CodigoCampo; ?>" id="chk_<?php echo $CodigoCampo; ?>" onClick="if(this.checked==true){computaSelecao(1)} else {computaSelecao(-1)}" />
        </label></td>
        <td width="33%" bgcolor="#FFFFFF" class="verdana_11">&nbsp;<?php echo $tituloCampo; ?><input name="nm_campo_<?php echo $CodigoCampo; ?>" id="nm_campo_<?php echo $CodigoCampo; ?>" type="hidden" value="<?php echo $nomeCampo; ?>">
        <input name="tp_campo_<?php echo $CodigoCampo; ?>" id="tp_campo_<?php echo $CodigoCampo; ?>" type="hidden" value="<?php echo $tipoCampo; ?>">
        </td>
        <td width="16%" bgcolor="#FFFFFF" class="verdana_11">
        <?php if($exibe==0) {echo "&nbsp;";} else{?>
        	:<?php echo comboComparacao($CodigoCampo); ?>
        <?php } ?></td>
        <td width="4%" align="center" bgcolor="#FFFFFF" class="verdana_11">
        <?php if($exibe==0) {echo "&nbsp;";} else{?>
        <a href="#@" title="Consulta por dados agrupados" id="combo_<?php echo $CodigoCampo; ?>" style="display:block" onClick="javascript: montaCampoBI('combo_<?php echo $CodigoCampo; ?>', 'input_<?php echo $CodigoCampo; ?>'); consultaAgrupado('/corporativo/servicos/bbhive/consulta/avancada/detalhamento/agrupado.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_cam_det_flu_codigo=<?php echo $CodigoCampo; ?>&bbh_cam_det_flu_nome=<?php echo $nomeCampo; ?>', 'acao_<?php echo $CodigoCampo; ?>');"><img src="/corporativo/servicos/bbhive/images/combo_box.gif" width="16" height="16" border="0" align="absmiddle"></a>
        
        <a href="#@" title="Consulta por texto" id="input_<?php echo $CodigoCampo; ?>" style="display:none" onClick="javascript: montaCampoBI('input_<?php echo $CodigoCampo; ?>','combo_<?php echo $CodigoCampo; ?>'); insereInput('acao_<?php echo $CodigoCampo; ?>', 'campo_<?php echo $CodigoCampo; ?>');"><img src="/corporativo/servicos/bbhive/images/input_text.gif" width="16" height="16" border="0" align="absmiddle"></a>
		<?php } ?>        
        </td>
        <td width="44%" bgcolor="#FFFFFF" class="verdana_11" id="acao_<?php echo $CodigoCampo; ?>"><?php echo $oInput; 		?></td>
      </tr>
      <tr>
        <td height="1" colspan="5" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
	<?php } 
	if($totalRows_Campos==0){?>
      <tr>
        <td height="25" colspan="5" align="center" bgcolor="#EFEFE7">N&atilde;o h&aacute; campos neste modelo</td>
    </tr>
    <?php } ?>
      <tr>
        <td height="1" colspan="5" align="right" bgcolor="#EFEFE7"><input class="formulario2" id="web" type="button" value="Pesquisar" name="web"  style="cursor:pointer; background-image:url(/corporativo/servicos/bbhive/images/search.gif); color:#FFFFFF" onclick="if(document.getElementById('contador').value>0){<?php echo $acao; ?>} else { alert('Selecione algum item a ser pesquisado!'); }"/></td>
    </tr>
</table>
<input name="contador" id="contador" type="hidden" value="0">
<input name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" type="hidden" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>">
</form>
<div id="resultBusca">&nbsp;</div>