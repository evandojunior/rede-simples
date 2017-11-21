<?php
function montaCor($cor, $tituloCor, $id){
	//location.href=\'/servicos/bbhive/index.php?st='.$id.'\'
	//return showHome('includes/completo.php','conteudoGeral', 'protocolos/cadastro/passo1.php','colPrincipal')
	return '<table width="25" border="0" align="left" cellpadding="0" cellspacing="0" onmouseover="javascript: document.getElementById(\'legendaCor\').innerHTML = \'&nbsp;Clique e visualize somente - '.$tituloCor.'\'" onmouseout="javascript: document.getElementById(\'legendaCor\').innerHTML = \'&nbsp;Passe o mouse sobre cada cor\'" style="cursor:pointer"  onclick="return showHome(\'includes/completo.php\',\'conteudoGeral\', \'protocolos/regra.php?status='.$id.'\',\'colPrincipal\')">
			  <tr>
				<td width="24%" bgcolor="'.$cor.'" style="border:#CCC solid 1px;">&nbsp;</td>
			  </tr>
			</table>';
}
?>
<table width="960" border="0" align="center" cellpadding="0" cellspacing="0" background="/corporativo/servicos/bbhive/images/back_flux.gif" class="verdana_11" style="border:#FAE2BD solid 1px;">
  <tr>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="27" height="1"></td>
    <td width="663" height="1"></td>
  </tr>
  <tr>
  <?php foreach($status as $i=>$c){
          $a = $i;
 // for($a=1; $a<=count($status); $a++){ 
  		$cada = explode("|",$c);
  	?>
  	<td width="27" height="20" align="left" valign="middle" style="border-left:#ffffff solid 1px;border-right:#FAE2BD solid 1px;"><?php echo montaCor($cada[1], $cada[0], $a); ?></td>
  <?php } ?>
  <tr>
</table>
<div id="legendaCor" class="legandaLabel11" style="clear:both; font-weight:bold; height:18px;">&nbsp;Passe o mouse sobre cada cor</div>