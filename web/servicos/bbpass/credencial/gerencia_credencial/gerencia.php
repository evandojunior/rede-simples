<?php
if(!isset($_SESSION)){session_start();}
require_once($_SESSION['caminhoFisico']."/Connections/bbpass.php");
require_once($_SESSION['caminhoFisico']."/servicos/bbpass/credencial/gerencia_credencial/gerencia_xml.php");
//session_regenerate_id();
//session_id();
//sessão atual

class GerenciaSessao{
	public $sessaoCapturada;
	public $docXML;
	public $caminhoXML;
	public $emailLogado;
	
	//constrói o ínicio da sessão
	function inicio(){
		$this->sessaoCapturada	= session_id();
		$this->emailLogado		= $_SESSION['EmailTratado'];
		$this->caminhoXML 		= $_SESSION['caminhoFisico']."/datafiles/servicos/bbpass/credencial/";
		
		if(!file_exists($this->caminhoXML)){
			mkdir($this->caminhoXML,777);
			chmod($this->caminhoXML,0777);
		}
	}
	//Lista de módulos cadastrados no sitema
	public function listaModulos($database_bbpass, $bbpass){
		//caminho do módulo e-solution
		require_once($_SESSION['caminhoFisico']."/servicos/bbpass/modulo/gerencia_modulo.php");
		$modulo 				= new Modulo();//instância classe de módulos
		$modulosCadastrados		= $modulo->adicionaArray($database_bbpass, $bbpass);
		
		return $modulosCadastrados;
	}
	//verifica se tem sessão criada igual ao xml
	public function verificaXML($database_bbpass, $bbpass, $gerencia, $gerenciaXML,$caminhoXML){
		$gerenciaXML->xmlExiste($database_bbpass, $bbpass, $gerencia, $this->emailLogado,$caminhoXML);//verifica na classe XML
	}
	//cria XML com os dados de todos os locks, sem autenticação
	public function criaSessaoXML($gerenciaXML, $caminhoXML){
		@$gerenciaXML->leXML($this->emailLogado,$caminhoXML);
	}
	//Verifica se a sessão é igual a do XML
	public function sessaoIgual(){
		$gerenciaXML 	= new gerenciaXML();//inicio da classe XML
		$gerenciaXML->sessaoXML($this->sessaoCapturada,$this->emailLogado,$this->caminhoXML);
	}
	//verifica módulo autenticado
	public function moduloLiberado($nmSessao,$caminhoObjXML,$idLockLiberado){
		$gerenciaXML 	= new gerenciaXML();//inicio da classe XML
		$gerenciaXML->escreveXML($nmSessao,$caminhoObjXML,$idLockLiberado);
	}
	//efetua a baixa do módulo autenticado
	public function destroiLock($nmSessao,$caminhoObjXML,$idLockLiberado){
		$gerenciaXML 	= new gerenciaXML();//inicio da classe XML
		$gerenciaXML->destroiLockXML($nmSessao,$caminhoObjXML,$idLockLiberado);
	}
	//responsável por zerar a sessão inciada
	public function resetaSessao(){
		session_regenerate_id();//zera sessão
	}
	//mensagem padrão, nínguém exibe nada somente este método
	public function mensagemResultado(){
		
	}
}

$gerencia 		= new GerenciaSessao();//inicio da classe
$gerencia->inicio();//grava informações nas variáveis

$gerenciaXML 	= new gerenciaXML();//inicio da classe XML
$gerencia->verificaXML($database_bbpass, $bbpass, $gerencia, $gerenciaXML, $gerencia->caminhoXML);//verifica se XML existe, se não existir ele cria objeto

$gerencia->criaSessaoXML($gerenciaXML, $gerencia->caminhoXML);//coloca autenicados na sessão

?>