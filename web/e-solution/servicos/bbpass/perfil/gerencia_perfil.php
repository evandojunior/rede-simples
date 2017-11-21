<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class perfil extends RecoverConnection
{
	var $lastAcesso		= "";
	var $novaSenha		= "";

	//atualiza log
	public function atualizaLogon($database_bbpass, $bbpass){
	    $updateSQL = "UPDATE bbp_adm_autenticacao SET bbp_adm_acesso='".date('Y-m-d H:i:s')."' Where bbp_adm_aut_codigo=".$_SESSION['MM_BBpassADM_Codigo'];
	    list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	//atualiza senha
	public function atualizaDados($database_bbpass, $bbpass){
	    $this->getConnection();

	    $updateSQL = "UPDATE bbp_adm_autenticacao SET bbp_adm_aut_senha='".$this->novaSenha."' Where bbp_adm_aut_codigo=".$_SESSION['MM_BBpassADM_Codigo'];
	    list($Result1, $row, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	
	public function dadosPerfil($database_bbpass, $bbpass){
        $this->getConnection();

        $LoginRS_query ="SELECT bbp_adm_acesso FROM bbp_adm_autenticacao WHERE bbp_adm_aut_codigo=".$_SESSION['MM_BBpassADM_Codigo'];

        list($LoginRS, $row_LoginRS, $totalRows) = executeQuery($bbpass, $database_bbpass, $LoginRS_query);
        $this->lastAcesso 	= arrumadata(substr($row_LoginRS['bbp_adm_acesso'],0,10))." ".substr($row_LoginRS['bbp_adm_acesso'],11,5);
	}
}