<?php
    //todos os protocolos
	$query_strNovas = "SELECT bbh_pro_codigo FROM bbh_protocolos 
					  left join bbh_departamento on bbh_protocolos.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo 
					  left join bbh_usuario on bbh_protocolos.bbh_pro_email = bbh_usuario.bbh_usu_identificacao
					  left join bbh_usuario_perfil on bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
					  
					  WHERE 
					   bbh_protocolos.bbh_dep_codigo = (select bbh_dep_codigo from bbh_usuario where bbh_usu_identificacao = '".$_SESSION['MM_User_email']."')						
						AND (bbh_pro_status = '1' OR bbh_pro_status = '2' OR bbh_pro_status = '3' OR bbh_pro_status = '7')
						 group by bbh_protocolos.bbh_pro_codigo";
    list($strNovas, $row_strNovas, $totalRows_strNovas) = executeQuery($bbhive, $database_bbhive, $query_strNovas);
	
    //verifica quantos fluxos com meu ID
	$query_strMeusFluxos = "select count(bbh_flu_codigo) as total from bbh_fluxo Where bbh_usu_codigo=".$_SESSION['usuCod'];
    list($strMeusFluxos, $row_strMeusFluxos, $totalRows_strMeusFluxos) = executeQuery($bbhive, $database_bbhive, $query_strMeusFluxos);

    //quantos perfis eu tenho
	$query_strMeusPerfis = "select count(bbh_usu_per_codigo) as total from bbh_usuario_perfil Where bbh_usu_codigo=".$_SESSION['usuCod'];
    list($strMeusPerfis, $row_strMeusPerfis, $totalRows_strMeusPerfis) = executeQuery($bbhive, $database_bbhive, $query_strMeusPerfis);
	
    //quantas mensagens eu tenho
	$query_strMinhasMensagens = "select count(bbh_men_codigo) as total from bbh_mensagens Where bbh_men_data_leitura is NULL and bbh_usu_codigo_destin=".$_SESSION['usuCod'];
    list($strMinhasMensagens, $row_strMinhasMensagens, $totalRows_strMinhasMensagens) = executeQuery($bbhive, $database_bbhive, $query_strMinhasMensagens);
	
    //quantas tarefas eu tenho
	$query_strMinhasTarefas = "select count(bbh_ati_codigo) as total from bbh_atividade Where bbh_usu_codigo=".$_SESSION['usuCod']." and bbh_sta_ati_codigo<>2";
    list($strMinhasTarefas, $row_strMinhasTarefas, $totalRows_strMinhasTarefas) = executeQuery($bbhive, $database_bbhive, $query_strMinhasTarefas);

	$query_Procedimentos = "select bbh_perfil.bbh_per_codigo, bbh_usu_codigo, 
      round(sum(bbh_per_fluxo)) as bbh_per_fluxo, 
      round(sum(bbh_per_mensagem)) as bbh_per_mensagem,
      round(sum(bbh_per_arquivos)) as bbh_per_arquivos,
      round(sum(bbh_per_equipe)) as bbh_per_equipe,
      round(sum(bbh_per_tarefas)) as bbh_per_tarefas,
      round(sum(bbh_per_relatorios)) as bbh_per_relatorios,
      round(sum(bbh_per_protocolos)) as bbh_per_protocolos,
      round(sum(bbh_per_central_indicios)) as bbh_per_central_indicios
    from bbh_perfil
      inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
           WHERE bbh_usu_codigo = ".$_SESSION['usuCod']."
                     group by bbh_usu_codigo";
    list($Procedimentos, $row_Procedimentos, $totalRows_Procedimentos) = executeQuery($bbhive, $database_bbhive, $query_Procedimentos);
	
	$temItens = 0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-left:5px;margin-right:5px;margin-bottom:5px;">
  <tr>
    <td height="22" colspan="6" class="verdana18" style="border-bottom:#069 solid 1px;"><strong>Voc&ecirc; possui</strong></td>
  </tr>
  <tr>
    <td height="3" colspan="6"></td>
  </tr>
  <tr>
    <td width="2%" height="22" class="verdana_12"><img src="/corporativo/servicos/bbhive/images/msgIII.gif" border="0" align="absmiddle"></td>
    <td width="2%" class="verdana_12" align="right"><?php  echo $row_strMinhasMensagens['total']; ?></td>
    <td width="23%" class="verdana_12" align="left">&nbsp;<?php echo strtolower($_SESSION['MsgNome']); ?> n&atilde;o lida</td>
    <td width="2%" class="verdana_12"><?php if($row_Procedimentos['bbh_per_fluxo']>=1){ ?><img src="/corporativo/servicos/bbhive/images/tabelaDinamica.gif" border="0" align="absmiddle" /><?php }?></td>
    <td width="2%" align="right" class="verdana_12"><?php if($row_Procedimentos['bbh_per_fluxo']>=1){ ?><?php echo $row_strMeusFluxos['total']; ?><?php } ?></td>
    <td width="39%" align="left" class="verdana_12">&nbsp;<?php if($row_Procedimentos['bbh_per_fluxo']>=1){ ?><?php echo strtolower($_SESSION['FluxoNome']); ?><?php } ?></td>
  </tr>
  <tr>
    <td height="22" class="verdana_12"><img src="/corporativo/servicos/bbhive/images/engrenagem.gif" border="0" align="absmiddle">&nbsp;</td>
    <td class="verdana_12" align="right"><?php echo $row_strMinhasTarefas['total']; ?></td>
    <td class="verdana_12" align="left">&nbsp;<?php echo strtolower($_SESSION['TarefasNome']); ?> em aberto</td>
    <td class="verdana_12">
    <?php if($row_Procedimentos['bbh_per_protocolos']>=1){ ?>
	    <img src="/corporativo/servicos/bbhive/images/prot.gif" border="0" align="absmiddle" />
    <?php } ?>
    </td>
    <td align="right" class="verdana_12"><?php if($row_Procedimentos['bbh_per_protocolos']>=1){ ?><?php echo $totalRows_strNovas; ?><?php } ?></td>
    <td align="left" class="verdana_12">&nbsp;<?php if($row_Procedimentos['bbh_per_protocolos']>=1){ ?><?php echo ($_SESSION['protNome']); ?> nova(s)<?php } ?></td>
  </tr>
  <tr>
    <td height="22" class="verdana_12">&nbsp;</td>
    <td class="verdana_12">&nbsp;</td>
    <td class="verdana_12">&nbsp;</td>
    <td class="verdana_12">&nbsp;</td>
    <td class="verdana_12">&nbsp;</td>
    <td class="verdana_12">&nbsp;</td>
  </tr>
</table>
