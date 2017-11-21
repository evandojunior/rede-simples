<?php
 if(isset($_GET['bbh_mod_ati_codigo'])){
 	$bbh_mod_ati_codigo = $_GET['bbh_mod_ati_codigo'];
 } else {
 	$bbh_mod_ati_codigo = $bbh_mod_ati_codigo;
 }

	$query_modAtividade = "select 
 bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_modelo_atividade.bbh_mod_flu_codigo, bbh_mod_ati_nome, bbh_mod_ati_duracao, 
 bbh_mod_ati_inicio, bbh_modelo_atividade.bbh_mod_ati_ordem, bbh_mod_ati_mecanismo, bbh_mod_ati_icone, bbh_mod_ati_Inicio, 
 bbh_mod_atiFim, bbh_per_nome, count(bbh_fluxo_alternativa.bbh_mod_ati_codigo) as TotalAlter

 from bbh_modelo_atividade
 
      left join bbh_fluxo_alternativa on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_fluxo_alternativa.bbh_mod_ati_codigo
      inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
       Where bbh_modelo_atividade.bbh_mod_ati_codigo= $bbh_mod_ati_codigo
          group by 1";
    list($modAtividade, $row_modAtividade, $totalRows_modAtividade) = executeQuery($bbhive, $database_bbhive, $query_modAtividade);
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="3%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
        <td width="71%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Modelo de atividade</strong></td>
        <td colspan="2" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center">&nbsp;</td>
      </tr>
      <tr class="legandaLabel11">
        <td height="25" align="center">&nbsp;</td>
        <td>&nbsp;<?php echo $row_modAtividade['bbh_mod_ati_nome']; ?></td>
        <td width="9%" align="center">&nbsp;</td>
        <td width="9%" align="center">
        <a href="#@" title="<?php echo $row_modAtividade['TotalAlter']; ?> alternativas(s) cadastrada(s)"><img src="/e-solution/servicos/bbhive/images/lista.gif" border="0" align="absmiddle" /> <?php echo $row_modAtividade['TotalAlter']; ?></a></td>
  </tr>
      <tr class="legandaLabel11">
        <td height="25" align="center">&nbsp;</td>
        <td colspan="3" class="legandaLabel10">&nbsp;Perfil :&nbsp;<?php echo $row_modAtividade['bbh_per_nome']; ?>
        <label style="float:right; margin-top:-13px;">
       	<?php if($row_modAtividade['bbh_mod_ati_mecanismo']=="1"){ echo "autom&aacute;tico";} else { echo "<span class='color'>manual</span>"; }  ?> |&nbsp;dura&ccedil;&atilde;o:&nbsp;<?php echo $row_modAtividade['bbh_mod_ati_duracao']; ?> dia(s)        </label></td>
      </tr>
      
      <tr>
        <td height="1" colspan="4" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
      <tr class="legandaLabel11">
        <td height="5" colspan="4" align="center"></td>
      </tr>
    </table>
