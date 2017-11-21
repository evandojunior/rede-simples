<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class aplicacao extends RecoverConnection
{
	public $bbp_adm_apl_codigo;
	public $bbp_adm_apl_nome;
	public $bbp_adm_apl_apelido;
	public $bbp_adm_apl_observacao;
	public $bbp_adm_apl_url;
	public $bbp_adm_apl_ativo;
	public $bbp_adm_apl_icone;

	public $myApl;
	public $row_Apl;
	public $totalRows_Apl;
	
	//inicia procedimentos da classe
	public function consultaAplicacao($database_bbpass, $bbpass, $compPaginacao){
		  $Apl_query ="select * FROM bbp_adm_aplicacao  ORDER BY bbp_adm_apl_apelido ASC $compPaginacao";

          list($this->myApl, $this->row_Apl, $this->totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);
	}

	//utilizado para paginação
	public function totalAplicacao($database_bbpass, $bbpass){
        $this->getConnection();

		$Apl_query ="select COUNT(bbp_adm_apl_codigo) as TOTAL FROM bbp_adm_aplicacao";

        list($Apl, $row_Apl, $totalRows) = executeQuery($bbpass, $database_bbpass, $Apl_query);
		return $row_Apl['TOTAL'];
	}

	//dados da aplicacao
	public function dadosAplicacao($database_bbpass, $bbpass, $codAplicacao){
        $this->getConnection();

        $Apl_query ="select * FROM bbp_adm_aplicacao Where bbp_adm_apl_codigo=".$codAplicacao;
        list($Apl, $row_Apl, $totalRows) = executeQuery($bbpass, $database_bbpass, $Apl_query);
		  
        $this->bbp_adm_apl_codigo 		= $row_Apl['bbp_adm_apl_codigo'];
        $this->bbp_adm_apl_nome 		= $row_Apl['bbp_adm_apl_nome'];
        $this->bbp_adm_apl_apelido 		= $row_Apl['bbp_adm_apl_apelido'];
        $this->bbp_adm_apl_observacao 	= $row_Apl['bbp_adm_apl_observacao'];
        $this->bbp_adm_apl_url 			= $row_Apl['bbp_adm_apl_url'];
        $this->bbp_adm_apl_ativo 		= $row_Apl['bbp_adm_apl_ativo'];
        $this->bbp_adm_apl_icone 		= $row_Apl['bbp_adm_apl_icone'];
	}

	//verifica aplicação repetida
	public function verificaRepetida($database_bbpass, $bbpass){
        $this->getConnection();
        $Apl_query ="select COUNT(bbp_adm_apl_codigo) as TOTAL FROM bbp_adm_aplicacao Where bbp_adm_apl_nome='".$this->bbp_adm_apl_nome."'";
        list($Apl, $row_Apl, $totalRows) = executeQuery($bbpass, $database_bbpass, $Apl_query);

		return $row_Apl['TOTAL'];
	}

	//Cadastra aplicação
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();
    	$insertSQL = "INSERT INTO bbp_adm_aplicacao (bbp_adm_apl_nome, bbp_adm_apl_apelido, bbp_adm_apl_observacao, bbp_adm_apl_url, bbp_adm_apl_ativo, bbp_adm_apl_icone) VALUES ('".$this->bbp_adm_apl_nome."', '".$this->bbp_adm_apl_apelido."', '".$this->bbp_adm_apl_observacao."', '".$this->bbp_adm_apl_url."', '".$this->bbp_adm_apl_ativo."','".$this->bbp_adm_apl_icone."')";

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}

	//Edita aplicação
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $updateSQL = "UPDATE bbp_adm_aplicacao SET bbp_adm_apl_nome='".$this->bbp_adm_apl_nome."', bbp_adm_apl_apelido='".$this->bbp_adm_apl_apelido."', bbp_adm_apl_observacao='".$this->bbp_adm_apl_observacao."', bbp_adm_apl_url='".$this->bbp_adm_apl_url."', bbp_adm_apl_ativo='".$this->bbp_adm_apl_ativo."', bbp_adm_apl_icone='".$this->bbp_adm_apl_icone."' Where bbp_adm_apl_codigo=".$this->bbp_adm_apl_codigo;

    	list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}

	//Exclui Aplicação
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $deleteSQL = "DELETE from bbp_adm_aplicacao Where bbp_adm_apl_codigo=".$this->bbp_adm_apl_codigo;
        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
	}
}