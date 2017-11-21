<?php 
$cabecalhoHTML= <<< EOF

<table width="777" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_12">
  <tr>
    <td height="25">Ol&aacute; <b>{$nomeResponsavel}</b>, existe(m) atividade(s) pendentes.</td>
  </tr>
  <tr>
    <td height="25">&nbsp;</td>
  </tr>
</table>
<br>

  <table width="777" border="0" align="center" cellpadding="0" cellspacing="1" class="verdana_11" bgcolor="#E6E6E6">
      <tr>
        	<td width="49%" height="30" bgcolor="#D0D0D0" align="left"><strong>{$tituloTarefas}</strong></td>
        	<td width="14%" align="left" bgcolor="#D0D0D0"><strong>Situa&ccedil;&atilde;o</strong></td>
        	<td width="13%" align="center" bgcolor="#D0D0D0"><strong>Iniciada em</strong></td>
        	<td width="13%" align="center" bgcolor="#D0D0D0"><strong>Finalizada em</strong></td>
			<td width="11%" align="center" bgcolor="#D0D0D0"><strong>Atraso em dias</strong></td>
      </tr> 
EOF;
?>