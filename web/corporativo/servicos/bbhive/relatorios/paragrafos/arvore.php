<?php  if(!isset($_SESSION)){ session_start(); } 
	if(isset($_GET['nivelGrupo'])){
		include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
		include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
		include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");
		$Pai = 0;
			$SQL = $_GET['nivelGrupo'].".%";
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
?>

<?php if($totalRows_Arvore>0){?>
 <?php do{ 
    $CodigoPai 	= $row_Arvore['bbh_tip_flu_codigo'];
    $Conta		= $row_Arvore['bbh_tip_flu_identificacao'];
	$complemento= "";
	
		if(isset($_GET['bbh_pro_codigo'])){
			$complemento = "&bbh_pro_codigo=".$_GET['bbh_pro_codigo'];
		}
		if(isset($_GET['bbh_ati_codigo'])){
			$complemento = "&bbh_ati_codigo=".$_GET['bbh_ati_codigo'];
		}
    ?>    
	<div>
    	<div style="display:inline">
        	<a href="#@" onClick=" return elementoArvore('Tagfilho_<?php echo $CodigoPai; ?>','/corporativo/servicos/bbhive/relatorios/paragrafos/arvore.php?timeStamp=<?php echo time(); ?>&nivelGrupo=<?php echo $Conta; ?><?php echo $complemento; ?>');">
            	<img src="/e-solution/servicos/bbhive/images/debito.gif" id="icone_<?php echo $CodigoPai; ?>" border="0" align="absmiddle" />
            </a>
        </div>
        <div style="display:inline;margin-left:3px;" class="<?php if($Pai==1){ echo "verdana_9_bold"; } else { echo "verdana_9"; }  ?>">
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
				GROUP by bbh_mod_flu_codigo
			order by bbh_mod_flu_nome asc";
		list($Fluxos, $row_Fluxos, $totalRows_Fluxos) = executeQuery($bbhive, $database_bbhive, $query_Fluxos);
		
				if($totalRows_Fluxos>0){
						$onClick = "onclick=\"return LoadSimultaneo('perfil/index.php?perfil=1&relatorios=1|relatorios/paragrafos/regra2.php?bbh_tip_flu_codigo=$CodigoPai".$complemento."','menuEsquerda|colPrincipal');\"";
						echo "<a href='#@' $onClick><span class='color'><u>".normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']."</u><span></a>"; 				
				} else {
						echo "<span style='color:#000'>".normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']."</span>";
				}
		
			  } else {
					echo "<span style='color:#000'>".normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']."</span>"; 
			  } ?>
		&nbsp;
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