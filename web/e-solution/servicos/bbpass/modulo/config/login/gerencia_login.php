<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Login extends RecoverConnection {
	public $bbp_adm_lock_log_codigo;
	public $bbp_adm_lock_log_nome;
	public $bbp_adm_lock_log_email;
	public $bbp_adm_lock_log_senha;
	public $bbp_adm_lock_log_nasc;
	public $bbp_adm_lock_log_cargo;
	public $bbh_adm_lock_log_sexo;
	public $bbp_adm_lock_log_obs;
	public $bbp_adm_lock_log_ativo;

	public $myLog;
	public $row_Log;
	public $totalRows_Log;
	
	//inicia procedimentos da classe
	public function consultaLogin($database_bbpass, $bbpass, $compPaginacao){
	    $this->getConnection();

		$Log_query ="select * FROM bbp_adm_lock_loginsenha ORDER BY bbp_adm_lock_log_email ASC $compPaginacao";
        list($this->myLog, $this->row_Log, $this->totalRows_Log) = executeQuery($bbpass, $database_bbpass, $Log_query);
	}
	//utilizado para paginação
	public function totalLogin($database_bbpass, $bbpass){
        $this->getConnection();

		$Log_query ="select COUNT(bbp_adm_lock_log_codigo) as TOTAL FROM bbp_adm_lock_loginsenha";
        list($Log, $row_Log, $totalRows) = executeQuery($bbpass, $database_bbpass, $Log_query);

		return $row_Log['TOTAL'];
	}
	//dados do Modulo
	public function dadosLogin($database_bbpass, $bbpass, $bbp_adm_lock_log_codigo){
        $this->getConnection();

		$Log_query ="select * FROM bbp_adm_lock_loginsenha Where bbp_adm_lock_log_codigo=".$bbp_adm_lock_log_codigo;
        list($Log, $row_Log, $totalRows) = executeQuery($bbpass, $database_bbpass, $Log_query);
		  
        $this->bbp_adm_lock_log_codigo	= $row_Log['bbp_adm_lock_log_codigo'];
        $this->bbp_adm_lock_log_nome	= $row_Log['bbp_adm_lock_log_nome'];
        $this->bbp_adm_lock_log_email	= $row_Log['bbp_adm_lock_log_email'];
        $this->bbp_adm_lock_log_senha	= $row_Log['bbp_adm_lock_log_senha'];
        $this->bbp_adm_lock_log_nasc	= $row_Log['bbp_adm_lock_log_nasc'];
        $this->bbp_adm_lock_log_cargo	= $row_Log['bbp_adm_lock_log_cargo'];
        $this->bbh_adm_lock_log_sexo	= $row_Log['bbh_adm_lock_log_sexo'];
        $this->bbp_adm_lock_log_obs		= $row_Log['bbp_adm_lock_log_obs'];
        $this->bbp_adm_lock_log_ativo	= $row_Log['bbp_adm_lock_log_ativo'];
	}
	//verifica Login Senha repetido
	public function verificaRepetido($database_bbpass, $bbpass, $notIn){
        $this->getConnection();
	    $Log_query ="select COUNT(bbp_adm_lock_log_codigo) as TOTAL FROM bbp_adm_lock_loginsenha Where bbp_adm_lock_log_email='".$this->bbp_adm_lock_log_email."' $notIn";
        list($Log, $row_Log, $totalRows) = executeQuery($bbpass, $database_bbpass, $Log_query);

		return $row_Log['TOTAL'];
	}
	//Cadastra Login Senha
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();
		$insertSQL = "INSERT INTO bbp_adm_lock_loginsenha (bbp_adm_lock_log_nome,bbp_adm_lock_log_email,bbp_adm_lock_log_senha,bbh_adm_lock_log_sexo,bbp_adm_lock_log_ativo) VALUES ('".$this->bbp_adm_lock_log_nome."', '".$this->bbp_adm_lock_log_email."', '".$this->bbp_adm_lock_log_senha."','".$this->bbh_adm_lock_log_sexo."','".$this->bbp_adm_lock_log_ativo."')";

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//Edita Login Senha
	public function atualizaDados($database_bbpass, $bbpass, $complSenha){
        $this->getConnection();
	    $updateSQL = "UPDATE bbp_adm_lock_loginsenha SET bbp_adm_lock_log_nome='".$this->bbp_adm_lock_log_nome."', bbp_adm_lock_log_email='".$this->bbp_adm_lock_log_email."',bbh_adm_lock_log_sexo='".$this->bbh_adm_lock_log_sexo."', bbp_adm_lock_log_ativo='".$this->bbp_adm_lock_log_ativo."' $complSenha Where bbp_adm_lock_log_codigo=".$this->bbp_adm_lock_log_codigo;

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//Exclui Login Senha
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $deleteSQL = "DELETE from bbp_adm_lock_loginsenha Where bbp_adm_lock_log_codigo=".$this->bbp_adm_lock_log_codigo;

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
	}
}