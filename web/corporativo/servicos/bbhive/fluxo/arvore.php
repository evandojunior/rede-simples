<?php
if(!isset($_SESSION)){ session_start(); }
	if(isset($_GET['nivelGrupo'])){
		include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
		include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
		include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
		$Pai = 0;
			$SQL = $_GET['nivelGrupo'].".__";
		//Ajustes SQL
	} else {
		//Ajustes SQL
		$SQL = "__";
		$Pai = 1;		
	}

	$query_Arvore = "select bbh_tipo_fluxo.bbh_tip_flu_codigo, bbh_tip_flu_identificacao, bbh_tip_flu_nome,
			count(bbh_modelo_fluxo.bbh_tip_flu_codigo) as Total
			from bbh_tipo_fluxo
			 left join bbh_modelo_fluxo on bbh_tipo_fluxo.bbh_tip_flu_codigo = bbh_modelo_fluxo.bbh_tip_flu_codigo
			  Where bbh_tip_flu_identificacao LIKE '$SQL'
			   group by 1
				  order by bbh_tip_flu_identificacao asc";
    list($Arvore, $row_Arvore, $totalRows_Arvore) = executeQuery($bbhive, $database_bbhive, $query_Arvore);

	foreach($_GET as $indice=>$valor){
		if(($indice=="amp;consulta")||($indice=="consulta")){ $consulta = "&consulta=true"; }
		if(($indice=="amp;consultaTarefa")||($indice=="consultaTarefa")){ $consultaTarefa = "&consultaTarefa=true"; }
		if(($indice=="amp;consultaFluxo")||($indice=="consultaFluxo")){ $consultaFluxo = "&consultaFluxo=true"; }
	}

	$oLink = "perfil/index.php?perfil=1&fluxo=1|fluxo/regra2.php";//LINK DE CONSULTA	
	$onde  = "colPrincipal";
	$consul= "";
		//LINK DE CONSULTA
		if(getCurrentPage()=="/corporativo/servicos/bbhive/consulta/avancada/regra.php" || isset($consulta)){
			$oLink = "perfil/index.php?perfil=1&perfis=1|consulta/avancada/regra2.php";
			$onde  = "conteudoGeral";
			$consul= "&consulta=true";
		} elseif(getCurrentPage()=="/corporativo/servicos/bbhive/tarefas/avancada/regra.php" || isset($consultaTarefa)){
			$oLink = "perfil/index.php?perfil=1&tarefas=1|tarefas/avancada/regra2.php";
			$onde  = "conteudoGeral";
			$consul= "&consultaTarefa=true";
		} elseif(getCurrentPage() == "/corporativo/servicos/bbhive/fluxo/busca/regra.php" || isset($consultaFluxo)){
			$oLink = "perfil/index.php?perfil=1&fluxo=1|fluxo/busca/regra2.php";
			$onde  = "conteudoGeral";
			$consul= "&consultaFluxo=true";
		}

	if(isset($_GET['filho'])){
	?>
	<var style="display:none">
		document.getElementById("cont_populado_<?php echo $_GET['filho']; ?>").value = "1";
	</var>
<?php }
 if($totalRows_Arvore>0){?>
 <?php do{ 
    $CodigoPai 	= $row_Arvore['bbh_tip_flu_codigo'];
    $Conta		= $row_Arvore['bbh_tip_flu_identificacao'];
	$complemento= "";
	
		if(isset($_GET['bbh_pro_codigo'])){
			$complemento = "&bbh_pro_codigo=".$_GET['bbh_pro_codigo'];
		}
		if(isset($_GET['anexar_fluxo']) && isset($_GET['bbh_pro_codigo'])){
			$complemento = "&bbh_pro_codigo=".$_GET['bbh_pro_codigo']."&anexar_fluxo=true";
		}
		if(isset($_GET['bbh_ati_codigo'])){
			$complemento = "&bbh_ati_codigo=".$_GET['bbh_ati_codigo'];
		}
		$complemento.= "&filho=".$CodigoPai;
    ?>  
	<div style="height:20px;" class="verdana_12">
    	<div style="display:inline">
        	<a href="#@" onClick=" return elementoArvore('Tagfilho_<?php echo $CodigoPai; ?>','/corporativo/servicos/bbhive/fluxo/arvore.php?timeStamp=<?php echo time(); ?>&nivelGrupo=<?php echo $Conta; ?><?php echo $complemento; ?><?php echo $consul; ?>');">
            	<img src="/e-solution/servicos/bbhive/images/debito.gif" id="icone_<?php echo $CodigoPai; ?>" border="0" align="absmiddle" />
            </a>
        </div>
        <div style="display:inline;margin-left:3px;" class="<?php if($Pai==1){ echo "verdana_9"; } else { echo "verdana_9"; }  ?>">
        <?php /*<a href="#@" onclick="javascript: document.getElementById('bbh_tip_flu_codigo').value='<?php echo $CodigoPai; ?>'; document.getElementById('titTipo').innerHTML='<?php echo normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']; ?>'; document.getElementById('escolhe').className='hide'; document.getElementById('adicionado').className='show'; document.getElementById('insereModelo').disabled=0; document.getElementById('carregaTipo').innerHTML='';">*/ ?>
        <?php if($row_Arvore['Total']>0){
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
			
			Where bbh_usu_codigo = ".$_SESSION['usuCod']." and bbh_modelo_fluxo.bbh_tip_flu_codigo = $CodigoPai
			and bbh_mod_flu_sub='0'
				GROUP by bbh_mod_flu_codigo
			order by bbh_mod_flu_nome asc";
		list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
		
				if($totalRows_Fluxos>0){
				
						$onClick = "onclick=\"return LoadSimultaneo('".$oLink."?bbh_tip_flu_codigo=$CodigoPai".$complemento."','menuEsquerda|".$onde."');\"";
						echo "<a href='#@' $onClick><span class='color'><u>".normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']."</u><span></a>"; 				
				} else {
						echo normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome'];
				}
		
			  } else {
					echo normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']; 
			  } /*?>
		</a>*/?>

        <input name="cont_populado_<?php echo $CodigoPai; ?>" type="hidden" id="cont_populado_<?php echo $CodigoPai; ?>" value="0" size="10" /></div>
    </div>
    
    <!--FILHO-->
    <div id="Tagfilho_<?php echo $CodigoPai; ?>" style="margin-left:15px;display:none">
    	<div id="conteudo_<?php echo $CodigoPai; ?>">
    	&nbsp;
        </div>
    </div>
 <?php } while ($row_Arvore = mysqli_fetch_assoc($Arvore));  ?>
<?php } ?>
