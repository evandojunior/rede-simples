<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Firewall extends RecoverConnection {
	public $bbp_adm_lock_fir_ip;
	public $bbp_adm_lock_fir_obs;
	public $bbp_adm_lock_fir_codigo;

	public $myFire;
	public $row_Fire;
	public $totalRows_Fire;
	
	//inicia procedimentos da classe
	public function consultaFirewall($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

		$Fire_query ="select * FROM bbp_adm_lock_firewall ORDER BY bbp_adm_lock_fir_ip ASC $compPaginacao";

        list($this->myFire, $this->row_Fire, $this->totalRows_Fire) = executeQuery($bbpass, $database_bbpass, $Fire_query);
	}
	//utilizado para paginação
	public function totalFirewall($database_bbpass, $bbpass){
        $this->getConnection();

		$Fire_query ="select COUNT(bbp_adm_lock_fir_ip) as TOTAL FROM bbp_adm_lock_firewall";
        list($Fire, $row_Fire, $totalRows) = executeQuery($bbpass, $database_bbpass, $Fire_query);

		return $row_Fire['TOTAL'];
	}
	//dados do Firewall
	public function dadosFirewall($database_bbpass, $bbpass, $bbp_adm_lock_fir_codigo){
        $this->getConnection();

	    $Fire_query ="select * FROM bbp_adm_lock_firewall Where bbp_adm_lock_fir_codigo=".$bbp_adm_lock_fir_codigo;
        list($Fire, $row_Fire, $totalRows) = executeQuery($bbpass, $database_bbpass, $Fire_query);
		  
		$this->bbp_adm_lock_fir_ip		= $row_Fire['bbp_adm_lock_fir_ip'];
		$this->bbp_adm_lock_fir_obs		= $row_Fire['bbp_adm_lock_fir_obs'];
		$this->bbp_adm_lock_fir_codigo	= $row_Fire['bbp_adm_lock_fir_codigo'];
	}
	//verifica Firewall repetido
	public function verificaRepetido($database_bbpass, $bbpass, $notIn){
        $this->getConnection();

		$Fire_query ="select COUNT(bbp_adm_lock_fir_codigo) as TOTAL FROM bbp_adm_lock_firewall Where bbp_adm_lock_fir_ip='".$this->bbp_adm_lock_fir_ip."' $notIn";
        list($Fire, $row_Fire, $totalRows) = executeQuery($bbpass, $database_bbpass, $Fire_query);

		return $row_Fire['TOTAL'];
	}
	//Cadastra Firewall
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();

        $insertSQL = "INSERT INTO bbp_adm_lock_firewall (bbp_adm_lock_fir_ip,bbp_adm_lock_fir_obs) VALUES ('".$this->bbp_adm_lock_fir_ip."', '".$this->bbp_adm_lock_fir_obs."')";
        list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//Edita Firewall
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $updateSQL = "UPDATE bbp_adm_lock_firewall SET bbp_adm_lock_fir_ip='".$this->bbp_adm_lock_fir_ip."', bbp_adm_lock_fir_obs='".$this->bbp_adm_lock_fir_obs."' Where bbp_adm_lock_fir_ip=".$this->bbp_adm_lock_fir_ip;
        list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//Exclui Firewall
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_lock_fir_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_lock_firewall Where bbp_adm_lock_fir_codigo=" . $this->bbp_adm_lock_fir_codigo;
            list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
}