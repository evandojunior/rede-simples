<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class Biometria extends RecoverConnection {
	public $bbp_adm_lock_bio_codigo;
	public $bbp_adm_lock_bio_email;
	public $bbp_adm_lock_bio_nome;

	public $myBio;
	public $row_Bio;
	public $totalRows_Bio;
	
	//inicia procedimentos da classe
	public function consultaBiometria($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

        $Bio_query ="select * FROM bbp_adm_lock_biometria ORDER BY bbp_adm_lock_bio_email ASC $compPaginacao";

        list($this->myBio, $this->row_Bio, $this->totalRows_Bio) = executeQuery($bbpass, $database_bbpass, $Bio_query);
	}

	//utilizado para paginação
	public function totalBiometria($database_bbpass, $bbpass){
        $this->getConnection();

        $Bio_query ="select COUNT(bbp_adm_lock_bio_codigo) as TOTAL FROM bbp_adm_lock_biometria";
        list($Bio, $row_Bio, $this->totalRows_Bio) = executeQuery($bbpass, $database_bbpass, $Bio_query);

        return $row_Bio['TOTAL'];
	}
	//Exclui Biometria
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_lock_bio_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_lock_biometria Where bbp_adm_lock_bio_codigo=" . $this->bbp_adm_lock_bio_codigo;

            list($Result1, $rows, $this->totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
}