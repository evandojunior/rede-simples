<form name="form1" id="form1">
<div style="width:96%;margin-left:5px;margin-right:5px;border:1px solid #CCCCCC;margin-top:13px;">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#F2F3F4">
  <tr>
    <td colspan="2" align="left" class="verdana_11_bold"><img src="/e-solution/servicos/policy/images/busca.gif" width="16" height="16" align="absmiddle"> Filtros de auditoria</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">Aplica&ccedil;&atilde;o : &nbsp; </td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9"><label>
      <select name="select" id="select" class="back_input">
        <option>Escolha a aplica&ccedil;&atilde;o</option>
        <option>Cidad&atilde;o Br</option>
        <option>Cont&aacute;bil</option>
        <option>Criminalistica</option>
        <option>People Rank</option>
        <option>Todas</option>
      </select>
    </label></td>
  </tr>
  <tr>
    <td width="24%" align="right" bgcolor="#FFFFFF" class="verdana_9">Nome do usu&aacute;rio : &nbsp;</td>
    <td width="76%" align="left" bgcolor="#FFFFFF" class="verdana_9"><label>
      <input type="text" name="textfield" id="textfield" class="back_input">
    </label></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">Data inicio : &nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9"><input name="theDate" type="text" class="formulario2" id="theDate" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" readonly="readonly"/>
      <input type="button" style="width:23px;height:21px;" class="botao_calendar" onClick="displayCalendar(document.form1.theDate,'dd/mm/yyyy',this)"/></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">Data fim : &nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9"><input name="theDate2" type="text" class="formulario2" id="theDate2" value="<?php echo date("d") . "/" . date("m") . "/" . date("Y"); ?>" size="13" readonly="readonly"/>
        <input type="button" style="width:23px;height:21px;" class="botao_calendar" onClick="displayCalendar(document.form1.theDate2,'dd/mm/yyyy',this)"/></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">A&ccedil;&atilde;o : &nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9"><select name="select2" id="select2" class="back_input">
      <option>Escolha a a&ccedil;&atilde;o</option>
      <option>Acessou o sistema</option>
      <option>Alterou informa&ccedil;&otilde;es</option>
      <option>Saiu do sistema</option>
            </select></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
    <td align="left" bgcolor="#FFFFFF" class="verdana_9"><input name="ok2" type="button" class="back_input" id="ok2" value="Cancelar" />
    <input name="ok" type="button" class="back_input" id="ok" value="Filtrar" /></td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
    <td bgcolor="#FFFFFF" class="verdana_9">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
  </tr>
</table>
</div>
</form>
<div id="debug"></div>