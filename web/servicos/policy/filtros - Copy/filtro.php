<?php require_once("../includes/functions.php"); ?>
<link rel="stylesheet" type="text/css" href="../includes/policy.css">
<form name="form1" id="form1">
<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_11">
  <tr>
    <td height="25" colspan="3" background="/e-solution/servicos/policy/images/barra_horizontal.jpg"><strong>Escolha a op&ccedil;&atilde;o desejada</strong>
    
    <span class="verdana_11_bold" id="voltar" style="float:right; margin-top:-15px;"><a href='#' onclick="javascript: location.href='/e-solution/servicos/policy/detalhes/index.php?pol_apl_codigo=<?php echo $_GET['pol_apl_codigo']; ?>'">.: Voltar :.</a></span>
    </td>
  </tr>
  <tr>
    <td height="20" colspan="2" align="right"  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
    <td  style="border-bottom:dotted 1px #333333;">&nbsp;</td>
  </tr>

  <tr>
    <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
      <input type="checkbox" name="chk_quem" id="chk_quem">
    </label></td>
    <td width="14%" height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Quem :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
		<select name='condicao_quem' id='condicao_quem' class='verdana_9' style="margin-left:5px;">
          <option value='='>=</option>
          <option value='&lt;'>&lt;</option>
          <option value='&gt;'>&gt;</option>
          <option value='&lt;&gt;'>&lt;&gt;</option>
          <option value='inicio'>inicie com</option>
          <option value='fim'>termine com</option>
          <option value='contenha'>contenha</option>
	  </select>
        <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'quem', 'quemdet=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a> 
        
      <label id="quem">
       	  <input name="pol_quem" type="text" class="back_Campos" size="40">
      </label>      </td>
  </tr>
  <tr>
    <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
      <input type="checkbox" name="chk_quando" id="chk_quando">
    </label></td>
    <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Quando :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;">
<div style='margin-top:0px;; line-height:25px; margin-right:5px;'>          
	<label>&nbsp;<strong>Inicio :</strong>
	&nbsp;<input name="data_inicio" type="text" class="back_Campos" id="data_inicio" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_inicio,'dd/mm/yyyy',this)"/>
	</label>

<label>&nbsp;&nbsp;<strong>Final :</strong>&nbsp;<input name="data_fim" type="text" class="back_Campos" id="data_fim" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" onkeypress="MascaraData(event, this)" maxlength="10"/>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onclick="displayCalendar(document.form1.data_fim,'dd/mm/yyyy',this)"/>
</label>
</div>
    </td>
  </tr>
  <tr>
    <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
      <input type="checkbox" name="chk_onde" id="chk_onde">
    </label></td>
    <td height="20" align="right" bgcolor="#F7F7F7" style="border-bottom:dotted 1px #333333;"> Onde :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_onde' id='condicao_onde' class='verdana_9' style="margin-left:5px;">
        <option value='='>=</option>
        <option value='&lt;'>&lt;</option>
        <option value='&gt;'>&gt;</option>
        <option value='&lt;&gt;'>&lt;&gt;</option>
        <option value='inicio'>inicie com</option>
        <option value='fim'>termine com</option>
        <option value='contenha'>contenha</option>
      </select>
      <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'onde', 'ip=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="onde">
        	<input name="pol_onde" type="text" class="back_Campos" size="40">
        </label>    </td>
  </tr>
  <tr>
    <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
      <input type="checkbox" name="chk_oque" id="chk_oque">
    </label></td>
    <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">O qu&ecirc; :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_oque' id='condicao_oque' class='verdana_9' style="margin-left:5px;">
        <option value='='>=</option>
        <option value='&lt;'>&lt;</option>
        <option value='&gt;'>&gt;</option>
        <option value='&lt;&gt;'>&lt;&gt;</option>
        <option value='inicio'>inicie com</option>
        <option value='fim'>termine com</option>
        <option value='contenha'>contenha</option>
      </select>
      <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'oque', 'acao=true');"><img src="../images/combo.gif" alt="" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="oque">
        	<input name="pol_oque" id="pol_oque" value="" type="text" class="back_Campos" size="40">
        </label></td>
  </tr>
  <tr>
    <td width="4%" height="20" align="center" bgcolor="#EFEFEF"  style="border-bottom:dotted 1px #333333;"><label>
      <input type="checkbox" name="chk_relevancia" id="chk_relevancia">
    </label></td>
    <td height="20" align="right" bgcolor="#F7F7F7"  style="border-bottom:dotted 1px #333333;">Relev&acirc;ncia :&nbsp;</td>
    <td width="82%" height="25" bgcolor="#FFFFFF"  style="border-bottom:dotted 1px #333333;"><select name='condicao_relevancia' id='condicao_relevancia' class='verdana_9' style="margin-left:5px;">
        <option value='='>=</option>
        <option value='&lt;'>&lt;</option>
        <option value='&gt;'>&gt;</option>
        <option value='&lt;&gt;'>&lt;&gt;</option>
        <option value='inicio'>inicie com</option>
        <option value='fim'>termine com</option>
        <option value='contenha'>contenha</option>
      </select>
	  <a href="#" onClick="return LoadCondicao(<?php echo $_GET['pol_apl_codigo'];?>, 'relevancia', 'relevanciadet=true');"><img src="../images/combo.gif" width="18" height="17" border="0" align="absmiddle"></a>
        <label id="relevancia">
        	<input name="pol_relevancia" type="text" class="back_Campos" size="40">
        </label>    </td>
  </tr>
  <tr>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td align="right" bgcolor="#FFFFFF"><input name="pol_apl_codigo" type="hidden" id="pol_apl_codigo" value="<?php echo $_GET['pol_apl_codigo']; ?>">
      <input name="button" type="button" class="back_input" id="button" value="Avancar" onClick="return enviaRegra('/e-solution/servicos/policy/filtros/regra.php');" style="cursor:pointer">
&nbsp;</td>
  </tr>

  <tr>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="20" align="right" bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</form>
