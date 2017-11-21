<?php
	$query_ind = "select d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome from bbh_indicio i
 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
 		where bbh_pro_codigo = ".$codProtocolo."
    order by d.bbh_dep_codigo, t.bbh_tip_codigo asc";
    list($ind, $row_ind, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind, $initResult = false);
?>
<br>
<table width="560" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr>
    <td height="28" colspan="4" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['componentesNome']; ?> cadastrados</strong></td>
  </tr>
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){
  	if($dep!=$row_ind['bbh_dep_codigo']){
  ?>
  <tr>
    <td height="20" colspan="4" align="left" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>
  <?php }
  if($cod!=$row_ind['bbh_tip_codigo']){ ?>
  <tr>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;&nbsp;&nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td width="29" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td width="409" height="20" align="left" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></td>
    <td width="128" height="20" colspan="2" align="left" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <?php $cod=$row_ind['bbh_tip_codigo']; $dep=$row_ind['bbh_dep_codigo'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table>