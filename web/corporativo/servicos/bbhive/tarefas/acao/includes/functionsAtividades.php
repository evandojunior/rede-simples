<?php
if(!isset($_SESSION)){ session_start();}
require_once($_SESSION['caminhoFisico']."/Connections/bbhive.php");
require_once($_SESSION['caminhoFisico']."/../database/config/globalFunctions.php");

function leXML($codAtividade){
	if(!isset($_SESSION)){ session_start();}
    global $bbhive, $database_bbhive;

	//recebe o código do xml e le os dados
	
	$query_Atividades = "select bbh_ati_andamento from bbh_atividade Where bbh_ati_codigo = $codAtividade";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);
	
	$doc = new DOMDocument("1.0", "utf-8"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel 
	$doc->loadXML($row_Atividades['bbh_ati_andamento']); //coloca conteúdo no objeto
	
	//noh pais
	$leXML	= $doc->getElementsByTagName("andamento")->item(0);
	$totElementos = $leXML->childNodes->length;
		if($totElementos >0){
		  $HTML="";
			foreach($leXML->childNodes as $indice=>$Elemento){
				//tags no xml= id, idUsuario, apelidoUsuario, depUsuario, momento, mensagem
				$nmUsuario 	= $Elemento->getAttribute('apelidoUsuario');
				$depUsuario	= $Elemento->getAttribute('depUsuario');
				$momento	= $Elemento->getAttribute('momento');
				$mensagem	= $Elemento->getAttribute('mensagem');
					
		$img="";
			for($a=0; $a<9; $a++){
				$img.= "<img src='/corporativo/servicos/bbhive/images/separador.gif' style='margin-left:0px;'/>";
			}
				$HTML.= "<img src='/corporativo/servicos/bbhive/images/espaco.gif' align='absmiddle' /><br>";
				$HTML.= "<span style='margin-left:10px;'>";
				$HTML.= "<img src='/corporativo/servicos/bbhive/images/espaco.gif' align='absmiddle' />";
				$HTML.= "<label style='position:absolute;color:#666;margin-left:-19px;z-index:5000'><strong>".($nmUsuario)."</strong></label>";
				$HTML.= "<label style='position:absolute; margin-left:200px;color:#777;z-index:5000'>".($depUsuario)."</label>";
				$HTML.= "<label style='position:absolute; margin-left:420px;z-index:5000' class='color'>".$momento."</label><br />";
				$HTML.= "<img src='/corporativo/servicos/bbhive/images/espaco.gif' align='absmiddle' /><br />";
				$HTML.= "<span style='margin-left:25px; color:#666;'>".nl2br(($mensagem))."</span><br />";
				$HTML.= "<label>";
				$HTML.= "<img src='/corporativo/servicos/bbhive/images/separador.gif' style='margin-left:0px;'/>";
				$HTML.= $img;
				$HTML.= "</label>";
				$HTML.= "</span>";
				$HTML.= "<img src='/corporativo/servicos/bbhive/images/espaco.gif' align='absmiddle' /><br>";
			}
		} else {
			$HTML = "Não há comentários cadastrados!";
		}
		//coloco na sessão atributos de totalizados de nóhs
		$_SESSION['totNosXml'] = $totElementos;
		return $HTML;
}

function contaNohs($codAtividade){
	if(!isset($_SESSION)){ session_start();}
	global $bbhive, $database_bbhive;
	//recebe o código do xml e le os dados

	$query_Atividades = "select bbh_ati_andamento from bbh_atividade Where bbh_ati_codigo = $codAtividade";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);
	
	$doc = new DOMDocument("1.0", "utf-8"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel 
	$doc->loadXML(($row_Atividades['bbh_ati_andamento'])); //coloca conteúdo no objeto
	
	$leXML			= $doc->getElementsByTagName("andamento")->item(0);
	$totElementos 	= $leXML->childNodes->length;
	
	return $totElementos;
}

function atualizaXML($codAtividade, $txtXML){
    global $bbhive, $database_bbhive;

	//recebe o código do xml e le os dados
	$query_Atividades = "select bbh_ati_andamento from bbh_atividade Where bbh_ati_codigo = $codAtividade";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);
	
		$query_dados = "SELECT bbh_dep_nome FROM bbh_usuario INNER JOIN bbh_departamento ON bbh_departamento.bbh_dep_codigo = bbh_usuario.bbh_dep_codigo WHERE bbh_usu_codigo =".$_SESSION['usuCod'];
        list($dados, $row_dados, $totalRows_dados) = executeQuery($bbhive, $database_bbhive, $query_dados);

	$doc = new DOMDocument("1.0", "utf-8"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel 
	$doc->loadXML(($row_Atividades['bbh_ati_andamento'])); //coloca conteúdo no objeto
	
	$leXML	= $doc->getElementsByTagName("andamento")->item(0);
	$idTag  = $leXML->childNodes->length + 1;
	//tags no xml= id, idUsuario, apelidoUsuario, depUsuario, momento, mensagem
		$nvComentario = $doc->createElement('comentario');
		$nvComentario->setAttribute("id",$idTag);
		$nvComentario->setAttribute("idUsuario",$_SESSION['usuCod']);
		$nvComentario->setAttribute("apelidoUsuario",($_SESSION['usuApelido']));
		$nvComentario->setAttribute("depUsuario",($row_dados['bbh_dep_nome']));
		$nvComentario->setAttribute("momento",date('d/m/Y H:i:s'));
		$nvComentario->setAttribute("mensagem",($txtXML));
		
		if($leXML->childNodes->length > 0){	
			$primeiroNoh = $leXML->childNodes->item(0);
			$leXML->insertBefore($nvComentario, $primeiroNoh);
			$doc->appendChild($leXML);
		} else {
			$leXML->appendChild($nvComentario);
			$doc->appendChild($leXML);
		}

	$xml = "<andamento>";
		foreach($leXML->childNodes as $indice=>$Elemento){
			//tags no xml= id, idUsuario, apelidoUsuario, depUsuario, momento, mensagem
			$idTag		= $Elemento->getAttribute('id');
			$idUsuario	= $Elemento->getAttribute('idUsuario');
			$nmUsuario 	= ($Elemento->getAttribute('apelidoUsuario'));
			$depUsuario	= ($Elemento->getAttribute('depUsuario'));
			$momento	= $Elemento->getAttribute('momento');
			$mensagem	= ($Elemento->getAttribute('mensagem'));

			$xml.="<comentario id='".$idTag."' idUsuario='".$idUsuario."' apelidoUsuario='".$nmUsuario."' depUsuario='".$depUsuario."' momento='".$momento."' mensagem='".$mensagem."'/>";
		}
	$xml.= "</andamento>";
	$andamento = "bbh_ati_andamento=\"".$xml."\"";
	
	//atualiza XML
	$updateSQL = "UPDATE bbh_atividade SET $andamento WHERE bbh_ati_codigo=$codAtividade";
    list($Result1, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $updateSQL);
	
	//adicionando comentários a partir de qualquer atividade
	if(getCurrentPage()=="/corporativo/servicos/bbhive/tarefas/acao/includes/comentario.php"){
		echo "Recado enviado com sucesso!!!";
		echo "<var style='display:none'>document.getElementById('comentario_".$codAtividade."').innerHTML='';</var>";
		echo "<var style='display:none'>document.getElementById('comen_".$codAtividade."').className='hide';</var>";
		exit;
	}
	
	$_SESSION['totNosXml'] = $leXML->childNodes->length;
//totais de nohs no xml	
	echo "<var style='display:none'>txtSimples('totAtividadeII', '<strong>".$leXML->childNodes->length." comentários</strong>')</var>";
//echo $_SERVER['PHP_SELF'];
	if(getCurrentPage()!="/corporativo/servicos/bbhive/tarefas/acao/regra.php"){
	 if(isset($_GET['addComentario'])){
		//chama função que le e coloca na tela
		$XML = leXML($codAtividade);
		
		//echo "<var style='display:none'>txtSimples('totAtividade', '<strong>".$leXML->childNodes->length." comentários</strong>')</var>";
		echo "<var style='display:none'>txtSimples('totAtividadeII', '<strong>".($leXML->childNodes->length -1)." comentários</strong>')</var>";
		echo "<var style='display:none'>txtSimples('menHistorico', '".$XML."')</var>";
		echo "<var style='display:none'>document.getElementById('bbh_comentario').innerHTML='';</var>";
		echo "<var style='display:none'>document.getElementById('bbh_comentario').focus()</var>";
	  }
	}
}

function statusAtividade($codAtividade){
    global $bbhive, $database_bbhive;

	$query_status = "select bbh_sta_ati_codigo from bbh_atividade Where bbh_ati_codigo=".$codAtividade;
    list($status, $row_status, $totalRows_status) = executeQuery($bbhive, $database_bbhive, $query_status);
	
	return $row_status['bbh_sta_ati_codigo'];
}

function leXMLRecados($codAtividade){
    global $bbhive, $database_bbhive;

	if(!isset($_SESSION)){ session_start();}
	//recebe o código do xml e le os dados

	$query_Atividades = "select bbh_ati_andamento from bbh_atividade Where bbh_ati_codigo = $codAtividade";
    list($Atividades, $row_Atividades, $totalRows_Atividades) = executeQuery($bbhive, $database_bbhive, $query_Atividades);
	
	$doc = new DOMDocument("1.0", "utf-8"); 
	$doc->preserveWhiteSpace = false; //descartar espacos em branco    
	$doc->formatOutput = false; //gerar um codigo bem legivel 
	$doc->loadXML(($row_Atividades['bbh_ati_andamento'])); //coloca conteúdo no objeto
	
	//noh pais
	$leXML	= $doc->getElementsByTagName("andamento")->item(0);
	$totElementos = $leXML->childNodes->length;
	$Tem=0;
		if($totElementos >0){
		  $HTML="";
			foreach($leXML->childNodes as $indice=>$Elemento){
			 $idUsuario	= $Elemento->getAttribute('idUsuario');
			  if($idUsuario==$_SESSION['usuCod']){
			   $Tem = 1;
				//tags no xml= id, idUsuario, apelidoUsuario, depUsuario, momento, mensagem
				$nmUsuario 	= $Elemento->getAttribute('apelidoUsuario');
				$depUsuario	= $Elemento->getAttribute('depUsuario');
				$momento	= $Elemento->getAttribute('momento');
				$mensagem	= $Elemento->getAttribute('mensagem');

				$HTML.= "<tr class='verdana_11'>
							  <td width='140' height='22' bgcolor='#FFFFFF' align='left'><span style='color:#666;'>".($nmUsuario)."</span></td>
							  <td width='101' bgcolor='#FFFFFF' align='left'><span style='color:#666;'>".($depUsuario)."</span></td>
							  <td width='107' bgcolor='#FFFFFF' align='left'><span style='color:#666;'>".$momento."</span></td>
							</tr>
							<tr>
							  <td height='1' colspan='3' align='left' bgcolor='#FFFFFF'><span class='color'>".nl2br(($mensagem))."</span></td>
							</tr>
							<tr>
								<td height='1' colspan='3' valign='top' background='/corporativo/servicos/bbhive/images/separador.gif'></td>
							</tr>";
				}
			 }
		} 
		if($Tem==0) {
			$HTML = "Não há comentários cadastrados!";
		}
		//coloco na sessão atributos de totalizados de nóhs
		return $HTML;
}
?>