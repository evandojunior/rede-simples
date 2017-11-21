<?php

require_once($_SESSION['caminhoFisico']."/servicos/bbpass/includes/RecoverConnection.php");

class perfil extends RecoverConnection {
	var $nomeUsuario 	= "";
	var $nascUsuario	= "";
	var $cargoUsuario	= "";
	var $sexoUsuario	= "";
	var $lastAcesso		= "";
	var $obsUsuario		= "";
	
	public function dadosPerfil($database_bbpass, $bbpass){
        $this->getConnection();

		$LoginRS_query ="SELECT * FROM bbp_adm_lock_loginsenha WHERE bbp_adm_lock_log_codigo=".$_SESSION['MM_BBpass_Codigo'];
        list($LoginRS, $row_LoginRS, $totalRows) = executeQuery($bbpass, $database_bbpass, $LoginRS_query);
		  
        $this->nomeUsuario 	= $row_LoginRS['bbp_adm_lock_log_nome'];
        $this->nascUsuario 	= $row_LoginRS['bbp_adm_lock_log_nasc'];
        $this->cargoUsuario = $row_LoginRS['bbp_adm_lock_log_cargo'];
        $this->sexoUsuario 	= $row_LoginRS['bbh_adm_lock_log_sexo'];
        $this->lastAcesso 	= arrumadata(substr($row_LoginRS['bbp_adm_lock_log_acesso'],0,10))." ".substr($row_LoginRS['bbp_adm_lock_log_acesso'],11,5);
        $this->obsUsuario 	= $row_LoginRS['bbp_adm_lock_log_obs'];
	}
	
	//Atualização de dados do perfil
	public function atualizaDados($database_bbpass, $bbpass){
        $this->getConnection();

	    $updateSQL = "UPDATE bbp_adm_lock_loginsenha SET bbp_adm_lock_log_nome='".$this->nomeUsuario."', bbp_adm_lock_log_nasc='".$this->nascUsuario."', bbp_adm_lock_log_cargo='".$this->cargoUsuario."', bbh_adm_lock_log_sexo='".$this->sexoUsuario."', bbp_adm_lock_log_obs='".$this->obsUsuario."' Where bbp_adm_lock_log_codigo=".$_SESSION['MM_BBpass_Codigo'];
        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	
	//verifica imagem
	public function verificaImagem($database_bbpass, $bbpass){
        $this->getConnection();

		if(file_exists($_SESSION['caminhoFisico']."/datafiles/servicos/bbpass/images/usuarios/".$_SESSION['MM_BBpass_Codigo']."/".$_SESSION['MM_BBpass_Codigo'].".jpg")){
			return '/datafiles/servicos/bbpass/images/usuarios/'.$_SESSION['MM_BBpass_Codigo'].'/'.$_SESSION['MM_BBpass_Codigo'].'.jpg';
		} else {
		  $this->dadosPerfil($database_bbpass, $bbpass);
             if($this->sexoUsuario=="m"){
                return '/servicos/bbpass/images/icone_H.gif';
             }else{
                return '/servicos/bbpass/images/icone_M.gif';
             }
		}
	}
	
	//atualiza log
	public function atualizaLogon($database_bbpass, $bbpass){
        $this->getConnection();

        if (!isset($_SESSION['MM_BBpass_Codigo'])) {
            return;
        }

	    $updateSQL = "UPDATE bbp_adm_lock_loginsenha SET bbp_adm_lock_log_acesso='".date('Y-m-d H:i:s')."' Where bbp_adm_lock_log_codigo=".$_SESSION['MM_BBpass_Codigo'];
        list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $updateSQL);
	}
	
	//logs de acesso
	public function listaLog($urlPolicy, $qtRegistros){
        $this->getConnection();

		$url = $urlPolicy."/e-solution/servicos/policy/includes/busca_log.php?".base64_encode("email=".$_SESSION['MM_BBpass_Email']."&qt_registros=".$qtRegistros);

		$consulta = file_get_contents($url);

		$objDOM = new DOMDocument();
		  if($consulta!=""){
			$objDOM->loadXML($consulta); //coloca conteúdo no objeto
		  }else{
			$root = $objDOM->createElement('auditoria');//cria elemento pai de todos
			$objDOM->appendChild($root);//adiciona noh no objeto XML
		  }
		return $objDOM;
	}
}