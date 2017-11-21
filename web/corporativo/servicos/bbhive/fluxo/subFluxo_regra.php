<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

foreach($_GET as $indice=>$valor){
	if(($indice=="amp;bbh_mod_flu_codigo")||($indice=="bbh_mod_flu_codigo")){ $bbh_mod_flu_codigo=$valor; }
	if(($indice=="amp;bbh_ati_codigo")||($indice=="bbh_ati_codigo")){ $bbh_ati_codigo=$valor; }
	if(($indice=="amp;bbh_flu_alt_codigo")||($indice=="bbh_flu_alt_codigo")){ $bbh_flu_alt_codigo=$valor; }
	if(($indice=="amp;titAlt")||($indice=="titAlt")){ $titAlt=$valor; }
	if(($indice=="amp;ordem")||($indice=="ordem")){ $ordem=$valor; }
	if(($indice=="amp;bbh_mod_ati_codigo")||($indice=="bbh_mod_ati_codigo")){ $bbh_mod_ati_codigo=$valor; }
	if(($indice=="amp;bbh_flu_codigo")||($indice=="bbh_flu_codigo")){ $bbh_flu_codigo=$valor; }
}

require_once('../tarefas/acao/includes/classeAtividade.php');
$atividade = new atividade();
$atividade->setLinkConnection($bbhive);
$atividade->setDefaultDatabase($database_bbhive);
$atividade->execute($bbh_ati_codigo);

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_tip_flu_identificacao, bbh_tip_flu_nome
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		#inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		#inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		#inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_modelo_fluxo.bbh_mod_flu_codigo = ".$bbh_mod_flu_codigo."
		
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);

	$query_Atividades = "select bbh_modelo_atividade.*, bbh_per_nome from bbh_modelo_atividade
	      inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
      Where bbh_mod_flu_codigo = ".$bbh_mod_flu_codigo." and bbh_mod_ati_ordem>=$ordem
           order by bbh_mod_ati_ordem asc";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);

	//meu departamento
	$query_Dpto = "select bbh_dep_codigo from bbh_usuario Where bbh_usu_codigo=".$_SESSION['usuCod'];
    list($Dpto, $row_Dpto, $totalRows_Dpto) = executeQuery($bbhive, $database_bbhive, $query_Dpto);
	
	//recupera dados do fluxo PAI
	$codigoFluxo = $atividade->codigoFluxo;

	$query_FPai = "select * from bbh_fluxo Where bbh_flu_codigo=$codigoFluxo";
    list($FPai, $row_FPai, $totalRows_FPai) = executeQuery($bbhive, $database_bbhive, $query_FPai);

?>
<var style="display:none">txtSimples('tagPerfil', 'Descisão de Atividade')</var>
<form name="formFluxo" id="formFluxo">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-top:-10px;">
  <tr>
    <td>
    <strong class="verdana18 color"><?php require_once("cabecalhoModeloFluxo.php"); ?></strong><br />&nbsp;
    &nbsp;<strong>Gerenciamento de atividade</strong><?php if($row_Dpto['bbh_dep_codigo']==$atividade->meuDepartamento){ echo " do(a) ".$atividade->profissional; } else { echo " do ".$atividade->nmDepto; } ?>
    </td>
  </tr>
  <tr>
    <td height="4" background="/corporativo/servicos/bbhive/images/barra_tar.gif"></td>
  </tr>
  <tr>
    <td>
    <?php require_once("../tarefas/acao/includes/gerAtividade.php"); ?>
    </td>
  </tr>
  <tr>
    <td height="4" background="/corporativo/servicos/bbhive/images/barra_tar.gif"></td>
  </tr>
</table>
<br>

<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Finalizar descis&atilde;o</strong></span>
      <label style="float:right; ">
     <a href="#@" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/regra.php?bbh_ati_codigo=<?php echo $bbh_ati_codigo; ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" class="verdana_11"></td>
  </tr>
  <tr>
    <td height="25" colspan="2" bgcolor="#CCFFCC" class="verdana_12" style="border-bottom:#0C6 solid 1px;">&nbsp;Alternativa selecionada : <strong><?php echo $titAlt; ?></strong></td>
  </tr>
</table>
<br>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td width="16%" height="18" align="right" class="color"><strong>C&oacute;d. tipo :&nbsp;</strong></td>
    <td width="84%">&nbsp;<?php echo normatizaCep($row_Fluxos['bbh_tip_flu_identificacao']); ?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Tipo :&nbsp;</strong></td>
    <td>&nbsp;<?php echo $row_Fluxos['bbh_tip_flu_nome']; ?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Modelo :&nbsp;</strong></td>
    <td>&nbsp;<?php echo $row_Fluxos['bbh_mod_flu_nome']; ?><input type="hidden" name="bbh_flu_data_iniciado" id="bbh_flu_data_iniciado" value="<?php echo date("Y-m-d");?>" /></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Data <?php echo $_SESSION['FluxoNome']; ?> :&nbsp;</strong></td>
    <td>&nbsp;<?php echo date("d/m/Y");?></td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Inicio previsto :&nbsp;</strong></td>
    <td id="inicioPrevisto">&nbsp;</td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>Final previsto :&nbsp;</strong></td>
    <td id="finalPrevisto">&nbsp;</td>
  </tr>
  <tr>
    <td height="18" align="right" class="color"><strong>T&iacute;tulo :&nbsp;</strong></td>
    <td><label>
      &nbsp;<strong>Sub: <?php echo $row_FPai['bbh_flu_titulo']; ?>
      </strong>
      <input name="bbh_flu_titulo" type="hidden" class="back_Campos" id="bbh_flu_titulo" value="Sub: <?php echo $row_FPai['bbh_flu_titulo']; ?>" size="55" />
      <input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" value="<?php echo $bbh_mod_flu_codigo; ?>" />
    </label></td>
  </tr>
  <tr>
    <td height="18" align="right" valign="top" class="color"><span style="margin-top:2px;"><strong>Observa&ccedil;&atilde;o :&nbsp;</strong></span></td>
    <td><label>
      &nbsp;<textarea name="bbh_flu_observacao" id="bbh_flu_observacao" cols="70" rows="5" class="formulario2"></textarea>
      </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  
  <tr>
    <td width="461" height="26" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Verifique as atividades abaixo</strong></td>
    <td width="507" height="26" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Perfil</strong></td>
  </tr>
  <tr>
    <td height="5" colspan="2" bgcolor="#FFFFFF"></td>
  </tr>
<?php 
 $InicioPrevisto= 0;
 $FinalPrevisto	= 0;

if($totalRows_Atividades>0){ ?>  
 <?php 
 $erro=0;
 $cadaPar="";
 $InicioPrevisto= 10000;
 $FinalPrevisto	= 0;
 $FinalPrevistoDias	= 0;
	
 	do { 
 	$codModAtividade= $row_Atividades['bbh_mod_ati_codigo'];
	$mecanismo		= $row_Atividades['bbh_mod_ati_mecanismo'];

		//Final Previsto em dias
		if($row_Atividades['bbh_mod_ati_duracao']+$row_Atividades['bbh_mod_ati_inicio'] > $FinalPrevisto){
			$FinalPrevistoDias = $row_Atividades['bbh_mod_ati_duracao']+$row_Atividades['bbh_mod_ati_inicio'];
		}

	if($mecanismo==1){
		$AjusteSql = " bbh_usu_atribuicao asc";
	} else {
		$AjusteSql = " bbh_usu_nome asc";
	}
		//verifica quais personagens serão envolvidos neste processo
		$query_Personagens = "select
			  bbh_mod_ati_codigo, bbh_mod_flu_codigo, bbh_mod_ati_duracao, bbh_mod_ati_inicio, bbh_mod_ati_ordem,
			  COALESCE(bbh_usuario.bbh_usu_codigo,0) as bbh_usu_codigo, 
			  COALESCE(bbh_usu_identificacao,0) as bbh_usu_identificacao, 
			  COALESCE(bbh_usu_nome,0) as bbh_usu_nome 
		 
		 from bbh_modelo_atividade
			  inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
			  inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
			  
			  left join bbh_usuario on bbh_usuario_perfil.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
				  Where bbh_mod_ati_codigo = $codModAtividade
		Order By $AjusteSql";
        list($Personagens, $row_Personagens, $totalRows_Personagens) = executeQuery($bbhive, $database_bbhive, $query_Personagens);
		
		//Inicio Previsto em dias
		if($row_Atividades['bbh_mod_ati_inicio'] < $InicioPrevisto){
			$InicioPrevisto = $row_Atividades['bbh_mod_ati_inicio'];
		}
		
		//Final Previsto em dias
		if($row_Atividades['bbh_mod_ati_duracao']+$row_Atividades['bbh_mod_ati_inicio'] > $FinalPrevisto){
			$FinalPrevisto = $row_Atividades['bbh_mod_ati_duracao']+$row_Atividades['bbh_mod_ati_inicio'];
		}
		
 ?>
  <tr bgcolor="<?php if($totalRows_Personagens==0){ echo "#FFE2DD"; } else { echo "#FFFFFF"; } ?>">
    <td height="22" bgcolor="#FFFFFF">
      	&nbsp;<img src="/corporativo/servicos/bbhive/images/marcador.gif" align="absmiddle" />
        	&nbsp;&nbsp;<?php echo $row_Atividades['bbh_mod_ati_nome'];?>  
    </td>
    <td height="22" bgcolor="#FFFFFF">
    	&nbsp;<?php echo $row_Atividades['bbh_per_nome']; ?>
<label style="float:right; margin-top:-13px; margin-right:5px;">
					<?php
					if($totalRows_Personagens==0){
						echo '<img src="/corporativo/servicos/bbhive/images/bomba16.gif" align="absmiddle" />';
						$erro = $erro + 1;
					} elseif($totalRows_Personagens==1){
						echo "<label style='color:#666'>Apenas um profissional&nbsp;</label>";
						echo '<img src="/corporativo/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;';
						echo '<img src="/corporativo/servicos/bbhive/images/visto.gif" align="absmiddle" />';
						
						$cadaPar.= ",".$codModAtividade."|".$row_Atividades['bbh_mod_ati_inicio']."|".$row_Atividades['bbh_mod_ati_duracao']."|".$row_Personagens['bbh_usu_codigo'];
					} elseif($totalRows_Personagens>1){
					   if($mecanismo==1){//se mecanismo for automático
						echo "<label style='color:#666'>Sele&ccedil;&atilde;o autom&aacute;tica&nbsp;</label>";
						echo '<img src="/corporativo/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;';
						echo '<img src="/corporativo/servicos/bbhive/images/visto.gif" align="absmiddle" />';
							
						$cadaPar.= ",".$codModAtividade."|".$row_Atividades['bbh_mod_ati_inicio']."|".$row_Atividades['bbh_mod_ati_duracao']."|".$row_Personagens['bbh_usu_codigo'];
							//echo $row_Personagens['bbh_usu_nome'];
							
							
					   } else {//se manual
					    $HTML = '<input name="parAti_'.$codModAtividade.'" id="parAti_'.$codModAtividade.'" type="hidden" value="-1"/>';
						$HTML.= '<select class="formulario2" id="ati_'.$codModAtividade.'" onChange="return populaFluxo(this.value, '.$codModAtividade.')">';
						$HTML.= '<option value="-1">Selecione</option>';
						do{
							$HTML.= '<option value="'.$codModAtividade."|".$row_Atividades['bbh_mod_ati_inicio']."|".$row_Atividades['bbh_mod_ati_duracao']."|".$row_Personagens['bbh_usu_codigo'].'">'.$row_Personagens['bbh_usu_nome'].'</option>';
						} while ($row_Personagens = mysqli_fetch_assoc($Personagens));
						$HTML.= '</select>';
						echo $HTML;	
					  }
					}					
					?>
                </label>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <?php 
 } while ($row_Atividades = mysqli_fetch_assoc($Atividades)); ?>
 <?php if($erro>0){ ?>
  <tr>
    <td height="22" colspan="2" bgcolor="#FFFFFF" align="center" class="aviso"><?php if($erro>1){ echo "Existem "; } else { echo "Existe"; } echo $erro; if($erro>1){ echo "atividades"; } else { echo "atividade"; } ?> sem profissionais atribu&iacute;dos!!!</td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <?php } else { ?>
  <tr>
    <td height="28" colspan="2" bgcolor="#FFFFFF" align="right">
    <input name="alternativa" type="hidden" id="alternativa" value="<?php echo $bbh_flu_alt_codigo; ?>" />
    <input name="bbh_flu_codigo" type="hidden" id="bbh_flu_codigo" value="<?php echo $bbh_flu_codigo; ?>" />
    <input name="bbh_ati_codigo" type="hidden" id="bbh_ati_codigo" value="<?php echo $bbh_ati_codigo; ?>" />
    <input name="FinalPrevistoDias" type="hidden" id="FinalPrevistoDias" value="<?php echo $FinalPrevistoDias; ?>" />
    <input name="bbh_mod_ati_codigo" type="hidden" id="bbh_mod_ati_codigo" value="<?php echo $bbh_mod_ati_codigo; ?>" />
    <input name="bbh_flu_tarefa_pai" type="hidden" id="bbh_flu_tarefa_pai" value="<?php echo $bbh_ati_codigo; ?>" />
    <input name="bbh_usu_codigo" type="hidden" id="bbh_usu_codigo" value="<?php echo $row_FPai['bbh_usu_codigo']; ?>" />
    <input name="fluxos" type="hidden" value="<?php echo substr($cadaPar,1); ?>"/>
    	<input name="" type="button" value="Finalizar descisão" class="back_input" style="cursor:pointer" onclick="javascript: if(confirm('     Tem certeza que deseja prosseguir com esta ação?!\n Ao clicar em OK esta atividade  poder&aacute; ou n&atilde;o mudar o fluxo!')){ acaoFluxo('/corporativo/servicos/bbhive/fluxo/executaDesc.php?TimeStamp=<?php echo $_SERVER['REQUEST_TIME']; ?>') } " />    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"><div id="insereFluxo" style="position:absolute; margin-left:0px; margin-top:-15px;"></div></td>
  </tr>
 <?php } ?>
<?php } else { ?>  
  <tr>
    <td height="22" colspan="2" bgcolor="#FFFFFF" align="center" class="aviso">N&atilde;o h&aacute; atividades cadastradas para este processo!!!</td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
<?php } ?>  
</table>
<a name="#flu">&nbsp;</a>
<?php 	
	$dtInicio 	= addDayIntoDate(date('Ymd'),$InicioPrevisto); 
	$Inicio		= $dtInicio;
	$dtInicio 	= substr($dtInicio,6,2)."/".substr($dtInicio,4,2)."/".substr($dtInicio,0,4);

	$dtFinal 	= addDayIntoDate($Inicio,$FinalPrevisto);
	$dtFinal 	= substr($dtFinal,6,2)."/".substr($dtFinal,4,2)."/".substr($dtFinal,0,4);
?>
</form>
<var style="display:none">txtSimples('inicioPrevisto', '&nbsp;<?php echo $dtInicio; ?>')</var>
<var style="display:none">txtSimples('finalPrevisto', '&nbsp;<?php echo $dtFinal; ?>')</var>