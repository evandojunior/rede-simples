<?php ini_set('display_erros',true);
require_once("../../../Connections/bbhive.php");

function converte($term) { 
    return strtr(strtoupper($term),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß"); 
}
function arrumadata($data_errada)
 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
}

	$UrlXML = "../../../datafiles/servicos/bbhive/setup/titulo.xml";

	//cria objeto xml
	$objXML = new DOMDocument();
	$objXML->load($UrlXML); //coloca conteúdo no objeto
		
	
	//le url a ser consultada
	$ConfigXML		= $objXML->getElementsByTagName("titulos")->item(0);
	$tituloTarefas  = converte(mysqli_fetch_assoc($ConfigXML->getElementsByTagName("tarefas")->item(0)->getAttribute("nome")). " pendentes");
		
//--
$tmpExec = $tmpMax = ini_get('max_execution_time');
//--
$sql = "select 
		 a.bbh_usu_codigo, u.bbh_usu_nome,
		 a.bbh_ati_codigo, a.bbh_sta_ati_codigo, f.bbh_flu_codigo, f.bbh_flu_titulo,
		  concat(f.bbh_flu_autonumeracao,'/',f.bbh_flu_anonumeracao) as numero_processo,
		  ma.bbh_mod_ati_nome, u.bbh_usu_apelido, u.bbh_usu_identificacao,
		  
		  d.bbh_dep_nome, s.bbh_sta_ati_nome,
		  a.bbh_ati_inicio_previsto, a.bbh_ati_final_previsto,
		 a.bbh_ati_inicio_real, a.bbh_ati_final_real,
		 COALESCE(DATEDIFF(a.bbh_ati_inicio_previsto,now()),0) as InicioPrevisto,
		 COALESCE(DATEDIFF(a.bbh_ati_inicio_real,now()) ,0)as InicioReal,
		 COALESCE(DATEDIFF(a.bbh_ati_final_previsto,now()),0) as FinalPrevisto,
		 COALESCE(DATEDIFF(a.bbh_ati_final_real,now()) ,0)as FinalReal
		 
		 from bbh_atividade as a
		  inner join bbh_modelo_atividade as ma on a.bbh_mod_ati_codigo = ma.bbh_mod_ati_codigo
		  inner join bbh_fluxo as f on a.bbh_flu_codigo = f.bbh_flu_codigo
		  inner join bbh_usuario as u on a.bbh_usu_codigo = u.bbh_usu_codigo
		  inner join bbh_departamento as d on u.bbh_dep_codigo = d.bbh_dep_codigo
		  inner join bbh_status_atividade as s on a.bbh_sta_ati_codigo = s.bbh_sta_ati_codigo
		
		 where a.bbh_sta_ati_codigo <> 2
		  order by a.bbh_usu_codigo, a.bbh_flu_codigo, ma.bbh_mod_ati_ordem";
//----------------------------------------------------------------------------------------------------
list($sqlAtrasadas, $rows, $totalRows_sql) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
list($sqlProximas, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
//-----------------------------------------------------------------------------------------------------		

function enviaParaEstaPessoa($subject, $origem, $para, $assunto, $smtp, $usuario, $senha, $html){
	require_once('includes/smtp/class.phpmailer.php');
	require_once('includes/smtp/class.smtp.php');	
	//--
	$cabecalho="MIME-Version: 1.0\r\n";
	$cabecalho.="Content-type: text/html; charset=iso-8859-1\r\n";
	$cabecalho.="From: ".$origem."\r\n";
	//--
	$mail = new PHPMailer();
	//--
	$mail->IsSMTP();            // send via SMTP
	$mail->Host     = $smtp; 	// SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = $usuario; // SMTP username
	$mail->Password = $senha; 	// SMTP password
	//--
	$mail->From 	= $origem;
	$mail->FromName = $subject;//"BBHIVE - Blackbee";
	$mail->AddAddress($para,$assunto); 
	//--	
	$mail->WordWrap = 50;		// set word wrap
	$mail->IsHTML(true);		// send as HTML
	//--
	$mail->Subject  =  $assunto;
	$mail->Body     =  $html;
	//Envia
	$mail->Send();
	$html = ob_get_clean();
	unset($html);
}
$query_email = "SELECT * FROM bbh_setup limit 1";
list($email, $row_email, $totalRows) = executeQuery($bbhive, $database_bbhive, $query_email);

//--Dados para envio do email-------------------------------------------------------------------------
		$origem 		= $row_email['bbh_set_email_origem'];
		$smtp			= $row_email['bbh_set_smtp'];
		$usuario		= $row_email['bbh_set_usuario'];
		$senha			= $row_email['bbh_set_senha'];
		$subject 		= $row_email['bbh_set_titulo_origem'];
		$assunto  		= $row_email['bbh_set_assunto'];
//-----------------------------------------------------------------------------------------------------

//--Isso é sempre fixo---------------------------------------------------------------------------------
$cabecalho="<html>
			  <head>
				<title>Mensagem automatica</title>
				<style type='text/css'>
				.verdana_11 { 
					font-family: Verdana, Arial, Helvetica, sans-serif; 
					font-size: 11px; 
					text-decoration: none; 
					letter-spacing: -1px;
				}
				.verdana_12 { 
					font-family: Verdana, Arial, Helvetica, sans-serif; 
					font-size: 12px; 
					text-decoration: none;
				}
				.borderAll {  
					border: 1px #003399 solid;
				}
				
				.borderAlljanela {  
					border-color: #E1E1E1 #333333 #333333 #E1E1E1; 
					border-style: solid; 
					border-top-width: 1px; 
					border-right-width: 1px; 
					border-bottom-width: 1px; 
					border-left-width: 1px;
				}
				</style>
			  </head>
			  <body>";
//-----------------------------------------------------------------------------------------------------
	
//--Isso é sempre fixo-------------------------------------------------------------------------------
$rodape	= "</body></html>";	
//---------------------------------------------------------------------------------------------------

//--Variáveis de controle----------------------------------------------------------------------------
$html = "";	$c = ""; $usuCod=0; $i=0;
//---------------------------------------------------------------------------------------------------		 
			 
	//while($row_sql = mysqli_fetch_assoc($sqlAtrasadas)){
	while($row_sql = mysqli_fetch_assoc($sqlAtrasadas)){
		//--
		$cor = ( ($i%2) == 0 ) ? 'ffffff':'ffffff';
		//--Variáveis de SQL*****************************************************************************
		$dataDeHoje		= date("d/m/Y H:i:s");
		$codigoFluxo 	= $row_sql['bbh_flu_codigo'];
		$tituloFluxo	= converte($row_sql['bbh_flu_titulo']);
		$numeroFluxo	= converte($row_sql['numero_processo']);
		$modeloAtividade= $row_sql['bbh_mod_ati_nome'];
		$nomeSituacao	= $row_sql['bbh_sta_ati_nome'];
		$usuCod 		= $row_sql['bbh_usu_codigo'];
		$emailDestino	= $row_sql['bbh_usu_identificacao'];
		$atrasoEmDias	= $row_sql['FinalPrevisto'] < 0 ? $row_sql['FinalPrevisto'] * (-1) : 0;
		$nomeResponsavel= converte($row_sql['bbh_usu_nome']);

		if(!empty($row_sql['bbh_ati_inicio_real'])){
			$dataInicial= arrumadata($row_sql['bbh_ati_inicio_real']);
		} else {
			$dataInicial.="<div color:#F00'><span style='font-size:9px'>Início Previsto</span></div>";
			$dataInicial.="<label style='color:#F00'>&nbsp;".arrumadata($row_sql['bbh_ati_inicio_previsto'])."</label>";			
		}
		if(!empty($row_sql['bbh_ati_final_real'])){
			$dataFinal=arrumadata($row_sql['bbh_ati_final_real']);
		} else {
			$dataFinal.="<div color:#F00'><span style='font-size:9px'>Final previsto</span></div>";	
			$dataFinal.="<label style='color:#F00'>&nbsp;".arrumadata($row_sql['bbh_ati_final_previsto'])."</label>";				
		}
		//***********************************************************************************************
		
		//--Aumenta o tempo de execução------------------------------------------------------------------
		if($c == 1){
			$tmpMax = $tmpMax + 1;
			set_time_limit($tmpMax);
			$c = -1;
		}
		$c++;
		//-----------------------------------------------------------------------------------------------
		//--Próximo usuário------------------------------------------------------------------------------
		mysqli_data_seek($sqlProximas,($i+1));
		$row_proximo 	= mysqli_fetch_assoc($sqlProximas);
		$proximoUsuario	= $row_proximo["bbh_usu_codigo"];
		//-----------------------------------------------------------------------------------------------

		//Primeiro laço
		if($i==0){
			$usuCod = $row_sql['bbh_usu_codigo'];
		}
		if($proximoUsuario != $usuCod){
			include("configuracao/mensagem/cabeca.php");
			//echo $cabecalho . $cabecalhoHTML;
		}
		
		//Enviando o e-mail:
		$para			= $emailDestino;
			
		//--Conteúdo da mensagem------------------------------------------------------------------------
		if($codFluxo != $codigoFluxo){
		  $cabecaFluxo ='<tr>
					<td height="25" colspan="5" align="left" bgcolor="#E7E7E7" style="border-bottom:solid 1px #666"><strong>::&nbsp;'.$tituloFluxo.' - '.$numeroFluxo.'</strong></td>
				  </tr>';
		}	
		//--
		include("configuracao/mensagem/conteudo.php");
		//-----------------------------------------------------------------------------------------------
		
		//echo "($i) - ".$usuCod . " = >" . $proximoUsuario."<hr>";

		//if($i==0){
			/*if($proximoUsuario != $usuCod){
				$html.="</table>";
				echo $conteudo = $cabecalho . $html . $rodape;
				//--Rodapé do conteúdo--------------------------------------------------------------------------
				include("mensagem/rodape.php");
				//-----------------------------------------------------------------------------------------------
				$html = "";
				echo "<hr>";
			}*/
		/*} elseif($proximoUsuario != $usuCod){
				$html.="</table>";
				echo $conteudo = $cabecalho . $html . $rodape;
				//--Rodapé do conteúdo--------------------------------------------------------------------------
				include("mensagem/rodape.php");
				//-----------------------------------------------------------------------------------------------
				$html = "";
				echo "<hr>";
		}*/
		if($proximoUsuario != $usuCod){
			$html.="</table>";
			include("configuracao/mensagem/rodape.php");
			
			$conteudoMsg = $cabecalho . $cabecalhoHTML . $html . $rodapeHTML . $rodape;
			
			//--Envia mensagem
			enviaParaEstaPessoa($subject, $origem, $para, $assunto, $smtp, $usuario, $senha, $conteudoMsg);
			//--Zera variáveis
			$rodapeHTML 	= "";
			$cabecalhoHTML 	= "";
			$html			= "";
			//echo "<hr>";
		}

		//-----------------------------------------------------------------------------------------------
		$codFluxo 	= $row_sql['bbh_flu_codigo']; 
		$dataInicial= ""; 
		$dataFinal	= "";
		$cabecaFluxo= "";
		$i++;
	}

//Volta o tempo normal
set_time_limit($tmpExec);
//--
?>