<?php
$Link		= "LoadSimultaneo('perfil/index.php?perfil=1&mensagens=1|mensagens/XX|includes/colunaDireita.php?fluxosDireita=1&equipeMensagens=1&eventos=1','menuEsquerda|colCentro|colDireita')";
//--------------------------------------------------------------------------------------------------------------------
$menu 		= array();
//--------------------------------------------------------------------------------------------------------------------
$dest		= "index.php?caixaEntrada=True";
$menu[0] 	= '<a href="#@" onClick="'.str_replace("XX",$dest,$Link).'"><img src="/corporativo/servicos/bbhive/images/caixaentrada.gif" alt="" width="16" height="16" align="absmiddle" border="0" /> Caixa de entrada</a>';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "index.php?caixaSaida=True";
$menu[1]	= '<a href="#@" onClick="'.str_replace("XX",$dest,$Link).'"><img src="/corporativo/servicos/bbhive/images/caixasaida.gif" alt="" width="16" height="16" border="0" align="absmiddle" border="0" /> Cx. de Sa&iacute;da</a>';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "envio/regra.php?escreverMensagem=True";
$Equipe		= "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&exibeMensagem=true&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";

$menu[2]	= '<a href="#@" onClick="'.$Equipe.'"><img src="/corporativo/servicos/bbhive/images/escrever-email.gif" alt="" width="16" height="16" border="0" align="absmiddle" border="0" /> Escrever</a>';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "index.php?caixaLixeira=True";
$menu[3]	= '<a href="#@" onClick="'.str_replace("XX",$dest,$Link).'"><img src="/corporativo/servicos/bbhive/images/lixeira16px.gif" alt="" width="16" height="16" border="0" align="absmiddle" border="0" /> Lixeira</a>';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "";
$menu[4]	= '<a href="#@" onclick="return verificaForm(\'/corporativo/servicos/bbhive/mensagens/envio/executa.php\',\'formMsg\');"><img src="/corporativo/servicos/bbhive/images/exc.gif" alt="" width="16" height="15" border="0" align="absmiddle" /> Excluir selecionadas</a>';
//--------------------------------------------------------------------------------------------------------------------
$menu[5]	= '';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "envio/responder.php?bbh_men_codigo=".@$_GET['bbh_men_codigo'];
$menu[6]	= '<a href="#@" onClick="'.str_replace("XX",$dest,$Link).'"><img src="/corporativo/servicos/bbhive/images/reply.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Responder</a>';
//--------------------------------------------------------------------------------------------------------------------
$Equipe		= "showHome('includes/home.php','conteudoGeral','perfil/index.php?perfil=1&equipe=1|equipe/index.php?chefe=0&subordinados=0&tomadores=0&prestadores=0&todosEmpresa=1&bbh_men_codigo=".@$_GET['bbh_men_codigo']."|includes/colunaDireita.php?fluxo=1&equipeFluxos=1&exibeMensagem=true&arquivosFluxos=1&relatorios=1','menuEsquerda|colCentro|colDireita');";
$menu[7]	= '<a href="#@" onClick="'.$Equipe.'"><img src="/corporativo/servicos/bbhive/images/encaminhar.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Encaminhar</a>';
//--------------------------------------------------------------------------------------------------------------------
$dest		= "/corporativo/servicos/bbhive/mensagens/envio/executa.php";
$menu[8]	= '<a href="#@" onClick="excluiMensagem(\''.$dest.'\', \'formMsg\')"><img src="/corporativo/servicos/bbhive/images/lixeira16px.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Excluir</a>';
//--------------------------------------------------------------------------------------------------------------------
$menu[9]	= '<a href="#@"><img src="/corporativo/servicos/bbhive/images/email_aberto.gif" alt="" width="16" height="16" border="0" align="absmiddle" /> Mensagem</a>';


	if(isset($caixaEntrada)){
		$ord_0 = 0;//entrada
		$ord_1 = 2;//escrever
		$ord_2 = 1;//saida
		$ord_3 = 3;//lixeira
		$ord_4 = 4;//exclusão
	} elseif(isset($caixaSaida)){
		$ord_0 = 1;
		$ord_1 = 2;
		$ord_2 = 0;
		$ord_3 = 3;
		$ord_4 = 4;
	} elseif(isset($caixaLixeira)){
		$ord_0 = 3;
		$ord_1 = 2;
		$ord_2 = 0;
		$ord_3 = 1;
		$ord_4 = 4;
	} elseif(isset($novaMensagem)){
		$ord_0 = 2;
		$ord_1 = 0;
		$ord_2 = 1;
		$ord_3 = 3;
		$ord_4 = 5;	
	} elseif(isset($detalheMensagem)){
		$ord_0 = 9;
		$ord_1 = 2;
		$ord_2 = 6;
		$ord_3 = 7;
		$ord_4 = 8;
	}
?>