<?php
//FLUXO EM QUESTÃO
require_once('../fluxo/padrao.php');
	
?>	
<table width="172" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-left:0px;">
  <tr>
    <td height="28" align="left" background="/corporativo/servicos/bbhive/images/miniTop.jpg" class="verdana_12">
    <label style="margin-left:5px;">&nbsp;<strong>Equipe</strong></label>
    </td>
  </tr>
  <tr>
    <td height="22" valign="top" style="border-left:#D7D7D7 solid 1px; border-right:#D7D7D7 solid 1px;">
<?php if($totalRows_Fluxos>0) { 

 $bbh_flu_codigo = $row_Fluxos['bbh_flu_codigo'];


$query_equipe = "select 
bbh_atividade.bbh_usu_codigo, bbh_usu_identificacao, bbh_usu_apelido, bbh_dep_nome, bbh_usuario.bbh_dep_codigo, bbh_usu_sexo
from bbh_atividade
      inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
      inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
	  inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
           Where bbh_flu_codigo = $bbh_flu_codigo
                GROUP by bbh_atividade.bbh_usu_codigo";
list($equipe, $row_equipe, $totalRows_equipe) = executeQuery($bbhive, $database_bbhive, $query_equipe);

//verifica departamento do usuário logado
$query_Depto = "select bbh_dep_codigo from bbh_usuario Where bbh_usu_codigo=".$_SESSION['usuCod'];
list($Depto, $row_Depto, $totalRows_Depto) = executeQuery($bbhive, $database_bbhive, $query_Depto);
?>  
    <table width="170">
    <tr>
      <td height="1" width="52" align="center"></td>
      <td height="1" width="52" align="center"></td>
      <td height="1" width="52" align="center"></td>
    </tr>
    <tr>
    <?php 
	$cont=0;
	$contaFlux=0;
	do { 
	 //if($contaFlux<9){
		if($cont==3){
			echo '</tr>
			    <tr>
				  <td height="3" align="center"></td>
				  <td height="3" align="center"></td>
				  <td height="3" align="center"></td>
				</tr>
				<tr>';
			$cont=0;
		}
		
		//verifica se tenho miniatura
		$codigo = $row_equipe['bbh_usu_codigo'];
		$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo.".jpg";
		
		//Foto miniatura
		$FotoMini= "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo."_mini.jpg";
		
		if(file_exists($FotoMini)){
			$FotoMini= "/datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo."_mini.jpg";
		
		} elseif(file_exists($ImagemOriginal)){
			$Foto 	= redimencionaImg($ImagemOriginal, $codigo);
			//Foto miniatura
			$FotoMini= "/datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo."_mini.jpg";
		} else {
			//verifico o sexo pois vou gerar miniatura
				if($row_equipe['bbh_usu_sexo']=="1"){
					$icone = "../../../../corporativo/servicos/bbhive/images/icone_H.jpg";
					$detIcone = "icone_H.jpg";
				} else {
					$icone = "../../../../corporativo/servicos/bbhive/images/icone_M.jpg";
					$detIcone = "icone_M.jpg";
				} 
				
			//verifico se existe diretório
			$diretorio = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo;
			if(!file_exists($diretorio)) {	
				mkdir($diretorio, 777);
				chmod($diretorio,0777);
			}
			
			if(!file_exists($diretorio."/images")) {	
				mkdir($diretorio."/images", 777);
				chmod($diretorio."/images",0777);
			}
		
			//copio arquivo padrão para pasta do usuário	
			$destIcone = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$detIcone;
			copy($icone, $destIcone);

			$ImagemOriginal = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$detIcone;
			$Foto 	= redimencionaImg($ImagemOriginal, $codigo);
			//Foto miniatura
			$FotoMini= "/datafiles/servicos/bbhive/corporativo/perfis/".$codigo."/images/".$codigo."_mini.jpg";
		}
			
			//caso seja do mesmo departamento que o meu exibo o nome
			if($row_Depto['bbh_dep_codigo']==$row_equipe['bbh_dep_codigo']){
				$nome = $row_equipe['bbh_usu_apelido'];
			} else {
				$nome = $row_equipe['bbh_dep_nome'];
			}
	?>
        <td width="50" height="41" align="center" class="tbTarefasMini">
            <a href="#0" style="cursor:pointer;" title="header=[<span class='verdana_11'><?php echo $nome; ?></span>] body=[<span class='verdana_11'>Clique para verificar...</span>]">
                <!-- <img src="/corporativo/servicos/bbhive/images/btnFluxo.gif" border="0" style="margin-left:5px;" />-->
                <img src="<?php echo $FotoMini; ?>" border="0" style="margin-left:5px; margin-top:1px;" />
                <div style="height:10px; margin-top:-7px;"></div>
            <?php //echo $row_equipe['bbh_usu_codigo']; ?>
            </a>
        </td>
    <?php $cont = $cont + 1; $contaFlux=$contaFlux+1;
	 //}
	} while($row_equipe = mysqli_fetch_assoc($equipe)); ?>

      </tr>
    </table>
<?php } else { echo "<span class='verdana_9'>N&atilde;o h&aacute; registros dispon&iacute;veis.&nbsp;</span>"; } ?>    
    </td>
  </tr>
  <tr>
    <td height="10" align="right" style="border-left:#D7D7D7 solid 1px; border-bottom:#D7D7D7 solid 1px; border-right:#D7D7D7 solid 1px;" class="verdana_9">&nbsp;</td>
  </tr>
</table>
<br />