<?php if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
	  
 //sleep(5); ?>&nbsp;
 <div id="imgNovaFoto">
	<?php if(isset($_SESSION['MM_BBhive_Codigo'])){  ?> 
	<?php require_once('imagem.php'); ?>
    <?php }else{ echo " "; }?>
 </div>
<br />
<?php 
 	//recuperação de variáveis do GET e SESSÃO
  	foreach($_GET as $indice => $valor){
		if(($indice=="amp;menuEsquerda")||($indice=="menuEsquerda")){
			require_once("../includes/colunaEsquerda.php");
		}
		if(($indice=="amp;perfil")||($indice=="perfil")){
			if($valor > '1'){
				require_once("../includes/colunaEsquerda.php"); 
			}
		}
	}
?>