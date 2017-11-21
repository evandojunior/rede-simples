<?php 
$html.= <<< EOF
	{$cabecaFluxo}   
	<tr style="background:#{$cor}">      
      <td width="49%" height="30" align="left">&nbsp;&raquo;&nbsp;{$modeloAtividade}</td>
	  <td width="14%" align="left" >{$nomeSituacao}</td>
   	  <td width="13%" align="center" >{$dataInicial}</td>
	  <td width="13%" align="center" >{$dataFinal}</td>
	  <td width="11%" align="center" >{$atrasoEmDias}</td>
    </tr>

EOF;
?>