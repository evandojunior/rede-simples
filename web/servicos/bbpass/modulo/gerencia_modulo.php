<?php

require_once($_SESSION['caminhoFisico']."/servicos/bbpass/includes/RecoverConnection.php");

if(!class_exists('Modulo')) {
	class Modulo extends RecoverConnection {
		public $bbp_adm_loc_codigo;
		public $bbp_adm_loc_nome;
		public $bbp_adm_loc_arquivo;
		public $bbp_adm_loc_observacao;
		public $bbp_adm_loc_diretorio;
		public $bbp_adm_loc_ativo;
		public $bbp_adm_loc_icone;
		
		public $myMod;
		public $row_Mod;
		public $totalRows_Mod;
		
		//inicia procedimentos da classe
		public function consultaModulo($database_bbpass, $bbpass, $compPaginacao){
            $this->getConnection();

			$Mod_query ="select * FROM bbp_adm_lock ORDER BY bbp_adm_loc_nome ASC $compPaginacao";
            list($this->myMod, $this->row_Mod, $this->totalRows_Mod) = executeQuery($bbpass, $database_bbpass, $Mod_query);
		}

		//dados do Modulo
		public function dadosModulo($database_bbpass, $bbpass, $codModulo){
            $this->getConnection();

			$Mod_query ="select * FROM bbp_adm_lock Where bbp_adm_loc_codigo=".$codModulo;
            list($Mod, $row_Mod, $totalRows) = executeQuery($bbpass, $database_bbpass, $Mod_query);
			  
            $this->bbp_adm_loc_codigo 		= $row_Mod['bbp_adm_loc_codigo'];
            $this->bbp_adm_loc_nome 		= $row_Mod['bbp_adm_loc_nome'];
            $this->bbp_adm_loc_arquivo 		= $row_Mod['bbp_adm_loc_arquivo'];
            $this->bbp_adm_loc_observacao 	= $row_Mod['bbp_adm_loc_observacao'];
            $this->bbp_adm_loc_diretorio 	= $row_Mod['bbp_adm_loc_diretorio'];
            $this->bbp_adm_loc_ativo		= $row_Mod['bbp_adm_loc_ativo'];
            $this->bbp_adm_loc_icone		= $row_Mod['bbp_adm_loc_icone'];
		}
		//adiciona os módulos em um array
		public function adicionaArray($database_bbpass, $bbpass){
			$todosModulos = array();
									  $this->consultaModulo($database_bbpass, $bbpass, "");
			$row_modulo		   		= $this->row_Mod;
			$totalRows_modulo	 	= $this->totalRows_Mod;
				if($totalRows_modulo>0){
					do{
						array_push($todosModulos,$row_modulo['bbp_adm_loc_codigo']."|".$row_modulo['bbp_adm_loc_nome']);
					} while($row_modulo = mysqli_fetch_assoc($this->myMod));
				}
			return 	$todosModulos;
		}
	}
}