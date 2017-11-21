<?php
  /* if(isset($_GET['fluxo'])){
	if($_GET['fluxo']==1){
		require_once("../fluxo/menuEsquerda.php");
	}
   }
   if(isset($_GET['mensagens'])){
	if($_GET['mensagens']==1){
		require_once("../mensagens/menuEsquerda.php");
	}
   }
   if(isset($_GET['tarefas'])){
	if($_GET['tarefas']==1){
		require_once("../tarefas/menuEsquerda.php");
	}
   }
   if(isset($_GET['arquivos'])){
	if($_GET['arquivos']==1){
		require_once("../arquivos/menuEsquerda.php");
	}
   }
   if(isset($_GET['equipe'])){
	if($_GET['equipe']==1){
		require_once("../equipe/menuEsquerda.php");
	}
   }*/

foreach($_GET as $indice=>$valor){
		if(($indice=="amp;fluxo")||($indice=="fluxo")){ 			require_once("../fluxo/menuEsquerda.php"); } 
		if(($indice=="amp;mensagens")||($indice=="mensagens")){ 	require_once("../mensagens/menuEsquerda.php"); } 
		if(($indice=="amp;tarefas")||($indice=="tarefas")){ 		require_once("../tarefas/includes/menuEsquerda.php"); } 
		if(($indice=="amp;arquivos")||($indice=="arquivos")){ 		require_once("../arquivos/menuEsquerda.php"); } 
		if(($indice=="amp;equipe")||($indice=="equipe")){ 			require_once("../equipe/menuEsquerda.php"); } 
		if(($indice=="amp;relatorios")||($indice=="relatorios")){ 	require_once("../relatorios/menuEsquerda.php"); } 
		//if($indice=="perfis"){ 										require_once("perfilSelecionado.php"); } 
}
   /*if(isset($_GET['relatorios'])){
	if($_GET['relatorios']==1){
		require_once("../relatorios/menuEsquerda.php");
	}
   }


   if(isset($_GET['perfis'])){
	if($_GET['perfis']==1){
		require_once("perfilSelecionado.php");
	}
   }*/
?>