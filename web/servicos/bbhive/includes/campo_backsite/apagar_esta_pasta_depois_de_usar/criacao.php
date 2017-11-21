<table width="350" border="0" cellpadding="0" cellspacing="0" bgcolor="#EBE9ED">
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Novo  campo do modelo:</td>
	<td width="200" bgcolor="#EBE9ED" class="verdana_11"><span class="verdana_11_b">&nbsp;<?php echo $nome_grupo; ?></span></td>
	</tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="5" align="right" bgcolor="#EBE9ED" class="verdana_11"></td>
	<td width="200" height="5" align="right" bgcolor="#EBE9ED" class="verdana_11"></td>
  </tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Título do campo:</td>
	<td width="200" bgcolor="#EBE9ED" class="verdana_11" id="titulo">&nbsp;
	<input name="cam_titulo" type="text" class="verdana_11" id="cam_titulo" value="" size="25">	</td>
  </tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11" id="tdExibe"><input type="checkbox" name="exibe" id="exibe" onClick="if(document.getElementById('exibe').checked){document.getElementById('cam_exibe').disabled=false;}else{document.getElementById('cam_exibe').disabled=true;};"></td>
	<td width="200" align="left" bgcolor="#EBE9ED" style="color: #0099FF" class="verdana_11" id="exibir_listagem">&nbsp;<select name="cam_exibe" class="verdana_11" id="cam_exibe" disabled>
	  <option value="1">1</option>
	  <option value="2">2</option>
	  <option value="3">3</option>
	  <option value="4">4</option>
	  <option value="5">5</option>
	  <option value="6">6</option>
	</select>	</td>
  </tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11"><input type="checkbox" name="cam_obrigatorio" id="cam_obrigatorio"></td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11">&nbsp;Campo obrigat&oacute;rio
		<input type="hidden" name="doc_codigo" id="doc_codigo" value="<?php echo $doc_codigo; ?>" />
		<input type="hidden" name="emp_codigo" id="emp_codigo" value="<?php echo $emp; ?>" /></td>
  </tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11"><input type="checkbox" name="cam_unico" id="cam_unico"></td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11">&nbsp;Valor único</td>
  </tr>
  <tr class="ItemMenu" style="display:block">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Tipo do campo:</td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11" id="combo">&nbsp;
	<?php $this->comboTipo(); ?></td>
  </tr>
  <!--OPÇÕES DO TIPO DO CAMPO-->
  <tr class="ItemMenu" style="display:none" id="opcao_campo_01">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Tamanho do campo:</td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11" id="combo">&nbsp;
    <input name="campo_01" type="text" class="verdana_11" id="campo_01" value="" size="25"></td>
  </tr>
  <tr class="ItemMenu" style="display:none" id="opcao_campo_02">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Valor padrão:</td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11" id="combo">&nbsp;
    <input name="campo_02" type="text" class="verdana_11" id="campo_02" value="" size="25"></td>
  </tr>
  <tr class="ItemMenu" style="display:none" id="opcao_campo_03">
	<td width="150" height="25" align="right" bgcolor="#EBE9ED" class="verdana_11">Valor padrão:</td>
	<td width="200" align="left" bgcolor="#EBE9ED" class="verdana_11" id="combo">&nbsp;</td>
  </tr>
  <!--OPÇÕES DO TIPO DO CAMPO-->
</table>