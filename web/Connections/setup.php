<?php ob_start();

//######################### - SETEMBRO 2012 - #################################################
$raiz = preg_split('@(WEB|web)@', __FILE__, -1, PREG_SPLIT_DELIM_CAPTURE);
$raiz = (string) rtrim( $raiz[0], '\\/').'/'.$raiz[1];
$raiz = strtr( $raiz, '\\','/');
	
if(!file_exists($raiz."/../database/servicos/bbpass/ini.xml")){
	exit(require_once($raiz.'/e-solution/servicos/bbpass/config/regra.php'));
}
//######################### - SETEMBRO 2012 - #################################################

//------------------------------------------------
#ini_set("display_errors","on");
if(!isset($_SESSION)){ @session_start();}

date_default_timezone_set('America/Sao_Paulo');

//Acesso ao BBPASS=========================================================================
 $socket_BBPASS	= "localhost";//Comunicação background
 $dominio		= explode(":",(isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:''));
 $BBP_protocolo = "http://";
 $BBP_host		= $dominio[0];
 $BBP_porta		= "";
 $_SESSION['EndURL_BBPASS'] = $BBP_protocolo. $BBP_host . $BBP_porta;
//Acesso ao BBPASS=========================================================================

//Acesso BIOMETRIA=========================================================================
$endJSPBio		= "{$global->project->host}:8080/RequestJava";
//Acesso BIOMETRIA=========================================================================

//Acesso ASSINATURA DIGITAL================================================================
//Endereço http para assinatura e envio dos documentos, informar 
//http://endereço:porta/nome do projeto, instalado
$hostAssinatura = "{$global->project->host}:88/assinatura_digital";

//Caminho físico para onde o projeto esta rodando, não esquecer de dar permissão para o IIS/Apacher ler este diretório
//uma vez que o PHP deverá ter acesso ao mesmo
$ondeAssinatura = "C:/Program Files/Apache Software Foundation/Tomcat 6.0/webapps/assinatura_digital/signed_files";
//Acesso ASSINATURA DIGITAL================================================================

//Acesso SMS===============================================================================
$ipAcessoSMS = "{$global->project->host}/daruma/envia.php";
//Acesso SMS===============================================================================

//Acesso ao POLICY=========================================================================
$_SESSION['EndURL_POLICY'] = $global->project->host;
//Acesso ao POLICY=========================================================================

//Caminho Físico===========================================================================
	$divisor 		= "web";
	$dirPacote 		= explode($divisor,str_replace("\\","/",dirname(__FILE__)));
	$dirFisico 		= $dirPacote[0]."web";
	$caminhoFisico 	= $dirFisico;
	$_SESSION['caminhoFisico'] = $caminhoFisico;
//Caminho Físico===========================================================================

//INFORMAÇÕES ADICIONAIS DO BI=============================================================
$tabOficiaisBI = array("bi_campos"=>"1","bi_compartilhamento"=>"1","bi_conexoes"=>"1","bi_grupo"=>"1","bi_membro"=>"1","bi_relatorios"=>"1","bi_tabela"=>"1","bi_usuarios"=>"1");
$palavrasReservadas = array("insert"=>"1","update"=>"1","delete"=>"1","create"=>"1","drop"=>"1");
//=========================================================================================

//===========================================RESCONSTRÓI SESSÃO EM CASO DE SOLICITAÇÃO=====
//Situação BBHIVE
	$status = array();
	$status[1] = "Protocolado|#7FCCFF";
	$status[2] = "Recebido|#FFFF70";
	//$status[3] = "Digitalizado|#FFCC88";
	$status[4] = "Distribuído|#FF9933";
	$status[5] = "Concluído/Deferido|#C1FF66";
	$status[6] = "Indeferido|#FF7F7F";
	$status[7] = "Aguardando|#F6F6F6";
	
	$curingas = array();
	$curingas['Número do protocolo'] 		= "@#numprotocolo";
	$curingas['Solicitante'] 				= "@#solicitante";
	$curingas['Oficio'] 					= "@#oficio";
	$curingas['Departamento'] 				= "@#departamento";
	$curingas['Data do ofício'] 			= "@#dtoficio";
	$curingas['Data do cadastro']			= "@#dtcadastro";
	$curingas['Flagrante']					= "@#flagrante";
	$curingas['Conteúdo do ofício']			= "@#conteudo";
	$curingas['Recebido por']				= "@#recebidopor";
	$curingas['Data de recebimento']		= "@#dtrecebimento";
	$curingas['Autoridade solicitante']		= "@#autoridadesolic";
	
	$curingasProt 	= array();
	$curingasProt["bbh_pro_codigo"] 		= "";
	$curingasProt["bbh_pro_identificacao"] 	= "";
	$curingasProt["bbh_pro_titulo"] 		= "";
	$curingasProt["bbh_dep_nome"] 			= "";
	$curingasProt["bbh_pro_data"] 			= "";
	$curingasProt["bbh_pro_momento"] 		= "";
	$curingasProt["bbh_pro_flagrante"] 		= "";
	$curingasProt["bbh_pro_descricao"] 		= "";
	$curingasProt["bbh_pro_recebido"] 		= "";
	$curingasProt["bbh_pro_dt_recebido"] 	= "";
	$curingasProt["bbh_pro_autoridade"] 	= "";
	
	$curingasFluxo 	= array();
	$curingasFluxo['Número do processo']	= "##@numeroprocesso";
	$curingasFluxo['Profissional responsavel']= "##@profresponsavel";
	
	$curingasFlux	= array();
	$curingasFlux["bbh_caso"] 				= "";
	$curingasFlux["bbh_usu_nome"]			= "";
//=================

//require para o policy
require_once("policy/envia.php");
?>
