<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Sms extends RecoverConnection {
	public $bbp_adm_lock_sms_codigo;
	public $bbp_adm_lock_sms_nome;
	public $bbp_adm_lock_sms_email;
	public $bbp_adm_lock_sms_chave;
	public $bbp_adm_lock_sms_celular;
	public $bbp_adm_lock_sms_observacao;
	public $bbp_adm_lock_sms_acesso;

	public $mySms;
	public $row_Sms;
	public $totalRows_Sms;
	
	//inicia procedimentos da classe
	public function consultaSms($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

        $Sms_query ="select * FROM bbp_adm_lock_sms ORDER BY bbp_adm_lock_sms_email ASC $compPaginacao";
        list($this->mySms, $this->row_Sms, $this->totalRows_Sms) = executeQuery($bbpass, $database_bbpass, $Sms_query);
	}
	//utilizado para paginação
	public function totalSms($database_bbpass, $bbpass){
        $this->getConnection();

		$Sms_query ="select COUNT(bbp_adm_lock_sms_codigo) as TOTAL FROM bbp_adm_lock_sms";
        list($Sms, $row_Sms, $totalRows) = executeQuery($bbpass, $database_bbpass, $Sms_query);

		return $row_Sms['TOTAL'];
	}
	//dados do Modulo
	public function dadosSms($database_bbpass, $bbpass, $bbp_adm_lock_sms_codigo){
        $this->getConnection();
        $Sms_query ="select * FROM bbp_adm_lock_sms Where bbp_adm_lock_sms_codigo=".$bbp_adm_lock_sms_codigo;
        list($Sms, $row_Sms, $totalRows) = executeQuery($bbpass, $database_bbpass, $Sms_query);

        $this->bbp_adm_lock_sms_codigo		= $row_Sms['bbp_adm_lock_sms_codigo'];
        $this->bbp_adm_lock_sms_nome		= $row_Sms['bbp_adm_lock_sms_nome'];
        $this->bbp_adm_lock_sms_email		= $row_Sms['bbp_adm_lock_sms_email'];
        $this->bbp_adm_lock_sms_chave		= $row_Sms['bbp_adm_lock_sms_chave'];
        $this->bbp_adm_lock_sms_celular		= $row_Sms['bbp_adm_lock_sms_celular'];
        $this->bbp_adm_lock_sms_observacao	= $row_Sms['bbp_adm_lock_sms_observacao'];
        $this->bbp_adm_lock_sms_acesso		= $row_Sms['bbp_adm_lock_sms_acesso'];
	}
	//verifica Sms repetido
	public function verificaRepetido($database_bbpass, $bbpass, $notIn){
        $this->getConnection();

        $Sms_query ="select COUNT(bbp_adm_lock_sms_codigo) as TOTAL FROM bbp_adm_lock_sms Where bbp_adm_lock_sms_email='".$this->bbp_adm_lock_sms_email."' $notIn";
        list($Sms, $row_Sms, $totalRows) = executeQuery($bbpass, $database_bbpass, $Sms_query);

        return $row_Sms['TOTAL'];
	}
	//Cadastra Sms
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();
        $insertSQL = "INSERT INTO bbp_adm_lock_sms (bbp_adm_lock_sms_nome,bbp_adm_lock_sms_email,bbp_adm_lock_sms_celular,bbp_adm_lock_sms_observacao) VALUES ('".$this->bbp_adm_lock_sms_nome."', '".$this->bbp_adm_lock_sms_email."', '".$this->bbp_adm_lock_sms_celular."','".$this->bbp_adm_lock_sms_observacao."')";

        list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//Edita Sms
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();
	    $updateSQL = "UPDATE bbp_adm_lock_sms SET bbp_adm_lock_sms_nome='".$this->bbp_adm_lock_sms_nome."', bbp_adm_lock_sms_email='".$this->bbp_adm_lock_sms_email."',bbp_adm_lock_sms_celular='".$this->bbp_adm_lock_sms_celular."', bbp_adm_lock_sms_observacao='".$this->bbp_adm_lock_sms_observacao."' Where bbp_adm_lock_sms_codigo=".$this->bbp_adm_lock_sms_codigo;

        list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//Exclui Sms
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_lock_sms_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_lock_sms Where bbp_adm_lock_sms_codigo=" . $this->bbp_adm_lock_sms_codigo;
            list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
}