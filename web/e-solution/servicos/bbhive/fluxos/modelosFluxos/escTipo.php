<?php
	$idMensagemFinal= 'listaArvore';
	$infoGet_Post	= '?1=1';//Se envio for POST, colocar nome do formulário
	$Mensagem		= 'Carregando dados...';
	$idResultado	= $idMensagemFinal;
	$Metodo			= '2';//1-POST, 2-GET
	$TpMens			= '2';//1-Troca conteúdo sem apagar anterior , 2-Troca conteúdo apagando o anterior antes
	$homeDestino	= '/e-solution/servicos/bbhive/fluxos/modelosFluxos/arvore.php';

echo "<var style=\"display:none\">OpenAjaxPostCmd('".$homeDestino."','".$idResultado."','".$infoGet_Post."','".$Mensagem."','".$idMensagemFinal."','".$Metodo."','".$TpMens."')</var>";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="border:#000000 solid 1px; background:#FFFFFF;">
  <tr>
    <td width="96%" height="19" background="/e-solution/servicos/bbhive/images/back_cabeca_label.gif" class="verdana_11" style="color:#FFFFFF">Tipos de modelos dispon&iacute;veis</td>
    <td width="4%" align="center" background="/e-solution/servicos/bbhive/images/back_cabeca_label.gif"><a href="#@" onClick="document.getElementById('carregaTipo').innerHTML='';"><img src="/e-solution/servicos/bbhive/images/close.gif" alt="Fechar" width="13" height="13" border="0" align="absmiddle"></a></td>
  </tr>
  <tr>
    <td height="200" colspan="2" valign="top">
    <fieldset style="margin-left:5px; margin-right:5px;">
        <legend class="verdana_11"><strong>Escolha o tipo</strong></legend>
            <br>
            <div id="listaArvore">
            	Carregando dados...
            </div>
    </fieldset>
</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#E0DFE3" style="border-top:#CCCCCC solid 1px;">&nbsp;</td>
  </tr>
</table>
