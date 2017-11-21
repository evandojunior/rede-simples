<?php
	$query_curingas = "select bbh_cam_det_flu_titulo, bbh_cam_det_flu_curinga from bbh_detalhamento_fluxo as df
  inner join bbh_campo_detalhamento_fluxo as cd on df.bbh_det_flu_codigo = cd.bbh_det_flu_codigo
    where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo'] . " AND bbh_cam_det_flu_disponivel='1'";
    list($Ccuringas, $rows, $totalRows_curingas) = executeQuery($bbhive, $database_bbhive, $query_curingas, $initResult = false);
	$contador = "";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="verdana_10" style="margin-top:6px">
  <tr>
    <td width="296" height="24" id="erroTit"><fieldset style="margin:5px;">
      <legend><strong>Curingas de campos adicionais</strong></legend>
      <div style="height:100px; overflow:auto">
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
         <?php while($row_curingas = mysqli_fetch_assoc($Ccuringas)){
   		         if($contador == "#ffffff") { $contador="#F5F5F5"; } else{ $contador="#ffffff"; } $contador = $contador;
		   ?>
          <tr>
            <td width="54%" height="20" bgcolor="<?php echo $contador; ?>">&nbsp;<?php echo $t=$row_curingas['bbh_cam_det_flu_titulo']; ?></td>
            <td width="46%" bgcolor="<?php echo $contador; ?>"><strong><?php echo $c=$row_curingas['bbh_cam_det_flu_curinga']; ?></strong></td>
          </tr>
         <?php } $contador = "";?> 
        </table>
      </div>
    </fieldset></td>
    <td width="297" id="erroTit"><fieldset style="margin:5px;">
      <legend><strong>Curingas de campos do of&iacute;cio</strong></legend>
      <div style="height:100px; overflow:auto">
        <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
         <?php foreach($curingas as $indice=>$valor){ 
   		         if($contador == "#ffffff") { $contador="#F5F5F5"; } else{ $contador="#ffffff"; } $contador = $contador;
		   ?>
          <tr>
            <td width="54%" height="20" bgcolor="<?php echo $contador; ?>">&nbsp;<?php echo $t=$indice; ?></td>
            <td width="46%" bgcolor="<?php echo $contador; ?>"><strong><?php echo $c=$valor; ?></strong></td>
          </tr>
         <?php } ?> 
         <?php foreach($curingasFluxo as $indice=>$valor){ 
   		         if($contador == "#ffffff") { $contador="#F5F5F5"; } else{ $contador="#ffffff"; } $contador = $contador;
		   ?>
          <tr>
            <td width="54%" height="20" bgcolor="<?php echo $contador; ?>">&nbsp;<?php echo $t=$indice; ?></td>
            <td width="46%" bgcolor="<?php echo $contador; ?>"><strong><?php echo $c=$valor; ?></strong></td>
          </tr>
         <?php } ?> 
        </table>
      </div>
    </fieldset></td>
  </tr>
</table>