<?php
$gerencia 		= new GerenciaSessao();//inicio da classe
$gerencia->inicio();//grava informações nas variáveis
$gerencia->criaSessaoXML($gerenciaXML, $gerencia->caminhoXML);//coloca autenicados na sessão
?>