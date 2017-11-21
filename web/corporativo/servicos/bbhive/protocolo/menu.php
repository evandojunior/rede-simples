<?php
function montaCor($cor, $tituloCor, $id){
	return '<table width="25" border="0" align="left" cellpadding="0" cellspacing="0" onmouseover="javascript: document.getElementById(\'legendaCor\').innerHTML = \'&nbsp;Clique e visualize somente - '.$tituloCor.'\'" onmouseout="javascript: document.getElementById(\'legendaCor\').innerHTML = \'&nbsp;Passe o mouse sobre cada cor\'" style="cursor:pointer"  onclick="showHome(\'includes/home.php\',\'conteudoGeral\', \'perfil/index.php?perfil=1&perfis=1|protocolo/index.php?status='.$id.'\',\'menuEsquerda|conteudoGeral\');">
			  <tr>
				<td width="24%" bgcolor="'.$cor.'" style="border:#CCC solid 1px;">&nbsp;</td>
			  </tr>
			</table>';
}
?>
<div id="legendaCor">&nbsp;Passe o mouse sobre cada cor</div>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" background="/corporativo/servicos/bbhive/images/back_flux.gif" class="verdana_11" style="border:#FAE2BD solid 1px;">
  <tr>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
    <td width="47" height="1"></td>
  </tr>
  <tr>
  <?php foreach($status as $i=>$c){
          $a = $i;
 // for($a=1; $a<=count($status); $a++){ 
  		$cada = explode("|",$c);
  	?>
  	<td width="47" height="20" align="left" valign="middle" style="border-left:#ffffff solid 1px;border-right:#FAE2BD solid 1px;"><?php echo montaCor($cada[1], $cada[0], $a); ?></td>
  <?php } ?>
  <tr>
</table>