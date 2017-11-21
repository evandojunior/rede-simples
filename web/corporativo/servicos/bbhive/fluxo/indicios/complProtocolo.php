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
	
	$acao = "OpenAjaxPostCmd('/corporativo/servicos/bbhive/fluxo/indicios/executa.php','resultIndicios','nomeForm','Alterando informa&ccedil;&otilde;es...','resultIndicios','1','2');";
	
	$trocaResp 	= str_replace("nomeForm","trocaResponsavel", $acao);
	$execExame	= str_replace("nomeForm","exameRealizado", $acao);
	
	if(!isset($semAnexo)){
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="3" align="left" background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<img src="/corporativo/servicos/bbhive/images/painel/anexos.gif" align="absmiddle" />&nbsp;<strong>Arquivos digitalizados</strong></td>
  </tr>
  <?php $cont = 0;
if ($handle = @opendir(str_replace("web","database",$_SESSION['caminhoFisico'])."/servicos/bbhive/protocolo/protocolo_".$codProtocolo."/.")) {


while (false !== ($file = readdir($handle))) {
  if ($file != "." && $file != "..") {

		$excluir ="&nbsp;";
		  if(empty($bbh_flu_codigo)){ 
		  	$excluir = "<a href='#@' onClick=\"document.removeArquivo.bbh_pro_arquivo.value='".$file."'; document.removeArquivo.bbh_pro_codigo.value='".$codProtocolo."'; document.removeArquivo.submit();\"><img src='/corporativo/servicos/bbhive/images/excluir.gif' alt='Excluir arquivo' width='17' height='17' border='0'></a>";
		  }

		echo "<tr class='verdana_12'>
                <td width='5%' height='25' align='center' bgcolor='#FFFFFF' style='border-left:#cccccc solid 1px; border-bottom:#cccccc solid 1px;'><a href='#@' onClick='javascript: document.getElementById(\"bbh_pro_arquivo\").value=\"".$file."\"; document.abreArquivo.bbh_pro_codigo.value=\"".$codProtocolo."\"; document.abreArquivo.submit();'><img src='/corporativo/servicos/bbhive/images/download.gif' alt='Download do arquivo' width='17' height='17' border='0'></a></td>
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
<div class="legandaLabel11"><span class="color" id="resultIndicios">&nbsp;</span><span style="font-size:14px;">&nbsp;</span></div><?php } ?>
<div id="ondeIndicio" class="legandaLabel11">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="28" colspan="5" align="left" <?php if(!isset($semImagem)){ ?>background="/servicos/bbhive/images/back_top.gif" class="legandaLabel11"<?php } ?> style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;<?php if(!isset($semImagem)){ ?><img src="/servicos/bbhive/images/page_white_add.gif" alt="" align="absmiddle" />&nbsp;<strong><?php echo $_SESSION['componentesNome']; ?> cadastrados</strong><?php } ?></td>
  </tr>
  <?php $cod=0; $dep=0;
  while($row_ind = mysqli_fetch_assoc($ind)){
  	if($dep!=$row_ind['bbh_dep_codigo']){
  ?>
  <tr>
    <td height="20" colspan="5" align="left" class="titulo_setor" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;"><?php echo $row_ind['bbh_dep_nome']; ?></td>
  </tr>
  <?php }
  if($cod!=$row_ind['bbh_tip_codigo']){ 
  		$txt = explode("*|*",$row_ind['bbh_tip_campos']);
		$cp1 = !empty($txt[0]) ? $txt[0] : "Campo1";
		$cp2 = !empty($txt[1]) ? $txt[1] : "Campo2";
  ?>
  <tr>
    <td height="20" colspan="5" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px;">&nbsp;&nbsp;&nbsp;<strong><u><?php echo $row_ind['bbh_tip_nome']; ?></u></strong></td>
  </tr>
  <?php } ?>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp1 . "</strong>: ".$row_ind['bbh_ind_campo1']; ?></td>
    </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;"><?php echo "<strong>".$cp2 . "</strong>: ".$row_ind['bbh_ind_campo2']; ?></td>
    </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;">
      	<div style="float:left"><strong>Quantidade</strong>:&nbsp;<?php echo $row_ind['bbh_ind_quantidade']; ?></div>
        <div style="float:left; margin-left:100px;"><strong>Unidade de medida</strong>:&nbsp;<?php echo unidadeMedida($row_ind['bbh_ind_unidade'], 1); ?></div>
    </td>
    </tr>
  <tr>
    <td width="33" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="2" align="left" class="legandaLabel11"><span class="color"><?php echo nl2br($row_ind['bbh_ind_descricao']); ?></span></td>
    <td width="121" height="20" colspan="2" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px;" title="Código de barras"><?php echo $cd=$row_ind['bbh_ind_codigo_barras']; ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; <?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>">&nbsp;</td>
    <td width="339" height="20" align="left" class="legandaLabel11" style="<?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>">&nbsp;<?php if(!isset($semImagem)){ ?><img src="/corporativo/servicos/bbhive/images/equipe-chefia.gif" width="16" height="16" border="0" align="absmiddle" /><?php } else { echo "Responsável"; } ?> <strong>&nbsp;<?php echo !empty($row_ind['bbh_usu_nome']) ? $row_ind['bbh_usu_nome'] : $row_ind['bbh_ind_responsavel']; ?></strong></td>
    <td height="20" colspan="3" align="left" class="legandaLabel11" style="border-right:#cccccc solid 1px; <?php if($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']){ ?>border-bottom:#cccccc solid 1px;<?php } ?>"><strong>Desde</strong>:&nbsp;<?php echo $dt=arrumadata(substr($row_ind['bbh_ind_dt_recebimento'],0,10)) ." ".substr($row_ind['bbh_ind_dt_recebimento'],11,5); ?>
   <?php if(!isset($semAnexo)){?> 
    <?php 
	if(($row_AltDetal['total']>0)&&($row_ind['bbh_ind_responsavel']!=$_SESSION['MM_User_email']) && ($row_Fluxos['atividades']!=$row_Fluxos['finalizadas'])) { ?>
    &nbsp;<a href="#@" onclick="if(confirm('Tem certeza que deseja assumir a responsabilidade deste indício?\n              Clique em OK em caso de confirmação.')){  document.getElementById('bbh_ind_codigo').value='<?php echo $row_ind['bbh_ind_codigo']; ?>'; <?php echo $trocaResp; ?>}"><img src="/corporativo/servicos/bbhive/images/trocar.gif" width="18" height="18" border="0" align="absmiddle" title="Assumir responsabilidade deste indício" /></a>
    <?php } ?>
   <?php } ?> 
    </td>
  </tr>
  <?php if(($row_ind['bbh_ind_responsavel']==$_SESSION['MM_User_email']) || ($row_ind['bbh_ind_profissional']==$_SESSION['MM_User_email'])){ ?>
  <tr>
    <td width="33" height="20" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px;border-bottom:#cccccc solid 1px;">&nbsp;</td>
    <td height="20" colspan="4" align="left" class="legandaLabel11" style="border-bottom:#cccccc solid 1px;border-right:#cccccc solid 1px;">
    	<div style="margin-left:10px;">
        	<?php 
			$cod 		= $row_ind['bbh_ind_codigo'];
			$realizado	= !empty($row_ind['bbh_ind_dt_exame']) ? 1 : 0;
			include("formIndicios.php"); ?>
        </div>
    </td>
  </tr>
  <?php } ?>
  
  <?php $cod=$row_ind['bbh_tip_codigo']; $dep=$row_ind['bbh_dep_codigo'];
  } ?>
  <?php if($totalRows_ind==0){?>
  <tr>
    <td height="20" colspan="5" align="left" class="legandaLabel11" style="border-left:#cccccc solid 1px; border-right:#cccccc solid 1px; border-bottom:#cccccc solid 1px;">Não existe registros cadastrados</td>
  </tr>
  <?php } ?>
</table>
</div>