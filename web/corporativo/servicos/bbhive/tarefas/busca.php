<?php
if(!isset($_SESSION)){ session_start(); } 
$SQL	= "";
$compl 	= "";
$strAud	= "";

//--Consulta com base no array==========================================================================
	if( isset($nmSessao) && isset($_SESSION[$nmSessao])){
		foreach($_SESSION[$nmSessao] as $i=>$v){
			if($v[0] == "1"){
				if($i=="ck_data"){
					$SQL.= str_replace("@sub#Var@Black",arrumadata($v[3]),$v[2]);
					$strAud	.= " (".arrumadata($v[3]).")";
					//echo arrumadata($v[3]);
				} elseif($i=="busca_data"){
					$vr = explode("|",$v[3]);
					$ini= arrumadata($vr[0]);
					$fin= arrumadata($vr[1]);
					//--	
						$vS = str_replace("@subDtInicial@",$ini,$v[2]);
						$vS = str_replace("@subDtFinal@",$fin,$vS);
					//--
					$strAud	.= " (".$ini." - ".$fin.")";
					$SQL.= $vS;
				} elseif($i=="busca_avancada"){
					$SQL.= str_replace("@sub#Var@Black", $_SESSION['consultaAvancada'],$v[2]);	
					$_SESSION['buscaAvancada'] = 1;
				}elseif($i!="busca_data"){
					$SQL.= str_replace("@sub#Var@Black", ($v[3]),$v[2]);
					$strAud	.= " (".($v[3]).")";
					//echo $v[2]."=".$v[3]."<br>";
				}
			}
		}
	}
	//

if( isset($nmSessao) && isset($_SESSION[$nmSessao]) && $_SESSION[$nmSessao]['busca_prof'][0]==0){
	$SQL .=" AND bbh_atividade.bbh_usu_codigo = ".$_SESSION['usuCod'];
} elseif(!isset($nmSessao) || !isset($_SESSION[$nmSessao])){
	$SQL .=" AND bbh_atividade.bbh_usu_codigo = ".$_SESSION['usuCod'];
}
	$and		 = " and bbh_atividade.bbh_sta_ati_codigo<>2 ";
	$textoPadrao = ' "não finalizadas"';

//--Padrão de consulta verificando Array();
if( isset($nmSessao) && isset($_SESSION[$nmSessao]) && $_SESSION[$nmSessao]['situacao'][0]==1){
	$acao = ($_SESSION[$nmSessao]['situacao'][3]);
	//--
	if($acao == "Concluídas"){
		$and	 	 = " and bbh_atividade.bbh_sta_ati_codigo=2 ";
		$textoPadrao = ' "concluídas"';
	} elseif($acao == "Andamento"){
		$and	= " and bbh_atividade.bbh_sta_ati_codigo=5";
		$textoPadrao = ' "em andamento"';
	} elseif($acao == "Atrasadas"){
		$and	= " and  bbh_ati_final_previsto<='".date('Y-m-d')."' and bbh_atividade.bbh_sta_ati_codigo<>2";
		$textoPadrao = ' "atrasadas"';
	} elseif($acao == "Novas"){
		$and	= " and  bbh_atividade.bbh_sta_ati_codigo=1 and bbh_ati_inicio_previsto>='".date('Y-m-d')."'";
		$textoPadrao = ' "novas"';
	} elseif($acao == "Aguardando"){
		$and	= " and  bbh_atividade.bbh_sta_ati_codigo=4";
		$textoPadrao = ' "aguardando"';
	} elseif($acao == "Todas"){
		$and	= " ";
		$textoPadrao = ' "todas"';
	}
}

//FILTRO PARA LISTA DE ATIVIDADES============================================================
	$orderBy = " order by bbh_flu_codigo, bbh_ati_inicio_previsto, bbh_mod_ati_ordem asc";
	$and	.= $SQL;
//===========================================================================================
    //atividades de subfluxo
    if (isCurrentPage("/corporativo/servicos/bbhive/tarefas/acao/includes/subAtividades.php")
        || isCurrentPage("/corporativo/servicos/bbhive/fluxo/atividades.php")
        || isCurrentPage("/corporativo/servicos/bbhive/consulta/index.php")) {
        // Complementa query
        $and = " AND bbh_fluxo.bbh_flu_codigo = ".$_GET['bbh_flu_codigo'];
        $paginaFluxo = true;
    }

//Dados para paginação
$dadosURL = "";
//--GET
	foreach($_GET as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}
//--POST
	foreach($_POST as $i=>$v){
		$dadosURL.= "&".$i."=".$v;
	}

	//select para descobrir o total de registros na base
	$query_Atividades ="select 
		count(bbh_ati_codigo) as total
		from bbh_atividade
			  inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
			  inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
			  inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
			  inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
				inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
				left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo 
				   Where 1=1 $and group by bbh_atividade.bbh_ati_codigo ";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);

	$page 		= "1";
	$nElements 	= "100";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= 'tarefas/index.php?Ts='.$_SERVER['REQUEST_TIME'].$dadosURL;
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_Atividades/$nElements);

	 $query_Atividades = "select 
bbh_atividade.*, bbh_mod_ati_nome, bbh_mod_ati_duracao, bbh_mod_ati_ordem, bbh_usu_identificacao, bbh_usu_apelido, bbh_sta_ati_nome, bbh_sta_ati_peso as concluido, bbh_sta_ati_nome, bbh_mod_ati_icone, bbh_dep_nome, bbh_departamento.bbh_dep_codigo, bbh_flu_titulo, bbh_ati_final_real
from bbh_atividade
      inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
      inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
      inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
      inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
	  	inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
		left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo 
           Where 1=1 $and group by bbh_atividade.bbh_ati_codigo $orderBy LIMIT $Inicio,$nElements";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades, $initResult = false);
	
//ACESSÓRIOS PARA MONTAR PÁGINA================================================================================
 include("includes/functions.php");
//-------------------------------------------------------------------------------------------------------------

/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="1";
$Evento="Acessou a página de ".$_SESSION['TarefasNome']." - BBHive corporativo.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
$colspan = ""; $st = "display:none;";
	   if(!isset($paginaFluxo)){
		   $colspan = "colspan='2'"; $st="";
		   $naoMostra = true;
	   }
?>
<?php // ---------------------------------------||-------------------------------------------// ?>
<br />

<div id="profissional" style="margin-bottom:3px;<?php echo $st; ?>">&nbsp;</div>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="verdana_11" bgcolor="#E6E6E6">
    
      <tr>
        	<td width="43%" height="30" bgcolor="#D0D0D0" align="left"  <?php echo $colspan; ?>><strong><?php echo $_SESSION['TarefasNome']; ?><label><?php echo $textoPadrao; ?></label></strong></td>
            <?php if(!isset($naoMostra)) {?>
        	<td width="16%" align="left" bgcolor="#D0D0D0"><strong>Executor</strong></td>
            <?php } ?>
        	<td width="13%" align="left" bgcolor="#D0D0D0"><strong>Situa&ccedil;&atilde;o</strong></td>
        	<td width="11%" align="center" bgcolor="#D0D0D0"><strong>Iniciada em</strong></td>
        	<td width="11%" align="center" bgcolor="#D0D0D0"><strong> Finalizada em</strong></td>
            <td width="3%" align="center" bgcolor="#D0D0D0">&nbsp;</td>
       
        <td width="3%" bgcolor="#D0D0D0">&nbsp;</td>
      </tr> 
      
<?php  
	  $codFluxo = "";
	  $codAtivi	= "";
	  $tem		= 1;
	  while($row_Atividades = mysqli_fetch_assoc($Atividades)){ 
	   $link  = "1=1";
       if (isCurrentPage("/corporativo/servicos/bbhive/fluxo/index.php")) {
		$link = "&bbh_flu_codigo=$bbh_flu_codigo";
	   }
	   //VERIFICA SE ATIVIDADE TEM DESCISÃO A SER TOMADA====================================
	   $codModAti	= $row_Atividades['bbh_mod_ati_codigo'];
	   $codAtividade= $row_Atividades['bbh_ati_codigo'];
	   $nmModAti	= $row_Atividades['bbh_mod_ati_nome'];
	   $modAtiIcone = $row_Atividades['bbh_mod_ati_icone'];
	  // exit( var_dump( $row_Atividades ));
	   $oIcone = verificaAlternativas($database_bbhive, $bbhive, $codModAti, $codAtividade, $nmModAti, $modAtiIcone);
	   $oIcone = explode("|",$oIcone);
	   $Icone = $oIcone[0];
	   $bbh_mod_flu_codigo = @$oIcone[1];
	   //===================================================================================
	   //VERIFICA SE A TEREFA TEM SUBFLUXO==================================================
	   $IconeSub = verificaSubFluxoTarefa($database_bbhive, $bbhive, $codAtividade);
	   //===================================================================================
	   //VEFIFICA SE IRÁ EXIBIR DEPARTAMENTO OU NOME DO USUÁRIO=============================
	   $depCodigo	= $row_Depto['bbh_dep_codigo'];
	   $depUsuario	= $row_Atividades['bbh_dep_codigo'];
	   $depNome		= $row_Atividades['bbh_dep_nome'];
	   $usuNome		= $row_Atividades['bbh_usu_apelido'];
	   $usuDep 		= usuario_departamento($depCodigo, $depUsuario, $depNome, $usuNome);
	   //===================================================================================
?>
	<?php if($codFluxo!=$row_Atividades['bbh_flu_codigo']){ ?>
      <tr>
        <td height="25" colspan="7" align="left" bgcolor="#E7E7E7" style="border-bottom:solid 1px #666"><img src="/corporativo/servicos/bbhive/images/fluxograma.gif" align="absmiddle" /><strong>&nbsp;<?php echo converte($a = $row_Atividades['bbh_flu_titulo']); ?></strong></td>
   	  </tr> 
      <?php } 
	  //if($codAtivi!=$row_Atividades['bbh_ati_codigo']){ ?>
	<tr style="background:#<?php $i++; echo ( ($i%2) == 0 )?'ffffff':'ffffff' ;?>">      
      <td width="43%" height="30" align="left" <?php echo $colspan; ?>>
		&nbsp;
		<?php 
		
		echo $a = $row_Atividades['bbh_mod_ati_nome']; 
		?>
        
        </td>
        <?php if(!isset($naoMostra)) {?>
	  <td width="16%" align="left" ><?php echo $IconeSub; ?>&nbsp;<img src="/corporativo/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;<?php echo $usuDep; ?></td>
      <?php } ?>
	  <td width="13%" align="left" ><?php echo $a = $row_Atividades['bbh_sta_ati_nome']; ?></td>
   	  <td width="11%" align="center" ><?php 
				if(!empty($row_Atividades['bbh_ati_inicio_real'])){
					echo $a=arrumadata($row_Atividades['bbh_ati_inicio_real']);
				} else {
					echo "<div color:#F00'><span style='font-size:9px'>Início Previsto</span></div>";
					echo "<label style='color:#F00'>&nbsp;".arrumadata($row_Atividades['bbh_ati_inicio_previsto'])."</label>";			
				}
		?></td>
		<td width="11%" align="center" ><?php 
				if(!empty($row_Atividades['bbh_ati_final_real'])){
					echo $a=arrumadata($row_Atividades['bbh_ati_final_real']);
				} else {
					echo "<div color:#F00'><span style='font-size:9px'>Final previsto</span></div>";	
					echo "<label style='color:#F00'>&nbsp;".arrumadata($row_Atividades['bbh_ati_final_previsto'])."</label>";				
				}
		?></td>
        <td width="3%" align="center" ><a href="#@" onclick="return window.top.showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/acao/regra.php?bbh_ati_codigo=<?php echo $row_Atividades['bbh_ati_codigo']; ?>&<?php echo $link; ?>','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/detalhes.gif" border="0" title="Visualizar atividade" /></a></td>
      <td width="3%" align="center" ><?php 
			if(empty($row_Atividades['bbh_ati_final_real'])){
				echo '<img src="/corporativo/servicos/bbhive/images/atencao.gif" border="0" title="Atividade não concluída" />';
			} else {
				echo '<img src="/corporativo/servicos/bbhive/images/check.gif" border="0" title="Atividade finalizada" />';
			}
		?></td>
      </tr>
      <?php //} ?>
<?php
$codFluxo = $row_Atividades['bbh_flu_codigo']; 
}?>

    
    </table>
<br />
<?php if(!isset($_GET['exibeFrame'])){ ?>
<?php if($totalRows_Atividades==0){ ?>
<div align="center" class="verdana_11">Não há registros cadastrados</div>
<?php } ?>
    </td>
  </tr>
	<?php 
	if(!isset($_GET['bbh_flu_codigo'])){	
		require_once('../includes/paginacao/paginacao.php');
	} else {
		?>
<table width="98%" align="center" border="0" cellspacing="0" cellpadding="0" class="borderAlljanela verdana_12">      <tr>
      <td height="22" bgcolor="#F5F5ED"><a href="#@" onclick="showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|tarefas/index.php|includes/colunaDireita.php?fluxosDireita=1&tarefasDireita=1','menuEsquerda|colCentro|colDireita');">&nbsp;<img src="/corporativo/servicos/bbhive/images/ok.gif" border="0"/>
    &nbsp;&nbsp;Voltar para lista de <?php echo $_SESSION['TarefasNome']; ?></a></td>
      </tr>
    </table>    
    <?php } ?>
 <?php }  ?>
 
	<var style="display:none;">document.getElementById("profissional").innerHTML='&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/profile.gif" align="absmiddle" />&nbsp;<?php echo $usuDep; ?>';</var>