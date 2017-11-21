<?php
require_once("busca_dados.php");

$Nome = '&nbsp;<input name="bbh_usu_nome" type="text" maxlength="255" class="formulario2" id="bbh_usu_nome" size="55" value="'.$row_dados['bbh_usu_nome'].'" />';

$Apelido = '&nbsp;<input name="bbh_usu_apelido" type="text" maxlength="255" class="formulario2" id="bbh_usu_apelido" size="55" value="'.$row_dados['bbh_usu_apelido'].'" />';

$m="";
$f="";
	if($row_dados['bbh_usu_sexo']==1){
		$m = " checked='checked'";
	} else {
		$f = " checked='checked'";
	}
$Sexo = '&nbsp; <label><input type="radio" name="bbh_usu_sexoE" value="0" id="bbh_usu_sexo_0" '.$f.' onClick="return populaHiden(0);"/> Feminino</label> <label><input type="radio" name="bbh_usu_sexoE" value="1" id="bbh_usu_sexo_1" '.$m.'  onClick="return populaHiden(1);"/> Masculino</label>';

$TelComercial = '&nbsp;<input name="bbh_usu_tel_comercial" type="text" size="37" maxlength="255" class="formulario2" id="bbh_usu_tel_comercial" size="55" value="'.$row_dados['bbh_usu_tel_comercial'].'" />';

$TelResidencial = '&nbsp;<input name="bbh_usu_tel_residencial" type="text" size="37" maxlength="255" class="formulario2" id="bbh_usu_tel_residencial" size="55" value="'.$row_dados['bbh_usu_tel_residencial'].'" />';

$Celular = '&nbsp;<input name="bbh_usu_tel_celular" type="text" size="37" maxlength="255" class="formulario2" id="bbh_usu_tel_celular" size="55" value="'.$row_dados['bbh_usu_tel_celular'].'" />';

$TelRecado = '&nbsp;<input name="bbh_usu_tel_recados" type="text" size="37" maxlength="255" class="formulario2" id="bbh_usu_tel_recados" size="55" value="'.$row_dados['bbh_usu_tel_recados'].'" />';

$Fax = '&nbsp;<input name="bbh_usu_fax" type="text" size="37" maxlength="255" class="formulario2" id="bbh_usu_fax" size="55" value="'.$row_dados['bbh_usu_fax'].'" />';

$EmailAlternativo = '&nbsp;<input name="bbh_usu_email_alternativo" type="text" size="45" maxlength="255" class="formulario2" id="bbh_usu_email_alternativo" size="55" value="'.$row_dados['bbh_usu_email_alternativo'].'" />';

$Endereco = '&nbsp;<input name="bbh_usu_endereco" type="text" maxlength="255" class="formulario2" id="bbh_usu_endereco" size="55" value="'.$row_dados['bbh_usu_endereco'].'" />';

$Cidade = '&nbsp;<input name="bbh_usu_cidade" size="30" maxlength="255" type="text" class="formulario2" id="bbh_usu_cidade" size="55" value="'.$row_dados['bbh_usu_cidade'].'" />';

//seleção de estado
$AC=""; $AL =""; $AM=""; $AP=""; $BA=""; $CE=""; $DF=""; $ES=""; $GO=""; $MA=""; $MG=""; $MS=""; $MT=""; $PA=""; $PB=""; $PE=""; $PI=""; $PR=""; $RJ=""; $RN=""; $RO=""; $RR=""; $RS=""; $SC=""; $SE=""; $SP=""; $RR=""; $TO="";  
				
			switch($row_dados['bbh_usu_estado']){
				case "AC" : $AC = "selected=\"selected\""; break;
				case "AL" : $AL = "selected=\"selected\""; break;
				case "AM" : $AM = "selected=\"selected\""; break;
				case "AP" : $AP = "selected=\"selected\""; break;
				case "BA" : $BA = "selected=\"selected\""; break;
				case "CE" : $CE = "selected=\"selected\""; break;
				case "DF" : $DF = "selected=\"selected\""; break;
				case "ES" : $ES = "selected=\"selected\""; break;
				case "GO" : $GO = "selected=\"selected\""; break;
				case "MA" : $MA = "selected=\"selected\""; break;
				case "MG" : $MG = "selected=\"selected\""; break;
				case "MS" : $MS = "selected=\"selected\""; break;
				case "MT" : $MT = "selected=\"selected\""; break;
				case "PA" : $PA = "selected=\"selected\""; break;
				case "PB" : $PB = "selected=\"selected\""; break;
				case "PE" : $PE = "selected=\"selected\""; break;
				case "PI" : $PI = "selected=\"selected\""; break;
				case "PR" : $PR = "selected=\"selected\""; break;
				case "RJ" : $RJ = "selected=\"selected\""; break;
				case "RN" : $RN = "selected=\"selected\""; break;
				case "RO" : $RO = "selected=\"selected\""; break;
				case "RR" : $RR = "selected=\"selected\""; break;
				case "RS" : $RS = "selected=\"selected\""; break;
				case "SC" : $SC = "selected=\"selected\""; break;
				case "SE" : $SE = "selected=\"selected\""; break;
				case "SP" : $SP = "selected=\"selected\""; break;
				case "RR" : $RR = "selected=\"selected\""; break;
				case "TO" : $TO = "selected=\"selected\""; break;
			}

//fim de seleção de estado	
/*
$Estado = '&nbsp;<select name="bbh_usu_estado" class="formulario2" id="bbh_usu_estado">
                                <option value="AC" '.$AC.'>AC</option>
                                <option value="AL" '.$AL.'>AL</option>
                                <option value="AM" '.$AM.'>AM</option>
                                <option value="AP" '.$AP.'>AP</option>
                                <option value="BA" '.$BA.'>BA</option>
                                <option value="CE" '.$CE.'>CE</option>
                                <option value="DF" '.$DF.'>DF</option>
                                <option value="ES" '.$ES.'>ES</option>
                                <option value="GO" '.$GO.'>GO</option>
                                <option value="MA" '.$MA.'>MA</option>
                                <option value="MG" '.$MG.'>MG</option>
                                <option value="MS" '.$MS.'>MS</option>
                                <option value="MT" '.$MT.'>MT</option>
                                <option value="PA" '.$PA.'>PA</option>
                                <option value="PB" '.$PB.'>PB</option>
                                <option value="PE" '.$PE.'>PE</option>
                                <option value="PI" '.$PI.'>PI</option>
                                <option value="PR" '.$PR.'>PR</option>
                                <option value="RJ" '.$RJ.'>RJ</option>
                                <option value="RN" '.$RN.'>RN</option>
                                <option value="RO" '.$RO.'>RO</option>
                                <option value="RR" '.$RR.'>RR</option>
                                <option value="RS" '.$RS.'>RS</option>
                                <option value="SC" '.$SC.'>SC</option>
                                <option value="SE" '.$SE.'>SE</option>
                                <option value="SP" '.$SP.'>SP</option>
                                <option value="TO" '.$TO.'>TO</option>
                              </select>';
*/
$Estado = '&nbsp;<select name="bbh_usu_estado" class="formulario2" id="bbh_usu_estado"><option value="AC" '.$AC.'>AC</option><option value="AL" '.$AL.'>AL</option><option value="AM" '.$AM.'>AM</option><option value="AP" '.$AP.'>AP</option><option value="BA" '.$BA.'>BA</option><option value="CE" '.$CE.'>CE</option><option value="DF" '.$DF.'>DF</option><option value="ES" '.$ES.'>ES</option><option value="GO" '.$GO.'>GO</option><option value="MA" '.$MA.'>MA</option><option value="MG" '.$MG.'>MG</option><option value="MS" '.$MS.'>MS</option><option value="MT" '.$MT.'>MT</option><option value="PA" '.$PA.'>PA</option><option value="PB" '.$PB.'>PB</option><option value="PE" '.$PE.'>PE</option><option value="PI" '.$PI.'>PI</option><option value="PR" '.$PR.'>PR</option><option value="RJ" '.$RJ.'>RJ</option><option value="RN" '.$RN.'>RN</option><option value="RO" '.$RO.'>RO</option><option value="RR" '.$RR.'>RR</option><option value="RS" '.$RS.'>RS</option><option value="SC" '.$SC.'>SC</option><option value="SE" '.$SE.'>SE</option><option value="SP" '.$SP.'>SP</option><option value="TO" '.$TO.'>TO</option></select>';

$CEP = '&nbsp;<input name="bbh_usu_cep" type="text" size="15" maxlength="15" class="formulario2" id="bbh_usu_cep" size="55" value="'.$row_dados['bbh_usu_cep'].'" />';

$Pais = '&nbsp;<input name="bbh_usu_pais" type="text" size="30" maxlength="255" class="formulario2" id="bbh_usu_pais" size="55" value="'.$row_dados['bbh_usu_pais'].'" />';
?>
<var style="display:none">txtSimples('bbh_usu_nome', '<?php echo $Nome; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_apelido', '<?php echo $Apelido; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_sexo', '<?php echo $Sexo; ?>')</var>
<var style="display:none">document.getElementById("sexo").value=<?php echo $row_dados['bbh_usu_sexo']; ?></var>
<var style="display:none">txtSimples('bbh_usu_tel_comercial', '<?php echo $TelComercial; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_residencial', '<?php echo $TelResidencial; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_celular', '<?php echo $Celular; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_tel_recados', '<?php echo $TelRecado; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_fax', '<?php echo $Fax; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_email_alternativo', '<?php echo $EmailAlternativo; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_endereco', '<?php echo $Endereco; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_cidade', '<?php echo $Cidade; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_cep', '<?php echo $CEP; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_estado', '<?php echo $Estado; ?>')</var>
<var style="display:none">txtSimples('bbh_usu_pais', '<?php echo $Pais; ?>')</var>
<var style="display:none">document.getElementById('btnEditar').style.display="none"</var>
<var style="display:none">document.getElementById('btnSalvar').style.display="block"</var>
<var style="display:none">document.getElementById('btnCancelar').style.display="block"</var>