<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Assinatura extends RecoverConnection {
	public $bbp_adm_lock_ass_codigo;
	public $bbp_adm_lock_ass_nome;
	public $bbp_adm_lock_ass_email;
	public $bbp_adm_lock_ass_cpf;
	public $bbp_adm_lock_ass_acesso;
	public $bbp_adm_lock_ass_obs;

	public $myAss;
	public $row_Ass;
	public $totalRows_Ass;
	
	//inicia procedimentos da classe
	public function consultaAssinatura($database_bbpass, $bbpass, $compPaginacao){
	    $this->getConnection();

		$Ass_query ="select * FROM bbp_adm_lock_assinatura ORDER BY bbp_adm_lock_ass_email ASC $compPaginacao";
        list($this->myAss, $this->row_Ass, $this->totalRows_Ass) = executeQuery($bbpass, $database_bbpass, $Ass_query);
	}

	//utilizado para paginação
	public function totalAssinatura($database_bbpass, $bbpass){
        $this->getConnection();

		$Ass_query ="select COUNT(bbp_adm_lock_ass_codigo) as TOTAL FROM bbp_adm_lock_assinatura";
        list($Ass, $row_Ass, $totalRows) = executeQuery($bbpass, $database_bbpass, $Ass_query);

		return $row_Ass['TOTAL'];
	}
	//dados do Assinatura
	public function dadosAssinatura($database_bbpass, $bbpass, $bbp_adm_lock_ass_codigo){
        $this->getConnection();

		$Ass_query ="select * FROM bbp_adm_lock_assinatura Where bbp_adm_lock_ass_codigo=".$bbp_adm_lock_ass_codigo;
        list($Ass, $row_Ass, $totalRows) = executeQuery($bbpass, $database_bbpass, $Ass_query);
		  
        $this->bbp_adm_lock_ass_codigo	= $row_Ass['bbp_adm_lock_ass_codigo'];
        $this->bbp_adm_lock_ass_nome	= $row_Ass['bbp_adm_lock_ass_nome'];
        $this->bbp_adm_lock_ass_email	= $row_Ass['bbp_adm_lock_ass_email'];
        $this->bbp_adm_lock_ass_cpf		= $row_Ass['bbp_adm_lock_ass_cpf'];
        $this->bbp_adm_lock_ass_acesso	= $row_Ass['bbp_adm_lock_ass_acesso'];
        $this->bbp_adm_lock_ass_obs		= $row_Ass['bbp_adm_lock_ass_obs'];
	}
	//verifica Assinatura repetido
	public function verificaRepetido($database_bbpass, $bbpass, $notIn){
        $this->getConnection();

	    $Ass_query ="select COUNT(bbp_adm_lock_ass_codigo) as TOTAL FROM bbp_adm_lock_assinatura Where bbp_adm_lock_ass_email='".$this->bbp_adm_lock_ass_email."' OR bbp_adm_lock_ass_cpf=".$this->bbp_adm_lock_ass_cpf." $notIn";
        list($Ass, $row_Ass, $totalRows) = executeQuery($bbpass, $database_bbpass, $Ass_query);

		return $row_Ass['TOTAL'];
	}
	//Cadastra Assinatura
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();

        $insertSQL = "INSERT INTO bbp_adm_lock_assinatura (bbp_adm_lock_ass_nome,bbp_adm_lock_ass_email,bbp_adm_lock_ass_cpf,bbp_adm_lock_ass_obs) VALUES ('".$this->bbp_adm_lock_ass_nome."', '".$this->bbp_adm_lock_ass_email."',".$this->bbp_adm_lock_ass_cpf.",'".$this->bbp_adm_lock_ass_obs."')";

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//Edita Assinatura
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $updateSQL = "UPDATE bbp_adm_lock_assinatura SET bbp_adm_lock_ass_nome='".$this->bbp_adm_lock_ass_nome."', bbp_adm_lock_ass_email='".$this->bbp_adm_lock_ass_email."', bbp_adm_lock_ass_cpf=".$this->bbp_adm_lock_ass_cpf.", bbp_adm_lock_ass_obs='".$this->bbp_adm_lock_ass_obs."' Where bbp_adm_lock_ass_codigo=".$this->bbp_adm_lock_ass_codigo;

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//Exclui Assinatura
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_lock_ass_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_lock_assinatura Where bbp_adm_lock_ass_codigo=" . $this->bbp_adm_lock_ass_codigo;
            list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
}