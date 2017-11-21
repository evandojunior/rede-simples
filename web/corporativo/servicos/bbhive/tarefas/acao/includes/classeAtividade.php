<?php

if(!isset($_SESSION)){ session_start(); }
require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

if(substr(getCurrentPage(),0,34)!="/corporativo/servicos/bbhive/fluxo"){
    require_once($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
}

class atividade{

	//atributos da classe
    protected $linkConnection;
    protected $defaultDatabase;

	public $codigo;
	public $ModeloAtividade;
	public $codigoFluxo;
	public $nome;
	public $duracao;
	public $observacao;
	public $status;
	public $predecessora;
	public $predecessoras;
	public $finalPrevisto;
	public $meuDepartamento;
	public $inicioPrevisto;
	public $finalReal;
	public $inicioReal;
	public $descricaoAtividade;
	public $usuarioAtividade;
	public $usuChefe;
	public $profissional;
	public $nmDepto;
	public $responsavelFluxo;
	public $bbh_mod_atiFim;
	public $bbh_flu_finalizado;
	public $bbh_mod_ati_relatorio;
	public $bbh_flu_autonumeracao;
	public $bbh_mod_flu_nome;
	
		function execute($codAtividade){
			 require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");

//			 var_dump($_SESSION['caminhoFisico']."/Connections/bbhive.php", $bbhive);die;

				//dados da atividade
				$query_Atividades = "select 
				bbh_atividade.*, bbh_usu_chefe, bbh_mod_ati_nome, bbh_mod_ati_duracao, bbh_mod_ati_ordem, bbh_usu_identificacao, bbh_usu_apelido, bbh_sta_ati_nome, bbh_sta_ati_peso, bbh_mod_ati_icone, bbh_dep_nome, bbh_departamento.bbh_dep_codigo, bbh_flu_titulo, bbh_mod_ati_observacao, bbh_ati_andamento, bbh_per_codigo, bbh_atividade.bbh_mod_ati_codigo, bbh_atividade.bbh_sta_ati_codigo, bbh_fluxo.bbh_usu_codigo as RespFluxo, bbh_mod_atiFim, bbh_flu_finalizado, bbh_mod_ati_relatorio
				from bbh_atividade
					  inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
					  inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
					  inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
					  inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo
						   Where bbh_atividade.bbh_ati_codigo = $codAtividade";
                list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($this->getLinkConnection(), $this->getDefaultDatabase(), $query_Atividades);
				
				$query_CabFluxo = "select bbh_fluxo.bbh_flu_codigo
from bbh_atividade 
inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo 
 inner join bbh_fluxo on bbh_atividade.bbh_flu_codigo = bbh_fluxo.bbh_flu_codigo 
   Where bbh_atividade.bbh_ati_codigo = $codAtividade";
                list($CabFluxo, $row_CabFluxo, $totalRows_CabFluxo) = executeQuery($this->getLinkConnection(), $this->getDefaultDatabase(), $query_CabFluxo);

				$query_Modelo = "select bbh_flu_autonumeracao, bbh_mod_flu_nome from bbh_fluxo
 inner join bbh_modelo_fluxo on bbh_fluxo.bbh_mod_flu_codigo = bbh_modelo_fluxo.bbh_mod_flu_codigo
  Where bbh_flu_codigo = ".$row_CabFluxo['bbh_flu_codigo'];
                list($Modelo, $row_Modelo, $totalRows_Modelo) = executeQuery($this->getLinkConnection(), $this->getDefaultDatabase(), $query_Modelo);
				
				//dados da atividade selecionada
				$this->codigoFluxo 		= $row_Atividades['bbh_flu_codigo'];
				$this->ModeloAtividade 	= $row_Atividades['bbh_mod_ati_codigo'];
				$this->usuarioAtividade	= $row_Atividades['bbh_usu_codigo'];
				$this->usuChefe			= $row_Atividades['bbh_usu_chefe'];
				$this->inicioReal		= $row_Atividades['bbh_ati_inicio_real'];
				$this->status			= $row_Atividades['bbh_sta_ati_codigo'];
				$this->meuDepartamento	= $row_Atividades['bbh_dep_codigo'];	
				$this->profissional		= $row_Atividades['bbh_usu_apelido'];
				$this->nmDepto			= $row_Atividades['bbh_dep_nome'];
				$this->responsavelFluxo = $row_Atividades['RespFluxo'];
				$this->bbh_mod_atiFim	= $row_Atividades['bbh_mod_atiFim'];
				$this->bbh_flu_finalizado=$row_Atividades['bbh_flu_finalizado'];
				$this->bbh_mod_ati_relatorio=$row_Atividades['bbh_mod_ati_relatorio'];
				$this->bbh_flu_autonumeracao=$row_Modelo['bbh_flu_autonumeracao'];
				$this->bbh_mod_flu_nome	= $row_Modelo['bbh_mod_flu_nome'];

				$strRelatorio = strpos(getCurrentPage(),"relatorios/painel");
				
				if((getCurrentPage()=="/corporativo/servicos/bbhive/tarefas/acao/includes/gerAtividade.php") or (substr(getCurrentPage(),0,34)=="/corporativo/servicos/bbhive/fluxo") or strlen($strRelatorio) > 0){
					
					$this->nome 				= $row_Atividades['bbh_mod_ati_nome'];
					$this->codigo 				= $row_Atividades['bbh_ati_codigo'];
					$this->finalPrevisto		= $row_Atividades['bbh_ati_final_previsto'];
					$this->finalReal			= $row_Atividades['bbh_ati_final_real'];
					$this->inicioPrevisto		= $row_Atividades['bbh_ati_inicio_previsto'];
					$this->descricaoAtividade 	= $row_Atividades['bbh_mod_ati_observacao'];
				} else {
					//lista todas as predecessoras desta atividade
					$this->predecessoras = array();
					$this->getPredecessoras();//vou passar o código da atividade em questão				
				}
		}
		
		function getPredecessoras(){
            require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
		 //dados das predecessoras
			//com o código da atividade busco as minhas predecessoras
			$query_Predecessoras = "select 
				  bbh_atividade.bbh_mod_ati_codigo
			from bbh_dependencia
				  inner join bbh_modelo_atividade on bbh_dependencia.bbh_modelo_atividade_predecessora = bbh_modelo_atividade.bbh_mod_ati_codigo
				  inner join bbh_atividade on bbh_modelo_atividade.bbh_mod_ati_codigo = bbh_atividade.bbh_mod_ati_codigo
				  Where bbh_modelo_atividade_sucessora=".$this->ModeloAtividade." and bbh_flu_codigo=".$this->codigoFluxo." and bbh_sta_ati_codigo<>2 group by bbh_atividade.bbh_mod_ati_codigo";
            list($Predecessoras, $row_Predecessoras, $totalRows_Predecessoras) = executeQuery($this->getLinkConnection(), $this->getDefaultDatabase(), $query_Predecessoras);

			//faço um laço e recupero o código de cada atividade
			if($totalRows_Predecessoras>0){
				do{

					$this->predecessora = new predecessoras($row_Predecessoras['bbh_mod_ati_codigo'], $this->codigoFluxo);
					array_push($this->predecessoras, $this->predecessora);

				} while ($row_Predecessoras = mysqli_fetch_assoc($Predecessoras));
			}

		}

    /**
     * @return mixed
     */
    public function getLinkConnection()
    {
        return $this->linkConnection;
    }

    /**
     * @param mixed $linkConnection
     */
    public function setLinkConnection($linkConnection)
    {
        $this->linkConnection = $linkConnection;
    }

    /**
     * @return mixed
     */
    public function getDefaultDatabase()
    {
        return $this->defaultDatabase;
    }

    /**
     * @param mixed $defaultDatabase
     */
    public function setDefaultDatabase($defaultDatabase)
    {
        $this->defaultDatabase = $defaultDatabase;
    }
}
//=======================================================PREDECESSORAS=======================================================


class predecessoras{

	//atributos da classe
	public $codigo;
	public $nome;
	public $codDepartamento;
	public $nmDepartamento;
	public $usuNome;
	public $finalPrevisto;
	public $nmStatus;
	public $pesoStatus;
	public $finalReal;
	
	function __construct($codModAtividade, $codFluxo){
	 include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
		//recupero apenas as atividades predecessoras, embora o select sejá parecido os parâmentros são diferentes
		$query_Atividades = "select 
  bbh_mod_ati_nome, bbh_mod_ati_duracao, bbh_mod_ati_ordem, bbh_usu_identificacao, bbh_usu_apelido, 
  bbh_sta_ati_nome, bbh_sta_ati_peso, bbh_mod_ati_icone, bbh_dep_nome, bbh_departamento.bbh_dep_codigo, 
  bbh_atividade.bbh_mod_ati_codigo, bbh_atividade.bbh_sta_ati_codigo, bbh_ati_final_previsto, bbh_ati_final_real, bbh_atividade.bbh_ati_codigo
				
    from bbh_atividade
  inner join bbh_modelo_atividade on bbh_atividade.bbh_mod_ati_codigo = bbh_modelo_atividade.bbh_mod_ati_codigo
  inner join bbh_usuario on bbh_atividade.bbh_usu_codigo = bbh_usuario.bbh_usu_codigo
  inner join bbh_status_atividade on bbh_atividade.bbh_sta_ati_codigo = bbh_status_atividade.bbh_sta_ati_codigo
  inner join bbh_departamento on bbh_usuario.bbh_dep_codigo = bbh_departamento.bbh_dep_codigo
						
  Where bbh_atividade.bbh_mod_ati_codigo=$codModAtividade and bbh_flu_codigo=$codFluxo";
        list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);

				//dados das predecessoras
					$this->nome 			= $row_Atividades['bbh_mod_ati_nome'];
					$this->codDepartamento	= $row_Atividades['bbh_dep_codigo'];
					$this->nmDepartamento	= $row_Atividades['bbh_dep_nome'];
					$this->usuNome 			= $row_Atividades['bbh_usu_apelido'];
					$this->finalPrevisto	= $row_Atividades['bbh_ati_final_previsto'];
					$this->finalReal		= $row_Atividades['bbh_ati_final_real'];
					$this->nmStatus			= $row_Atividades['bbh_sta_ati_nome'];
					$this->pesoStatus		= $row_Atividades['bbh_sta_ati_peso'];
					$this->codigo			= $row_Atividades['bbh_ati_codigo'];
	}
}
?>