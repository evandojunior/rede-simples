<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Biometria extends RecoverConnection {
	public $bbp_adm_lock_bio_codigo;
	public $bbp_adm_lock_bio_email;
	public $bbp_adm_lock_bio_nome;
	public $bbp_adm_lock_bio_digital;

	public $myBio;
	public $row_Bio;
	public $totalRows_Bio;
	
	//inicia procedimentos da classe
	public function consultaBiometria($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

        $Bio_query ="select * FROM bbp_adm_lock_biometria ORDER BY bbp_adm_lock_bio_email ASC $compPaginacao";
        list($this->myBio, $this->row_Bio, $this->totalRows_Bio) = executeQuery($bbpass, $database_bbpass, $Bio_query);
	}
	public function consultaBiometriaN($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

        $Bio_query ="select b.bbp_adm_lock_bio_codigo, l.bbp_adm_lock_log_codigo, l.bbp_adm_lock_log_nome, l.bbp_adm_lock_log_email FROM bbp_adm_lock_biometria as b
        right join bbp_adm_lock_loginsenha as l on b.bbp_adm_lock_bio_email = l.bbp_adm_lock_log_email
        ORDER BY l.bbp_adm_lock_log_nome ASC $compPaginacao";

        list($this->myBio, $this->row_Bio, $this->totalRows_Bio) = executeQuery($bbpass, $database_bbpass, $Bio_query);
	}
	//utilizado para paginação
	public function totalBiometria($database_bbpass, $bbpass){
        $this->getConnection();

        $Bio_query ="select COUNT(bbp_adm_lock_bio_codigo) as TOTAL FROM bbp_adm_lock_biometria";
        list($Bio, $row_Bio, $totalRows) = executeQuery($bbpass, $database_bbpass, $Bio_query);

        return $row_Bio['TOTAL'];
	}
	public function totalBiometriaN($database_bbpass, $bbpass){
        $this->getConnection();

        $Bio_query ="select COUNT(bbp_adm_lock_log_codigo) as TOTAL FROM bbp_adm_lock_biometria as b
        right join bbp_adm_lock_loginsenha as l on b.bbp_adm_lock_bio_email = l.bbp_adm_lock_log_email";

        list($Bio, $row_Bio, $totalRows) = executeQuery($bbpass, $database_bbpass, $Bio_query);

        return $row_Bio['TOTAL'];
	}
	//Exclui Biometria
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_lock_bio_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_lock_biometria Where bbp_adm_lock_bio_codigo=" . $this->bbp_adm_lock_bio_codigo;
            list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
	//Cadastra Biometria
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();

        $insertSQL = "INSERT INTO bbp_adm_lock_biometria (bbp_adm_lock_bio_nome,bbp_adm_lock_bio_email,bbp_adm_lock_bio_chave) VALUES ('".$this->bbp_adm_lock_bio_nome."', '".$this->bbp_adm_lock_bio_email."', '".$this->bbp_adm_lock_bio_digital."')";
        list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//verifica Login Senha repetido
	public function verificaRepetido($database_bbpass, $bbpass, $notIn){
        $this->getConnection();

        $Log_query ="select COUNT(bbp_adm_lock_bio_codigo) as TOTAL FROM bbp_adm_lock_biometria Where bbp_adm_lock_bio_email='".$this->bbp_adm_lock_bio_email."' $notIn";
        list($Log, $row_Log, $totalRows) = executeQuery($bbpass, $database_bbpass, $Log_query);

        return $row_Log['TOTAL'];
	}
}