<table width="560" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="28" colspan="3" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Arquivos digitalizados</strong></td>
  </tr>
  <?php $cont = 0;
if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$codProtocolo."/.")) {


while (false !== ($file = readdir($handle))) {
  if ($file != "." && $file != "..") {
		echo "<tr class='verdana_12'>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'>&nbsp;</td>
                <td width='90%' align='left' bgcolor='#FFFFFF' class='verdana_11' style='border-bottom:#cccccc solid 1px;'>&nbsp;".$file."</td>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'>&nbsp;</td>
              </tr>
              <tr>
                <td height='1' colspan='3' align='right' background='/servicos/bbhive/images/separador.gif'></td>
              </tr>";
$cont++; 
		if ($cont == 300) {
		die;
		}
     }
  }
 closedir($handle);
}
?> 
<?php if($cont==0){?>
  <tr>
    <td height="20" colspan="3" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe arquivos digitalizados</td>
  </tr>
<?php } ?>
</table>