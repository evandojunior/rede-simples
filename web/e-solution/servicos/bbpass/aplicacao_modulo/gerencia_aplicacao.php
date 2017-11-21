<?php

require_once($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/includes/RecoverConnection.php");

class AplicacaoModulo extends RecoverConnection
{
	public $bbp_adm_lock_codigo;
	public $bbp_adm_loc_codigo;
	public $bbp_adm_apl_codigo;

	public $myApl;
	public $row_Apl;
	public $totalRows_Apl;
	
	//inicia procedimentos da classe
	public function consultaDados($database_bbpass, $bbpass, $condicao, $order){
		  $this->getConnection();

		  $Apl_query ="select bbp_adm_lock.*, bbp_adm_lock_codigo from bbp_adm_lock
			 left join bbp_adm_lock_aplicacao on bbp_adm_lock.bbp_adm_loc_codigo = bbp_adm_lock_aplicacao.bbp_adm_loc_codigo
			  $condicao
			   group by bbp_adm_lock.bbp_adm_loc_codigo $order";


          list($this->myApl, $this->row_Apl, $this->totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);
	}

	public function consultaAplicacoes($database_bbpass, $bbpass, $condicao, $order){
          $this->getConnection();

		  $Apl_query ="select bbp_adm_aplicacao.*, bbp_adm_lock_codigo from bbp_adm_aplicacao
		 LEFT join bbp_adm_lock_aplicacao on bbp_adm_aplicacao.bbp_adm_apl_codigo = bbp_adm_lock_aplicacao.bbp_adm_apl_codigo
		  $condicao
		  group by bbp_adm_apl_codigo $order";

          list($this->myApl, $this->row_Apl, $this->totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);
	}

	//consulta not in
	public function consultaCadastrados($database_bbpass, $bbpass, $condicao, $campo){
          $this->getConnection();
		  $Apl_query ="select * from bbp_adm_lock_aplicacao $condicao";

          list($Apl, $row_Apl, $totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);

		  $codigo = 0;
		  	if($totalRows_Apl>0){
				do{
					$codigo.=",".$row_Apl[$campo];
				} while($row_Apl = mysqli_fetch_assoc($Apl));
			}
		  return $codigo;
	}
	
	//Cadastra Aplicacao
	public function cadastraDados($database_bbpass, $bbpass){
          $this->getConnection();

		  $Apl_query ="select * from bbp_adm_lock_aplicacao Where bbp_adm_loc_codigo=".$this->bbp_adm_loc_codigo." and bbp_adm_apl_codigo=".$this->bbp_adm_apl_codigo;

          list($Apl, $row_Apl, $totalRows_Apl) = executeQuery($bbpass, $database_bbpass, $Apl_query);
		  $acao=0;
		  if($totalRows_Apl==0){
			  $insertSQL = "INSERT INTO bbp_adm_lock_aplicacao (bbp_adm_loc_codigo,bbp_adm_apl_codigo) VALUES (".$this->bbp_adm_loc_codigo.", ".$this->bbp_adm_apl_codigo.")";
			  $acao=1;

              list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $insertSQL);
		  }

		  return $acao;
  	}

	//Exclui Vínculo
	public function excluiDados($database_bbpass, $bbpass){
	  $this->getConnection();
	  $deleteSQL = "DELETE from bbp_adm_lock_aplicacao Where bbp_adm_lock_codigo=".$this->bbp_adm_lock_codigo;

	  list($Result1, $rows, $totalRows) = executeQuery($bbpass, $database_bbpass, $deleteSQL);

	  return $Result1;
	}
}