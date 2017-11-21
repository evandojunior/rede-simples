<?php
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");


	if(isset($_GET['nivelGrupo'])){
		$Pai = 0;
			$SQL = "".$_GET['nivelGrupo'].".__";
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
	$complemento= "&filho=".$CodigoPai;
    ?>  
	<div style="line-height:20px;">
    	<div style="display:inline">
        	<a href="#@" onClick=" return elementoArvore('Tagfilho_<?php echo $CodigoPai; ?>','/e-solution/servicos/bbhive/fluxos/tiposFluxos/arvore.php?timeStamp=<?php echo time(); ?>&nivelGrupo=<?php echo $Conta; ?><?php echo $complemento; ?>');">
            	<img src="/e-solution/servicos/bbhive/images/debito.gif" id="icone_<?php echo $CodigoPai; ?>" border="0" align="absmiddle" />
            </a>
        </div>
        <div style="display:inline;margin-left:3px;" class="<?php if($Pai==1){ echo "verdana_9_bold"; } else { echo "verdana_9"; }  ?>">
        <?php echo normatizaCep($Conta)."&nbsp;&nbsp;&nbsp;".$row_Arvore['bbh_tip_flu_nome']; ?>
        <input name="cont_populado_<?php echo $CodigoPai; ?>" type="hidden" id="cont_populado_<?php echo $CodigoPai; ?>" value="0" size="10" /></div>
    </div>
    
    <!--FILHO-->
    <div id="Tagfilho_<?php echo $CodigoPai; ?>" style="margin-left:15px;display:none;line-height:20px;">
    	<div id="conteudo_<?php echo $CodigoPai; ?>">
    	&nbsp;
        </div>
    </div>
 <?php } while ($row_Arvore = mysqli_fetch_assoc($Arvore));  ?>
<?php } ?>