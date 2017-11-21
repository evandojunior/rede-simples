<?php
if($_SERVER['PHP_SELF']!="/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/index.php"){
	if(!isset($_SESSION)){session_start();}	
	include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
	include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");

}

	$query_modAtividade = "select 
 bbh_modelo_atividade.bbh_mod_ati_codigo, bbh_modelo_atividade.bbh_mod_flu_codigo, bbh_mod_ati_nome, bbh_mod_ati_duracao, 
 bbh_mod_ati_inicio, bbh_modelo_atividade.bbh_mod_ati_ordem, bbh_mod_ati_mecanismo, bbh_mod_ati_icone, bbh_mod_ati_Inicio, 
 bbh_mod_atiFim, bbh_per_nome, count(bbh_fluxo_alternativa.bbh_mod_ati_codigo) as TotalAlter

 from bbh_modelo_atividade
 
      left join bbh_fluxo_alternativa on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_fluxo_alternativa.bbh_mod_ati_codigo
      inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
       Where bbh_modelo_atividade.bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']."
          group by 1
            order by bbh_modelo_atividade.bbh_mod_ati_ordem ASC ";//LIMIT $Inicio,$nElements";
    list($modAtividade, $row_modAtividade, $totalRows_modAtividade) = executeQuery($bbhive, $database_bbhive, $query_modAtividade);
	
	//trata ordenação
	if($totalRows_modAtividade>0){
		$primeiro = $row_modAtividade["bbh_mod_ati_codigo"];
		mysqli_data_seek($modAtividade,$totalRows_modAtividade-1);
			
		$row_ultimo = mysqli_fetch_assoc($modAtividade);
		$ultimo = $row_ultimo["bbh_mod_ati_codigo"];
		mysqli_data_seek($modAtividade,0);
	}

$homeDestino = "/e-solution/servicos/bbhive/fluxos/modelosFluxos/modelosAtividades/trocaOrdem.php";
?>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="borderAlljanela">
      <tr class="legandaLabel11">
        <td width="3%" height="26" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg">&nbsp;</td>
        <td width="72%" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg"><strong>Modelos de atividades</strong></td>
        <td colspan="5" background="/e-solution/servicos/bbhive/images/barra_horizontal2.jpg" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/novo.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&ordem=<?php echo $totalRows_modAtividade+1; ?>','menuEsquerda|conteudoGeral');"><img src="/e-solution/servicos/bbhive/images/novo.gif" border="0" align="absmiddle" /> modelo de atividades</a></td>
      </tr>
<?php if($totalRows_modAtividade>0) { ?>
  <?php while ($row_modAtividade = mysqli_fetch_assoc($modAtividade)){
  
  
  		//verifico quantas predecessoras tem cadastrada para esta atividade
			$query_Pred = "select count(bbh_pre_mod_ati_codigo) as total from bbh_dependencia Where bbh_modelo_atividade_sucessora=".$row_modAtividade['bbh_mod_ati_codigo'];
            list($Pred, $row_Pred, $totalRows_Pred) = executeQuery($bbhive, $database_bbhive, $query_Pred);
  ?>
      <tr class="legandaLabel11">
        <td height="25" align="center" class="color"><strong><?php echo $ord = $row_modAtividade['bbh_mod_ati_ordem']; ?></strong></td>
        <td>
        <div style="float:left">
        &nbsp;<?php echo $row_modAtividade['bbh_mod_ati_nome']; ?>
        </div>
        <div style="float:right; width:50px" align="right">
        	<table width="50" border="0" cellspacing="0" cellpadding="0">
             <tr>
             	<td height="1" width="20"></td>
                <td height="1"></td>
             </tr>
              <tr>
                <td>
          <?php if($totalRows_modAtividade>1) { ?>      
                <?php if($row_modAtividade['bbh_mod_ati_codigo']==$primeiro){ ?>
                  <a href="#@<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>" onClick="return OpenAjaxPostCmd('<?php echo $homeDestino."?bbh_mod_ati_codigo=".$row_modAtividade['bbh_mod_ati_codigo']."&acao=descer&ordem=$ord&bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']; ?>','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');">
                	<img src="/e-solution/servicos/bbhive/images/seta_baixo.gif" border="0" align="absmiddle" />
                  </a>
                <?php } elseif($row_modAtividade['bbh_mod_ati_codigo']!=$primeiro && $row_modAtividade['bbh_mod_ati_codigo']!=$ultimo){ ?>  
                  <a href="#@<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>" onClick="return OpenAjaxPostCmd('<?php echo $homeDestino."?bbh_mod_ati_codigo=".$row_modAtividade['bbh_mod_ati_codigo']."&acao=descer&ordem=$ord&bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']; ?>','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');">
                	<img src="/e-solution/servicos/bbhive/images/seta_baixo.gif" border="0" align="absmiddle" />
                  </a>
                <?php } ?>
          <?php } ?>      
                </td>
                <td>
          <?php if($totalRows_modAtividade>1) { ?>
                <?php if($row_modAtividade['bbh_mod_ati_codigo']==$ultimo){ ?>
                  <a href="#@<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>" onClick="return OpenAjaxPostCmd('<?php echo $homeDestino."?bbh_mod_ati_codigo=".$row_modAtividade['bbh_mod_ati_codigo']."&acao=subir&ordem=$ord&bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']; ?>','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');">
                	<img src="/e-solution/servicos/bbhive/images/seta_cima.gif" border="0" align="absmiddle" />
                  </a>
                <?php } elseif($row_modAtividade['bbh_mod_ati_codigo']!=$primeiro && $row_modAtividade['bbh_mod_ati_codigo']!=$ultimo){ ?>  
                  <a href="#@<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>" onClick="return OpenAjaxPostCmd('<?php echo $homeDestino."?bbh_mod_ati_codigo=".$row_modAtividade['bbh_mod_ati_codigo']."&acao=subir&ordem=$ord&bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']; ?>','loadOrdena','&1=1','Atualizando dados...','loadOrdena','2','2');">
                	<img src="/e-solution/servicos/bbhive/images/seta_cima.gif" border="0" align="absmiddle" />
                  </a>
                <?php } ?>
          <?php } ?>  
                </td>
              </tr>
            </table>
        </div>
        </td>
        <td width="3%" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/edita.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Alterar este modelo atividade"><img src="/e-solution/servicos/bbhive/images/editar.gif" border="0" align="absmiddle" /></a></td>
        <td width="3%" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/exclui.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Excluir este modelo atividade"><img src="/e-solution/servicos/bbhive/images/excluir.gif" border="0" align="absmiddle" /></a></td>
        <td width="3%" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/detalhamento/regra.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para gerenciar os campos de detalhamento deste modelo de atividade"><img src="/e-solution/servicos/bbhive/images/detalhamento.gif" width="16" height="16" border="0" align="absmiddle"/></a></td>
        <td width="8%" align="center"><a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/dependencia/regra.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para gerenciar as predecessoras deste modelo de atividade"><img src="/e-solution/servicos/bbhive/images/tabelaDinamica.gif" border="0" align="absmiddle" />&nbsp;<?php 
			$pred = $row_Pred['total'];
			if($pred>0){ echo "<strong>$pred</strong>"; } else { echo $pred; }
		 ?></a></td>
        <td width="8%" align="center">
        <a href="#@" onClick="LoadSimultaneo('perfil/index.php?perfil=2|fluxos/modelosFluxos/modelosAtividades/alternativas/index.php?bbh_mod_flu_codigo=<?php echo $_GET['bbh_mod_flu_codigo']; ?>&bbh_mod_ati_codigo=<?php echo $row_modAtividade['bbh_mod_ati_codigo']; ?>','menuEsquerda|conteudoGeral');" title="Clique para gerenciar as decis&otilde;es deste de modelo atividade"><img src="/e-solution/servicos/bbhive/images/lista.gif" border="0" align="absmiddle" />&nbsp;<?php
		$al = $row_modAtividade['TotalAlter'];
		
		if($al>0){ echo "<strong>$al</strong>"; } else { echo $al; }?></a></td>
  </tr>
  <?php 
  	$Icone = '<img src="/datafiles/servicos/bbhive/corporativo/images/tarefas/'.$row_modAtividade['bbh_mod_ati_icone'].'" border="0" align="absmiddle" />';
  ?>
      <tr class="legandaLabel11">
        <td height="25" align="center"><?php echo $Icone; ?></td>
        <td class="legandaLabel10">
        <div style="float:left">
        &nbsp;Perfil :&nbsp;<?php echo $h=$row_modAtividade['bbh_per_nome']; ?>
        </div>
        <div style="float:right">
        	<?php if($row_modAtividade['bbh_mod_ati_mecanismo']=="1"){ echo "autom&aacute;tico";} else { echo "<span class='color'>manual</span>"; }  ?> |&nbsp;
        </div>
        </td>
        <td colspan="5" class="legandaLabel10">dura&ccedil;&atilde;o:&nbsp;<?php echo $d=$row_modAtividade['bbh_mod_ati_duracao']; ?> dia(s)</td>
      </tr>
      <tr>
        <td height="1" colspan="7" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
      </tr>
  <?php } ?>    
<?php } else { ?>
      <tr class="legandaLabel11">
        <td height="22" colspan="7" align="center">N&atilde;o h&aacute; registros cadastrados</td>
      </tr>
<?php } ?>
      <tr class="legandaLabel11">
        <td height="22" colspan="7" align="center"><?php //require_once('../../../includes/paginacao/paginacao.php');?></td>
      </tr>
      <tr class="legandaLabel11">
        <td height="5" colspan="7" align="center"></td>
      </tr>
    </table>