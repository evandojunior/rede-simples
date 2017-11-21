<?php
if(!isset($_SESSION)){ session_start(); } 
$SQL	= "";
$compl 	= "";
$strAud	= "";

//--Consulta com base no array==========================================================================
	if(isset($_SESSION[$nmSessao])){
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

//--Padrão de consulta verificando Array();
$and		 = " and bbh_rel_finalizado='0'";
$textoPadrao = ' " com relatórios em aberto"';
	
$and		 = "";
$textoPadrao = "";

if(isset($_SESSION[$nmSessao]) && $_SESSION[$nmSessao]['situacao'][0]==1){
	$acao = ($_SESSION[$nmSessao]['situacao'][3]);
	//--
	if($acao == "Fechados"){
		$and	 	 = " and bbh_rel_finalizado='1' ";
		$textoPadrao = ' "com relatórios fechados"';
	} elseif($acao == "Abertos"){
		$and	= " and bbh_rel_finalizado='0'";
		$textoPadrao = ' "com relatórios em aberto"';
	} elseif($acao == "Todos"){
		$and	= " ";
		$textoPadrao = ' "todos os relatórios"';
	} 
}
$SQL	.= $and;

	//select para descobrir o total de registros na base
	/*$query_Relatorios = "select count(bbh_rel_codigo) as total from bbh_relatorio where bbh_usu_codigo=".$_SESSION['usuCod']." $condicao";*/
	$query_Relatorios = "select 
   #dados do relatorio
   bbh_rel_codigo
    from bbh_relatorio
     inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo
     inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
	 left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo 
     inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
		Where
		 bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod']." $SQL
	      group by bbh_relatorio.bbh_ati_codigo";
    list($Relatorios, $row_Relatorios, $totalRows_Relatorios) = executeQuery($bbhive, $database_bbhive, $query_Relatorios);
	
	$page 		= "1";
	$nElements 	= "36";
		if(isset($_GET["page"])){
			$page 	= $_GET["page"];
		}
	$Inicio = ($nElements*$page)-$nElements;
	$homeDestino	= 'relatorios/index.php?Ts='.$_SERVER['REQUEST_TIME'];
	$exibe			= 'conteudoGeral';
	$pages 			= ceil($totalRows_Relatorios/$nElements);

	$query_Relatorios = "select 
   #dados do relatorio
   max(bbh_rel_codigo) bbh_rel_codigo, max(bbh_rel_data_criacao) bbh_rel_data_criacao, 
	  (select s.bbh_rel_titulo from bbh_relatorio as s where s.bbh_rel_codigo = max(bbh_relatorio.bbh_rel_codigo)) as bbh_rel_titulo, bbh_rel_finalizado,
	#dados do fluxo
	bbh_fluxo.bbh_flu_codigo, bbh_flu_titulo, bbh_flu_data_iniciado,
   #dados da atividade
   bbh_atividade.bbh_ati_codigo, bbh_mod_ati_nome,bbh_ati_inicio_real,bbh_ati_final_real,bbh_ati_final_previsto
    #somente os meus
    from bbh_relatorio
     inner join bbh_atividade on bbh_relatorio.bbh_ati_codigo = bbh_atividade.bbh_ati_codigo
     inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
	 left join bbh_protocolos on bbh_fluxo.bbh_flu_codigo = bbh_protocolos.bbh_flu_codigo 
     inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
		Where
		 bbh_atividade.bbh_usu_codigo=".$_SESSION['usuCod']." $SQL
	      group by bbh_relatorio.bbh_ati_codigo
 		   ORDER BY bbh_flu_codigo DESC, bbh_rel_codigo DESC LIMIT $Inicio,$nElements";
    list($Relatorios, $row_Relatorios, $totalRows_Relatorios) = executeQuery($bbhive, $database_bbhive, $query_Relatorios);
?>
<?php // ---------------------------//------------------------------------// ?>

<br/>    
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="1" class="verdana_11" bgcolor="#E6E6E6">
    
      <tr>
        	<td colspan="2" height="30" bgcolor="#D0D0D0" align="left"><strong><?php echo $_SESSION['TarefasNome']; ?></strong><label><?php echo $textoPadrao; ?></label></td>
        	
        	<?php /*<td width="8%" align="left" bgcolor="#D0D0D0"><strong>Situação</strong></td>*/?>
        	<td width="12%" align="center" bgcolor="#D0D0D0"><strong>Iniciada em</strong></td>
        	<td width="15%" align="center" bgcolor="#D0D0D0"><strong> Finalizada em</strong></td>
            <td width="5%" align="center" bgcolor="#D0D0D0">&nbsp;</td>
       		<td width="5%" bgcolor="#D0D0D0">&nbsp;</td>
      </tr> 
     
      
<?php if($totalRows_Relatorios>0) { ?> 
	  <?php 
	  $codFluxo = "";
	  $codAtivi	= "";
	  $tem		= 1;
	  $i = 0;
	  do{ 
	  	if($codFluxo!=$row_Relatorios['bbh_flu_codigo']){
	  ?>
      <tr>
        <td height="25" colspan="7" align="left" bgcolor="#E7E7E7" style="border-bottom:solid 1px #666"><img src="/corporativo/servicos/bbhive/images/fluxograma.gif" align="absmiddle" /><strong>&nbsp;<a href="#@" onClick="return  showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&fluxo=1|fluxo/index.php?menu=1&bbh_flu_codigo=<?php echo $row_Relatorios['bbh_flu_codigo']; ?>|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&bbh_flu_codigo=<?php echo $row_Relatorios['bbh_flu_codigo']; ?>&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');" title="Clique para visualizar detalhes do fluxo"><?php echo converte($a = $row_Relatorios['bbh_flu_titulo']); ?></a></strong></td>
   	  </tr> 
      <?php } 
	  //if($codAtivi!=$row_Relatorios['bbh_ati_codigo']){ ?>
	<tr style="background:#<?php $i++; echo ( ($i%2) == 0 )?'ffffff':'ffffff' ;?>">      
      <td height="30" colspan="2">
		&nbsp;
		<?php echo $a = $row_Relatorios['bbh_mod_ati_nome'] ." - ". $row_Relatorios['bbh_rel_titulo']; ?>
      </td>
	  
	 <?php /* <td width="8%" align="left" ><?php //echo $a = $row_Relatorios['concluido']."%"; ?> </td> */ ?>
      
   	  <td width="12%" align="center" ><?php echo $a = arrumadata($row_Relatorios['bbh_ati_inicio_real']); ?></td>
		<td width="15%" align="center" ><?php 
				if(!empty($row_Relatorios['bbh_ati_final_real'])){
					echo "&nbsp;".arrumadata($row_Relatorios['bbh_ati_final_real']);
				} else {
					echo "<div color:#F00'><span style='font-size:9px'>Final previsto</span></div>";
					echo "<label style='color:#F00'>&nbsp;".arrumadata($row_Relatorios['bbh_ati_final_previsto'])."</label>";			
				}
		?></td>
        <td width="5%" align="center" ><a href="#@" onclick="return showHome('includes/completo.php','conteudoGeral', 'perfil/index.php?perfil=1&tarefas=1|relatorios/painel/index.php?bbh_ati_codigo=<?php echo $row_Relatorios['bbh_ati_codigo']; ?>&bbh_rel=true','menuEsquerda|colPrincipal');"><img src="/corporativo/servicos/bbhive/images/relatorioII.gif" width="22" height="22" border="0" title="Visualizar relatório" /></a></td>
      <td width="5%" align="center" ><?php 
			if(empty($row_Relatorios['bbh_ati_final_real'])){
				echo '<img src="/corporativo/servicos/bbhive/images/atencao.gif" border="0" title="Relatório não concluído" />';
			} else {
				echo '<img src="/corporativo/servicos/bbhive/images/check.gif" border="0" title="Relatório finalizado" />';
			}
		?></td>
  </tr>
      <?php //} ?>

<?php 
	  	$codFluxo = $row_Relatorios['bbh_flu_codigo'];
		$codAtivi = $row_Relatorios['bbh_ati_codigo'];
		
	  } while ($row_Relatorios = mysqli_fetch_assoc($Relatorios)); ?>
<?php } else { ?>  
      <tr class="legandaLabel11">
        <td height="22" colspan="6" align="center">N&atilde;o h&aacute; registros cadastrados</td>
      </tr>
<?php } ?>
    </table>
	<?php require_once('../includes/paginacao/paginacao.php');?>

<br />
    </td>
  </tr>
  
	<?php 
	if(!isset($_GET['bbh_flu_codigo'])){	
		require_once('../includes/paginacao/paginacao.php');
	} else {
		?>

    <?php } ?>

