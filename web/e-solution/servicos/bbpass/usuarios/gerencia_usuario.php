<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class usuarios extends RecoverConnection {
	public $bbp_adm_aut_codigo;
	public $bbp_adm_aut_usuario;
	public $bbp_adm_aut_senha;
	public $bbp_adm_aut_ip;
	public $bbp_adm_acesso;
	public $bbp_adm_nivel;
	public $bbp_adm_user;

	public $myUser;
	public $row_User;
	public $totalRows_User;
	
	//inicia procedimentos da classe
	public function consultaUsuarios($database_bbpass, $bbpass, $compPaginacao){
        $this->getConnection();

        $User_query ="select * FROM bbp_adm_autenticacao ORDER BY bbp_adm_aut_usuario ASC $compPaginacao";
        list($this->myUser, $this->row_User, $this->totalRows_User) = executeQuery($bbpass, $database_bbpass, $User_query);
	}
	//utilizado para paginação
	public function totalUsuarios($database_bbpass, $bbpass){
        $this->getConnection();

		$User_query ="select COUNT(bbp_adm_aut_codigo) as TOTAL FROM bbp_adm_autenticacao";
        list($User, $row_User, $totalRows) = executeQuery($bbpass, $database_bbpass, $User_query);

		return $row_User['TOTAL'];
	}
	//dados dos usuários
	public function dadosUsuarios($database_bbpass, $bbpass, $codUsuario){
        $this->getConnection();

        $User_query ="select * FROM bbp_adm_autenticacao Where bbp_adm_aut_codigo=".$codUsuario;
        list($User, $row_User, $totalRows) = executeQuery($bbpass, $database_bbpass, $User_query);

        $this->bbp_adm_aut_codigo 		= $row_User['bbp_adm_aut_codigo'];
        $this->bbp_adm_aut_usuario 		= $row_User['bbp_adm_aut_usuario'];
        $this->bbp_adm_aut_senha 		= $row_User['bbp_adm_aut_senha'];
        $this->bbp_adm_aut_ip 			= $row_User['bbp_adm_aut_ip'];
        $this->bbp_adm_acesso 			= $row_User['bbp_adm_acesso'];
        $this->bbp_adm_nivel 			= $row_User['bbp_adm_nivel'];
        $this->bbp_adm_user 			= $row_User['bbp_adm_user'];
	}
	//verifica usuário repetida
	public function verificaRepetido($database_bbpass, $bbpass){
        $this->getConnection();

		$User_query ="select COUNT(bbp_adm_aut_codigo) as TOTAL FROM bbp_adm_autenticacao Where bbp_adm_aut_usuario='".$this->bbp_adm_aut_usuario."'";
        list($User, $row_User, $totalRows) = executeQuery($bbpass, $database_bbpass, $User_query);

		return $row_User['TOTAL'];
	}
	//Cadastra usuario
	public function cadastraDados($database_bbpass, $bbpass){
        $this->getConnection();

		$insertSQL = "INSERT INTO bbp_adm_autenticacao (bbp_adm_aut_usuario, bbp_adm_aut_senha, bbp_adm_aut_ip, bbp_adm_nivel, bbp_adm_user) VALUES ('".$this->bbp_adm_aut_usuario."', '".md5($this->bbp_adm_aut_senha)."', '".$this->bbp_adm_aut_ip."', 774, '".$this->bbp_adm_user."')";

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
  	}
	//Edita usuario
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $senha = 	!empty($this->bbp_adm_aut_senha) ? ", bbp_adm_aut_senha='".md5($this->bbp_adm_aut_senha)."'" : "";
	    $updateSQL = "UPDATE bbp_adm_autenticacao SET bbp_adm_aut_usuario='".$this->bbp_adm_aut_usuario."', bbp_adm_aut_ip='".$this->bbp_adm_aut_ip."', bbp_adm_user='".$this->bbp_adm_user."' $senha Where bbp_adm_aut_codigo=".$this->bbp_adm_aut_codigo;

        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//Exclui usuário
	public function excluiDados($database_bbpass, $bbpass){
        $this->getConnection();

        if (!empty($this->bbp_adm_aut_codigo)) {
            $deleteSQL = "DELETE from bbp_adm_autenticacao Where bbp_adm_aut_codigo=" . $this->bbp_adm_aut_codigo;
            list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);
        }
	}
}