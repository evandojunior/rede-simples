<?php
if(!isset($_SESSION)){ session_start(); } 

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

/*
?>
<table width="172" border="0" cellspacing="0" cellpadding="0">
 <?php if(isset($_GET['equipeFluxos'])){ ?>
  <tr>
    <td>
    	<?php require_once("../equipe/menuFluxos.php"); ?>
    </td>
  </tr>
 <?php } ?>
  
 <?php if(isset($_GET['arquivosFluxos'])){ ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
		<?php require_once("../arquivos/menuFluxos.php"); ?>
    </td>
  </tr>
  <?php } ?>
  
 <?php if(isset($_GET['fluxosDireita'])){ ?>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
		<?php require_once("../fluxo/menu.php");; ?>
    </td>
  </tr>
  <?php } ?>
</table>

<?php
exit;
/*
 //Equipe
   if(isset($_GET['equipe'])){
	if($_GET['equipe']==1){
		require_once("../equipe/menu.php");
	}
   }*/
   
 //Equipe da parte de Mensagens
   /*if(isset($_GET['equipeMensagens'])){
	if($_GET['equipeMensagens']==1){
		require_once("../equipe/menuMensagens.php");
	}
   }*/
   
 //Equipe da parte de Fluxos
   /*if(isset($_GET['equipeFluxos'])){
	if($_GET['equipeFluxos']==1){
	  echo "<div>";
		require_once("../equipe/menuFluxos.php");
	  echo "</div>";
	}
   }*/
  
  //Arquivos
   /*if(isset($_GET['arquivos'])){
	if($_GET['arquivos']==1){
		require_once("../arquivos/menu.php");
	}
   }*/
   //Arquivos Fluxos

  /* if(isset($_GET['arquivosFluxos'])){
	if($_GET['arquivosFluxos']==1){
	  echo "<div>";
		require_once("../arquivos/menuFluxos.php");
	  echo "</div>";
	}
   }*/
   
   //Relatórios
  /* if(isset($_GET['relatorios'])){
	if($_GET['relatorios']==1){
		require_once("../relatorios/menu.php");
	}
   }*/
	
   //Tarefas
   /*if(isset($_GET['tarefasDireita'])){
	if($_GET['tarefasDireita']==1){
		require_once("../tarefas/menu.php");
	}
   }*/
   
   //Fluxos/Processos
   /*if(isset($_GET['fluxosDireita'])){
	if($_GET['fluxosDireita']==1){
		//require_once("../fluxo/menu.php");
	}
   }*/
	
   //Eventos
   /*if(isset($_GET['eventos'])){
	if($_GET['eventos']==1){
		require_once("../eventos/menu.php");
	}
   }*/
   
   //Arquivos da Equipe
   /*if(isset($_GET['equipeArquivos'])){
	if($_GET['equipeArquivos']==1){
		require_once("../arquivos/menuDireita.php");
	}
   }*/
?>