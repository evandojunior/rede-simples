<?php
if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

	$query_Fluxos = "select 
		bbh_modelo_fluxo.*, bbh_per_nome, bbh_usu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome
		
		from bbh_modelo_fluxo
		#Tipo de fluxo
		inner join bbh_tipo_fluxo on bbh_modelo_fluxo.bbh_tip_flu_codigo = bbh_tipo_fluxo.bbh_tip_flu_codigo
		
		#Modelo Fluxo com permissão fluxo
		inner join bbh_permissao_fluxo on bbh_modelo_fluxo.bbh_mod_flu_codigo = bbh_permissao_fluxo.bbh_mod_flu_codigo
		
		#Permissão Fluxo com perfil
		inner join bbh_perfil on bbh_permissao_fluxo.bbh_per_codigo = bbh_perfil.bbh_per_codigo
		
		#Perfil com Usuário Perfil
		inner join bbh_usuario_perfil on bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
		Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo']."
		
		order by bbh_mod_flu_nome asc";
    list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);

	$query_Atividades = "select bbh_modelo_atividade.*, bbh_per_nome from bbh_modelo_atividade
	      inner join bbh_perfil on bbh_modelo_atividade.bbh_per_codigo = bbh_perfil.bbh_per_codigo
      Where bbh_mod_flu_codigo = ".$_GET['bbh_mod_flu_codigo']."
           order by bbh_mod_ati_ordem asc";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);

	//verifica se a tabela de detalhamento foi criada
	$query_tabDet = "select * from bbh_detalhamento_fluxo Where bbh_mod_flu_codigo=".$_GET['bbh_mod_flu_codigo']." AND bbh_det_flu_tabela_criada=1";
    list($tabDet, $row_tabDet, $totalRows_tabDet) = executeQuery($bbhive, $database_bbhive, $query_tabDet);
	//=================================================
?>
<var style="display:none">document.getElementById('bbh_flu_titulo').focus()</var>
<var style="display:none">txtSimples('tagPerfil', '<?php echo $_SESSION['FluxoNome']; ?>')</var>
<form name="formFluxo" id="formFluxo">
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-top:-10px;">
  <tr>
    <td width="100%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"> <img src="/corporativo/servicos/bbhive/images/fluxo-pequeno.gif" width="23" height="23" align="absmiddle" /> <span class="verdana_11"><strong>&nbsp;Iniciar <?php echo $_SESSION['FluxoNome']; ?></strong></span>
      <label style="float:right;">
     <a href="#@"  onClick="return LoadSimultaneo('perfil/index.php?perfil=1&fluxo=1|fluxo/regra2.php?bbh_tip_flu_codigo=<?php echo $_GET['bbh_tip_flu_codigo']; ?><?php if(isset($_GET['bbh_pro_codigo'])){ echo "&bbh_pro_codigo=".$_GET['bbh_pro_codigo']; } ?><?php if(isset($_GET['bbh_ati_codigo'])){ echo "&bbh_ati_codigo=".$_GET['bbh_ati_codigo']; } ?>','menuEsquerda|colPrincipal');">
    	<img src="/corporativo/servicos/bbhive/images/apontador_v.gif" border="0" />
    <span class="color"><strong>Voltar</strong></span>     </a>    </label>    </td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="verdana_11">&nbsp;</td>
  </tr>
</table>
<?php
$semFormDetalhamento = true;
//se tiver setado nº de protocolo exibe o cabeçalho do mesmo
 if(isset($_GET['bbh_pro_codigo'])){	
	require_once('../protocolo/cabecaProtocolo.php');
 }
//se veio da atividade 
 if(isset($_GET['bbh_ati_codigo'])){
 	require_once('../tarefas/includes/cabecalhoAtividade.php');
 }
 	$bbh_flu_codigo=0;
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11">
  <tr>
    <td height="1" colspan="2" align="right" bgcolor="#003399" class="color"></td>
    </tr>
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
      &nbsp;<input name="bbh_flu_titulo" type="text" class="back_Campos" id="bbh_flu_titulo" value="<?php echo isset($titOficio) ? $titOficio : ""; ?>" size="90" />
      <input type="hidden" name="bbh_mod_flu_codigo" id="bbh_mod_flu_codigo" value="<?php echo $_GET['bbh_mod_flu_codigo']; ?>" />
    </label></td>
  </tr>
  <tr>
    <td height="18" align="right" valign="top" class="color"><span style="margin-top:2px;"><strong>Observa&ccedil;&atilde;o :&nbsp;</strong></span></td>
    <td><label>
      &nbsp;<textarea name="bbh_flu_observacao" id="bbh_flu_observacao" cols="110" rows="4" class="formulario2"><?php echo isset($observacao) ? $observacao : ""; ?></textarea>
    </label></td>
  </tr>
  <tr>
    <td align="right" class="color">&nbsp;</td>
    <td><span class="color"><strong><input type="checkbox" name="bbh_flu_oculto" id="bbh_flu_oculto" />&nbsp;
      Ocultar <?php echo $_SESSION['FluxoNome']; ?>?</strong></span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<?php if($totalRows_tabDet>0) { ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="verdana_11" style="margin-top:-10px;">
  <tr>
    <td width="98%" height="26" background="/corporativo/servicos/bbhive/images/barra_horizontal.jpg"><span class="verdana_11_bold"><img src="/corporativo/servicos/bbhive/images/detalhe_tar.gif" width="16" height="16" align="absmiddle" /></span><span class="verdana_11"><strong>&nbsp;Detalhamento</strong></span></td>
  </tr>
  <tr>
    <td height="25" colspan="2" class="verdana_11"><?php 
	$cadastraDet	= "form1";
	$cadastroInicio	= true;
	require_once("detalhamento/edita.php");?></td>
  </tr>
</table>
<?php } ?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" style="margin-top:5px;">
  
  <tr>
    <td height="26" colspan="2" align="left" bgcolor="#E7E7E7" style="border-bottom:#666 solid 1px; border-top:#666 solid 1px;"><div class="verdana_12">
    <div style="float:left; display:none" id="atribuiProfissionais">
    &nbsp;Atribuir todas as atividades com op&ccedil;&otilde;es para o seguinte profissional :&nbsp;<label id="recebeCombo"></label>
    </div>
    <div style="float:right">
    <input name="btAcaoAtribui" id="btAcaoAtribui" type="button" value="Iniciar <?php echo $_SESSION['FluxoNome']; ?>" class="button" style="cursor:pointer" onclick="acaoFluxo('/corporativo/servicos/bbhive/fluxo/executa.php?TimeStamp=<?php echo $_SERVER['REQUEST_TIME']; ?>');" />
    </div>
    </div></td>
    </tr>
  <tr>
    <td height="5" colspan="2" align="left" class="verdana_11"></td>
    </tr>
  <tr>
    <td width="358" height="26" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11"><strong>Verifique as atividades abaixo</strong></td>
    <td width="378" height="26" align="left" background="/corporativo/servicos/bbhive/images/barra_horizontal2.jpg" class="verdana_11">
    <div style="float:left">
    	<strong>Perfil</strong>
    </div>
    <div style="float:right; width:150px;" align="center">
    	<strong>Executor</strong>
    </div>
    </td>
  </tr>
  <tr>
    <td height="5" colspan="2" bgcolor="#FFFFFF"></td>
  </tr>
<?php 
 	$InicioPrevisto= 0;
 	$FinalPrevisto	= 0;
	$opcoesProfissionais = array();
	
if($totalRows_Atividades>0){ ?>  
 <?php 
 $erro=0;
 $cadaPar="";
 $InicioPrevisto= 10000;
 $FinalPrevisto	= 0;

 	do { 
 	$codModAtividade= $row_Atividades['bbh_mod_ati_codigo'];
	$mecanismo		= $row_Atividades['bbh_mod_ati_mecanismo'];

	if($mecanismo==1){
		$AjusteSql = " bbh_usu_atribuicao asc";
	} else {
		$AjusteSql = " bbh_usu_apelido asc";
	}
		//verifica quais personagens serão envolvidos neste processo
		$query_Personagens = "select
			  bbh_mod_ati_codigo, bbh_mod_flu_codigo, bbh_mod_ati_duracao, bbh_mod_ati_inicio, bbh_mod_ati_ordem,
			  COALESCE(bbh_usuario.bbh_usu_codigo,0) as bbh_usu_codigo, 
			  COALESCE(bbh_usu_identificacao,0) as bbh_usu_identificacao, 
			  COALESCE(bbh_usu_apelido,0) as bbh_usu_apelido 
		 
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
    <td height="22" bgcolor="#FFFFFF" class="verdana_11">
      	&nbsp;<img src="/corporativo/servicos/bbhive/images/marcador.gif" align="absmiddle" />
        	&nbsp;&nbsp;<?php echo $row_Atividades['bbh_mod_ati_nome'];?>  
    </td>
    <td height="22" bgcolor="#FFFFFF" class="verdana_11">
    <div style="float:left">
    	&nbsp;<?php echo $row_Atividades['bbh_per_nome']; ?>
    </div>  
	<div style="float:right" align="right">  
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
						$HTML.= '<div id="combo_atribuicao"><select class="formulario2" id="ati_'.$codModAtividade.'" onChange="return populaFluxo(this.value, '.$codModAtividade.')">';
						$HTML.= '<option value="-1">Selecione</option>';
						do{
							$dados = $codModAtividade."|".$row_Atividades['bbh_mod_ati_inicio']."|".$row_Atividades['bbh_mod_ati_duracao']."|".$row_Personagens['bbh_usu_codigo'];
							//--
							$HTML.= '<option value="'.$dados.'">'.$row_Personagens['bbh_usu_apelido'].'</option>';
							//--
							$opcoesProfissionais[$row_Personagens['bbh_usu_codigo']] = array($dados,$row_Personagens['bbh_usu_apelido']);
							//--
						} while ($row_Personagens = mysqli_fetch_assoc($Personagens));
						$HTML.= '</select></div>';
						echo $HTML;	
					  }
					}					
?>
	</div>
    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <?php 
 } while ($row_Atividades = mysqli_fetch_assoc($Atividades)); ?>
 <?php if($erro>0){ ?>
  <tr>
    <td height="22" colspan="2" bgcolor="#FFFFFF" align="center" class="aviso verdana_11"><?php if($erro>1){ echo "Existem "; } else { echo "Existe"; } echo $erro; if($erro>1){ echo "atividades"; } else { echo "atividade"; } ?> sem profissionais atribu&iacute;dos!!!</td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"></td>
  </tr>
 <?php } else { ?>
  <tr>
    <td height="28" colspan="2" bgcolor="#FFFFFF" align="right">
    <input name="fluxos" id="fluxos" type="hidden" value="<?php echo substr($cadaPar,1); ?>"/>
    	<input name="btAcao" id="btAcao" type="button" value="Iniciar <?php echo $_SESSION['FluxoNome']; ?>" class="button" style="cursor:pointer" onclick="acaoFluxo('/corporativo/servicos/bbhive/fluxo/executa.php?TimeStamp=<?php echo $_SERVER['REQUEST_TIME']; ?>');" />    </td>
  </tr>
  <tr>
    <td height="1" colspan="2" background="/corporativo/servicos/bbhive/images/separador.gif"><div id="insereFluxo" style="position:absolute; margin-left:0px; "></div></td>
  </tr>
 <?php } ?>
<?php } else { ?>  
  <tr>
<td height="22" colspan="2" bgcolor="#FFFFFF" align="center" class="aviso verdana_11">N&atilde;o h&aacute; atividades cadastradas para este processo!!!</td>
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
<?php 
$opProf = '';
	if(count($opcoesProfissionais) > 0 && $erro == 0){
		$opProf = '<select class="verdana_12" id="atribuiAtividades"><option value="-1">Escolha o profissional</option>';
		//--
			foreach($opcoesProfissionais as $i=>$v){
				if($v!=""){
					$ok		= true;
					$opProf.= '<option value="'.$v[0].'">'.$v[1].'</option>';
				}
			}
		$opProf.= '&nbsp;<input name="btAtribui" id="btAtribui" type="button" value="Atribuir atividades" class="button" style="cursor:pointer" onclick="return atribuiAtividadesFluxo();" />';
		//--
	}
	echo '<div id="area_trans" style="display:none">' . $opProf . '</div>';
?>
</form>
<var style="display:none">txtSimples('inicioPrevisto', '&nbsp;<?php echo $dtInicio; ?>')</var>
<var style="display:none">txtSimples('finalPrevisto', '&nbsp;<?php echo $dtFinal; ?>')</var>
<?php if(isset($ok)){?>
	<var style="display:none">
    document.getElementById('recebeCombo').innerHTML = (document.getElementById('area_trans').innerHTML);
    document.getElementById('area_trans').innerHTML = '';
	</var> 
   <?php /* <var style="display:none">txtSimples('recebeCombo', '<?php echo $opProf; ?>')</var>*/ ?>
    <var style="display:none">document.getElementById('atribuiProfissionais').style.display='block';</var>
<?php } ?>