<?php
	//Tenho permissão para alterar alguma coisa
	$query_AltDetal = "select count(bbh_ati_codigo) as total from bbh_atividade 

inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo

Where bbh_fluxo.bbh_flu_codigo=$bbh_flu_codigo and (bbh_fluxo.bbh_usu_codigo=".$_SESSION['usuCod']." OR bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod'].")
 group by bbh_fluxo.bbh_flu_codigo";
    list($AltDetal, $row_AltDetal, $totalRows_AltDetal) = executeQuery($bbhive, $database_bbhive, $query_AltDetal);

	$query_ind = "select d.bbh_dep_codigo, d.bbh_dep_nome, i.*, t.bbh_tip_nome, t.bbh_tip_campos, u.bbh_usu_nome, x.bbh_usu_nome as profissional from bbh_indicio i
 inner join bbh_tipo_indicio t on i.bbh_tip_codigo = t.bbh_tip_codigo
 inner join bbh_departamento d on d.bbh_dep_codigo = t.bbh_dep_codigo
 left join bbh_usuario u on i.bbh_ind_responsavel = u.bbh_usu_identificacao
 left join bbh_usuario x on i.bbh_ind_profissional = x.bbh_usu_identificacao
 		where bbh_pro_codigo = ".$codProtocolo."
    order by d.bbh_dep_codigo, t.bbh_tip_codigo asc";
    list($ind, $rows, $totalRows_ind) = executeQuery($bbhive, $database_bbhive, $query_ind, $initResult = false);

?><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Verdana, Geneva, sans-serif; font-size:11px;">
  <tr>
    <td height="25" colspan="4" style="border-bottom:#999 solid 2px; font-size:14px;"><strong>Ind&iacute;cios no processo</strong></td>
  </tr>
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){
	$realizado	= !empty($row_ind['bbh_ind_dt_exame']) ? 1 : 0;
  	if($dep!=$row_ind['bbh_dep_codigo']){
  ?>
  <?php } if(!isset($dpto)){ ?>
  <tr>
    <td height="25" colspan="2" align="right" style="font-size:13px;border-bottom:#999 solid 1px;"><strong>Departamento:&nbsp;</strong></td>
    <td colspan="2" style="font-size:13px;border-bottom:#999 solid 1px;"><strong><?php echo $row_ind['bbh_dep_nome']; ?></strong></td>
  </tr>
  <?php $dpto= true; } if($cod!=$row_ind['bbh_tip_codigo']){ 
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";
  ?>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Tipo de ind&iacute;cio :&nbsp;</strong></td>
    <td colspan="2"><u><?php echo $row_ind['bbh_tip_nome']; ?></u></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="25" colspan="2" align="right">&nbsp;</td>
    <td colspan="2"><?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right">&nbsp;</td>
    <td colspan="2"><?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Descri&ccedil;&atilde;o :&nbsp;</strong></td>
    <td colspan="2"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Respons&aacute;vel :&nbsp;</strong></td>
    <td width="269"><?php echo !empty($row_ind['profissional']) ? $row_ind['profissional'] : "---"; ?></td>
    <td width="189"><?php /*<strong>Desde :</strong>&nbsp;<?php echo $dt=arrumadata(substr($row_ind['bbh_ind_dt_recebimento'],0,10)) ." ".substr($row_ind['bbh_ind_dt_recebimento'],11,5);*/ ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Situa&ccedil;&atilde;o :&nbsp;</strong></td>
    <td><?php if($realizado==1){ echo "<strong>Exame efetuado</strong>"; } else { echo "Exame não efetuado"; } ?></td>
    <td><strong>Data do exame:</strong>&nbsp;<?php echo !empty($row_ind['bbh_ind_dt_exame']) ? arrumadata(substr($row_ind['bbh_ind_dt_exame'],0,10)) : "---";?></td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><strong>Qtd. procedimentos:</strong></td>
    <td>&nbsp;<?php echo $row_ind['bbh_ind_qt_procedimento']; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td height="25" colspan="2" align="right"><u><strong>Procedimentos realizados :</strong></u></td>
    <td colspan="2" valign="top">
        <div style="color:#000; margin:10px;">
        <strong><?php echo !empty($row_ind['bbh_ind_procedimentos']) ? nl2br($row_ind['bbh_ind_procedimentos']) : "---"; ?></strong>
      </div>
    </td>
  </tr>
  <tr>
    <td height="25" colspan="4">&nbsp;</td>
  </tr>
  <?php $cod=$row_ind['bbh_tip_codigo']; $dep=$row_ind['bbh_dep_codigo'];
  } ?>
</table>
