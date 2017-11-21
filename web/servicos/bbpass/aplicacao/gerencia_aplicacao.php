<?php

require_once($_SESSION['caminhoFisico']."/servicos/bbpass/includes/RecoverConnection.php");

class Aplicacao extends RecoverConnection {
	
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
	public function __construct($database_bbpass, $bbpass){
        $this->getConnection();

		  $locksLiberados = 0;
		  	if(count($_SESSION['modulosLiberados'])>0){
				foreach($_SESSION['modulosLiberados'] as $indice=>$valor){
					$locksLiberados.= ",".$indice;
				}
			}

		  $Apl_query ="select bbp_adm_aplicacao.* FROM bbp_adm_aplicacao 
inner join bbp_adm_lock_aplicacao on bbp_adm_aplicacao.bbp_adm_apl_codigo = bbp_adm_lock_aplicacao.bbp_adm_apl_codigo
 Where bbp_adm_apl_ativo='1' and bbp_adm_lock_aplicacao.bbp_adm_loc_codigo in ($locksLiberados) group by bbp_adm_aplicacao.bbp_adm_apl_codigo";

        list($this->myApl, $this->row_Apl, $this->totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);
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
	
	public function verificaLockAplicacao($database_bbpass, $bbpass, $idAplicacao){
        $this->getConnection();

		  $locksLiberados = 0;
		  	if(count($_SESSION['modulosLiberados'])>0){
				foreach($_SESSION['modulosLiberados'] as $indice=>$valor){
					$locksLiberados.= ",".$indice;
				}
			}
		//verifica locks autenticados
		$Apl_query ="select * from bbp_adm_lock_aplicacao Where bbp_adm_apl_codigo = $idAplicacao
and bbp_adm_loc_codigo not in ($locksLiberados);";

        list($Apl, $row_Apl, $totalRows) = executeQuery($bbpass, $database_bbpass, $Apl_query);
		  
		return $totalRows;
	}
}