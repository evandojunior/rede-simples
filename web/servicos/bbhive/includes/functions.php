<?php

// Global Functions
require_once(__DIR__ . "/../../../../database/config/globalFunctions.php");

function calc_idade($nascimento){
	$hoje = date("d-m-Y"); //pega a data d ehoje
	$aniv = explode("-", $nascimento); //separa a data de nascimento em array, utilizando o símbolo de - como separador
	$atual = explode("-", $hoje); //separa a data de hoje em array
	  
	$idade = $atual[2] - $aniv[2];
	
		if($aniv[1] > $atual[1]) //verifica se o mês de nascimento é maior que o mês atual
		{
			$idade--; //tira um ano, já que ele não fez aniversário ainda
		}
		elseif($aniv[1] == $atual[1] && $aniv[0] > $atual[0]) //verifica se o dia de hoje é maior que o dia do aniversário
		{
			$idade--; //tira um ano se não fez aniversário ainda
		}
		return $idade; //retorna a idade da pessoa em anos
} 
function trataEmail($email){
	$email = str_replace("@","_",$email);
	$email = str_replace(".","_",$email);
	return $email;
}

if (!function_exists("apostrofo")) {
    function apostrofo($txt)
    {
        return str_replace("'", "`", $txt);
    }
}

function retiraExcessoDeEspaco($str){
	return preg_replace('/\s\s+/', ' ', trim($str));
}
if (!function_exists("converte")) {
    function converte($term)
    {
        return strtr(strtoupper($term), "àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ", "ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    }
}
/*===================================================================================================*/

//Convertendo um dado do tipo DateTime do mysql para o padrão Brasileiro.
function converteData($data_ori,$tipo='BR',$hora='true'){
	$data = explode(' ',$data_ori);
	if ($tipo == 'BR'){
	$resul = explode("-",$data[0]);
	$resul = $resul[2].'/'.$resul[1].'/'.$resul[0];
	}elseif ($tipo == 'EN'){
	$resul = explode("/",$data[0]);
	$resul = $resul[2].'-'.$resul[1].'-'.$resul[0];
	}
	
	if ($hora)
	return $resul.' '.$data[1];
	else
	return $resul;
}

function normatizaCep($codigo){
	$codigoUnitario = explode(".",$codigo);
	$codigoPadrao = "";
	for($cont = 0; $cont < count($codigoUnitario); $cont++)	{
		$codigoPadrao .= (int)$codigoUnitario[$cont] . ".";	
	}
	
	return substr($codigoPadrao,0,strlen($codigoPadrao)-1);
}

	//Faz um switch para mostrar o mês em português
		function RetornaMes($mes){
			switch($mes){
				case "Jan" : $mescerto = "Janeiro /"; break;
				case "Feb" : $mescerto = "Fevereiro /"; break;
				case "Mar" : $mescerto = "Março /"; break;
				case "Apr" : $mescerto = "Abril /"; break;
				case "May" : $mescerto = "Maio /"; break;
				case "Jun" : $mescerto = "Junho /"; break;
				case "Jul" : $mescerto = "Julho /"; break;
				case "Aug" : $mescerto = "Agosto /"; break;
				case "Sep" : $mescerto = "Setembro /"; break;
				case "Oct" : $mescerto = "Outubro /"; break;
				case "Nov" : $mescerto = "Novembro /"; break;
				case "Dec" : $mescerto = "Dezembro /"; break;
			}
			return($mescerto);
		}

function verificaExtensaoP($extensao){		
	switch($extensao){
		case "xls": $gif = "arquivo_excel-pequeno.gif";
		break;
		case "pdf": $gif = "arquivo_pdf-pequeno.gif";
		break;
		case "doc": $gif = "arquivo_word_pequeno.gif";
		break;
		default: $gif = "arquivo_doc-pequeno.gif";
		break;
	}
		return($gif);
}

function redimencionaImg($ImagemOriginal, $IdUsuario){
	// define a imagem a partir da qual será gerada a minuatura
	//$imagem = "imagem_original.jpg";
	$imagem = $ImagemOriginal;
	
	// **** configurações da miniatura *******
	$tamanho_fixo 	= "N";    // S ou N
	$largura_fixa 	= 192;    // usado somente com tamanho_fixo=S
	$altura_fixa 	= 144;    // usado somente com tamanho_fixo=S
	$percentual 	= 40;      // usado somente com tamanho_fixo=N
	// **************************************
	
	if(!file_exists($imagem)){
		echo "Arquivo da imagem n&atilde;o encontrado!";
		exit;
	}
	if($tamanho_fixo=="N" && ($percentual<1 || $percentual>100)){
		echo "O percentual deve ser um número entre 1 e 100!";
		exit;
	}
	
	// monta o nome do arquivo resultante
	$arquivo_miniatura = explode('.', $imagem);
	$arquivo_miniatura = $arquivo_miniatura[0].$IdUsuario."_mini.jpg";
	
	// lê a imagem de origem e obtém suas dimensões
	$img_origem = ImageCreateFromJPEG($imagem);
	$origem_x = ImagesX($img_origem);
	$origem_y = ImagesY($img_origem);
	
	// se não for tamanho fixo, calcula as dimensões da miniatura
	if($tamanho_fixo=="S"){
		$x = $largura_fixa;
		$y = $altura_fixa;
	}else{
		$x = intval ($origem_x * $percentual/100);
		$y = intval ($origem_y * $percentual/100);
	}
	
	// cria a imagem final, que irá conter a miniatura
	$img_final = ImageCreateTrueColor($x,$y);
	
	// copia a imagem original redimensionada para dentro da imagem final
	ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x+1, $y+1, $origem_x , $origem_y);
	
	// salva o arquivo
	ImageJPEG($img_final, $arquivo_miniatura);
	
	// libera a memória alocada para as duas imagens
	ImageDestroy($img_origem);
	ImageDestroy($img_final);
	
	//return $arquivo_miniatura." (".$x." x ".$y.")";
	return $arquivo_miniatura;
}

function imagem($width,$height,$imagem,$aprox=51){
	$x = $width;
	$y = $height;
		if($x >= $y){
			if($x > $aprox){
				$x1= (int)($x * ($aprox/$x));
				$y1= (int)($y * ($aprox/$x));
			} else {
				 $x1 = $x;
				 $y1 = $y;
			}
 		} else {
			 if($y > $aprox){
				 $x1 = (int)($x * ($aprox/$y));
				 $y1 = (int)($y * ($aprox/$y));
			 } else {
				 $x1 = $x;
				 $y1 = $y;
			 }
 		}
		
 $x = $x1;
 $y = $y1;
 return '<img src="'.$imagem.'" width="'.$x.'" height="'.$y.'" border="0">';
}

if (!function_exists("Real")) {
    function Real($valor)
    {
        $valor = (int)$valor;
        $valorretorno = number_format($valor, 2, ',', '.');
        return $valorretorno;
    }
}
	
function determinar_idade($data) {
	#Pegamos o dia
	$dia =  substr($data, 0, 2);
	#O mês
	$mes = substr($data, 3, 2);
	#O ano
	$ano = substr($data, 6, 4);

	#Checamos se a data é válida
	if(checkdate($mes, $dia, $ano)) {
		#Calculamos a diferença entre o aniversário e a data atual
		$diferenca_dia = date("d") - $dia;
		$diferenca_mes = date("m") - $mes;
		$diferenca_ano = date("Y") - $ano;

		#Checamos se o mês de aniversário já chegou
		if($diferenca_mes < 0) {
			#O mês de aniversário não chegou, é subtraido um ano da idade
			$diferenca_ano--;
		}
		#Se o mês de aniversário já chegou...
		elseif($diferenca_mes=="0") {
			#Checamos se o dia do aniversário já chegou
			if($diferenca_dia < 0) {
				#O dia de aniversário não chegou, é subtraido um ano da idade
				$diferenca_ano--;
			}
		}

		return $diferenca_ano;
	}
	else {
		return "Data inválida";
	}
}

function addDayIntoDate($date,$days) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday + $days, $thisyear );
     return strftime("%Y%m%d", $nextdate);
}

function subDayIntoDate($date,$days) {
     $thisyear = substr ( $date, 0, 4 );
     $thismonth = substr ( $date, 4, 2 );
     $thisday =  substr ( $date, 6, 2 );
     $nextdate = mktime ( 0, 0, 0, $thismonth, $thisday - $days, $thisyear );
     return strftime("%Y%m%d", $nextdate);
}

function Diferenca($data1, $data2="",$tipo=""){
	
		if($data2==""){
		$data2 = date("d/m/Y H:i");
		}
		
		if($tipo==""){
		$tipo = "h";
		}
		
		for($i=1;$i<=2;$i++){
			${"dia".$i} = substr(${"data".$i},0,2);
			${"mes".$i} = substr(${"data".$i},3,2);
			${"ano".$i} = substr(${"data".$i},6,4);
			${"horas".$i} = substr(${"data".$i},11,2);
			${"minutos".$i} = substr(${"data".$i},14,2);
		}
		
		$segundos = mktime($horas2,$minutos2,0,$mes2,$dia2,$ano2) - mktime($horas1,$minutos1,0,$mes1,$dia1,$ano1);
		
		switch($tipo){
		
		 case "m": $difere = $segundos/60;    break;
		 case "H": $difere = $segundos/3600;    break;
		 case "h": $difere = round($segundos/3600);    break;
		 case "D": $difere = $segundos/86400;    break;
		 case "d": $difere = round($segundos/86400);    break;
		}
	
	return $difere;
}

function pegaMimeType($arquivo){
 $mime = $arquivo;
	switch($mime){
		case "image/jpeg":  		 		  $imagem = "mime-jpg.gif";		break;
		case "image/pjpeg": 		 	 	  $imagem = "mime-jpg.gif";		break;
		case "text/asp":	 		 		  $imagem = "mime-asp.gif";		break;
		case "video/avi":	 		 		  $imagem = "mime-avi.gif";		break;
		case "image/bmp":	 		 	 	  $imagem = "mime-bmp.gif";		break;
		case "text/css":	 		 		  $imagem = "mime-css.gif";		break;
		case "application/msword":	 		  $imagem = "mime-word.gif";	break;
		case "application/octet-stream":	  $imagem = "mime-exe.gif";		break;
		case "application/x-gzip":	 		  $imagem = "mime-gz.gif";		break;
		case "text/html":			 		  $imagem = "mime-html.gif";	break;
		case "image/gif":			 		  $imagem = "mime-gif.gif";		break;
		case "text/x-java-source":	 		  $imagem = "mime-java.gif";	break;
		case "text/plain":			 	 	  $imagem = "mime-txt.gif";		break;
		case "application/x-midi":	 		  $imagem = "mime-midi.gif";	break;
		case "audio/midi":			 		  $imagem = "mime-midi.gif";	break;
		case "audio/mpeg3":			 	 	  $imagem = "mime-mpg.gif";		break;
		case "audio/x-mpeg-3":	 			  $imagem = "mime-mpg.gif";		break;
		case "video/mpeg":	 				  $imagem = "mime-mpg.gif";		break;
		case "video/x-mpeg": 				  $imagem = "mime-mpg.gif";		break;
		case "audio/mpeg":	 			 	  $imagem = "mime-mpg.gif";		break;
		case "image/png":	 				  $imagem = "mime-png.gif";		break;
		case "image/x-png":	 				  $imagem = "mime-png.gif";		break;
		case "application/mspowerpoint":	  $imagem = "mime-ppt.gif";		break;
		case "application/vnd.ms-powerpoint": $imagem = "mime-ppt.gif";		break;
		case "application/powerpoint":	 	  $imagem = "mime-ppt.gif";		break;
		case "application/x-mspowerpoint": 	  $imagem = "mime-ppt.gif";		break;
		case "audio/x-pn-realaudio": 		  $imagem = "mime-rmvb.gif";	break;
		case "application/vnd.rn-realmedia":  $imagem = "mime-rmvb.gif";	break;
		case "application/rtf":		 		  $imagem = "mime-rtf.gif";		break;
		case "audio/text/richtext": 		  $imagem = "mime-rtf.gif";		break;
		case "application/x-rtf": 			  $imagem = "mime-rtf.gif";		break;
		case "text/x-server-parsed-html":	  $imagem = "mime-html.gif";	break;
		case "application/x-shockwave-flash": $imagem = "mime-swf.gif";		break;
		case "application/image/tiff": 		  $imagem = "mime-tiff.gif";	break;
		case "image/x-tiff": 				  $imagem = "mime-tiff.gif";	break;
		case "image/tiff":					  $imagem = "mime-tiff.gif";	break;
		case "audio/wav":					  $imagem = "mime-wav.gif";		break;
		case "audio/x-wav": 				  $imagem = "mime-wav.gif";		break;
		case "application/excel": 			  $imagem = "mime-xls.gif";		break;
		case "application/vnd.ms-excel": 	  $imagem = "mime-xls.gif";		break;
		case "application/x-excel":			  $imagem = "mime-xls.gif";		break;
		case "application/excel": 			  $imagem = "mime-xls.gif";		break;
		case "application/x-msexcel": 		  $imagem = "mime-xls.gif";		break;
		case "application/x-compressed":	  $imagem = "mime-zip.gif";		break;
		case "application/x-zip-compressed":  $imagem = "mime-zip.gif";		break;
		case "application/zip":				  $imagem = "mime-zip.gif";		break;
		case "multipart/x-zip":				  $imagem = "mime-zip.gif";		break;		
		case "application/pdf":				  $imagem = "mime-pdf.gif";		break;
		case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":  $imagem = "mime-word.gif";	break;
		
		default:							  $imagem = "mime-etc.gif";		break;
	}
	return $imagem;
}

if (!function_exists("trataCaracteres")) {
    function trataCaracteres($texto)
    {
        /* função que gera uma texto limpo pra virar URL:
           - limpa acentos e transforma em letra normal
           - limpa cedilha e transforma em c normal, o mesmo com o ñ
           - transforma espaços em hifen (-)
           - tira caracteres invalidos
          by Micox - elmicox.blogspot.com - www.ievolutionweb.com
        */
        //desconvertendo do padrão entitie (tipo &aacute; para á)
        $texto = html_entity_decode($texto);
        //tirando os acentos
        //$texto = str_replace('[aáàãâä]','a',$texto);
        $texto = preg_replace('/[aáàãâä]/', 'a', $texto);
        //$texto = str_replace('[eéèêë]','e',$texto);
        $texto = preg_replace('/[eéèêë]/', 'e', $texto);
        //$texto = str_replace('[iíìîï]','i',$texto);
        $texto = preg_replace('/[iíìîï]/', 'i', $texto);
        //$texto = preg_replace('[oóòõôö]','o',$texto);
        $texto = preg_replace('/[oóòõôö]/', 'o', $texto);
        //$texto = str_replace('[uúùûü]','u',$texto);
        $texto = preg_replace('/[uúùûü]/', 'u', $texto);
        //parte que tira o cedilha e o ñ
        //$texto = str_replace('[ç]','c',$texto);
        $texto = preg_replace('/[ç]/', 'c', $texto);
        // $texto = str_replace('[ñ]','n',$texto);
        $texto = preg_replace('/[ñ]/', 'n', $texto);
        //trocando espaço em branco por underline
        //$texto = str_replace('( )','_',$texto);
        $texto = preg_replace('/( )/', '_', $texto);
        //$texto = str_replace(' ','_',$texto);
        $texto = preg_replace('/ /', '_', $texto);
        //tirando outros caracteres invalidos
        //$texto = str_replace('[^a-z0-9\-]','_',$texto);
        $texto = preg_replace('/[^a-z0-9\-]/', '_', $texto);
        //trocando duplo espaço (hifen) por 1 hifen só
        // $texto = str_replace('--','_',$texto);
        $texto = preg_replace('/[--]/', '_', $texto);
        //$texto = str_replace('-','_',$texto);
        $texto = preg_replace('/[-]/', '_', $texto);

        return strtolower($texto);
    }
}

function dataSQL($valor){

	$data  = substr($valor,6,4) . "-";
	$data .= substr($valor,3,2) . "-";
	$data .= substr($valor,0,2);

	return $data;
}

function unidadeMedida($unidade, $acao){ $termo="";
	if($acao == 0){//Quero apenas exibir as opções
		return array("kg"=>"Quilograma","m"=>"Metro","cx"=>"Caixa","pc"=>"Peça","l"=>"Litro","un"=>"Unidade");
		exit;
	}
	//Quero apenas comparar
	switch($unidade){
		case "kg":  $termo = "Quilograma";	break;
		case "m": 	$termo = "Metro";		break;
		case "cx":	$termo = "Caixa";		break;
		case "pc":	$termo = "Peça";		break;
		case "l":	$termo = "Litro";		break;
		case "un":	$termo = "Unidade";		break;
	}
	return $termo;
}
function selfURL(){
    if(!isset($_SERVER['REQUEST_URI'])){
        $serverrequri = $_SERVER['PHP_SELF'];
    }else{
        $serverrequri =    $_SERVER['REQUEST_URI'];
    }
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    return $protocol."://".$_SERVER['SERVER_NAME'].$port;//.$serverrequri;   
}
function strleft($s1, $s2) {
	return substr($s1, 0, strpos($s1, $s2));
}
function TamanhoArquivo($cFile) 
{ $cFile = str_replace("//","/",$cFile);
         if ( file_exists($cFile) ){ 
            $nSize = filesize($cFile); 
            if ($nSize<1024) { return strval($nSize).' bytes'; } 
            if ($nSize<pow(1024,2)) { return number_format($nSize/1024, 1).' KB'; } 
            if ($nSize<pow(1024,3)) { return number_format($nSize/pow(1024,2),1).' MB'; } 
            if ($nSize<pow(1024,4)) { return number_format($nSize/pow(1024,3),1).' GB'; } 
         } 
} 

//
// Função implementada em 02/02/2012
// Retorna a visualização de um array em html
function echo_r( $array = array(), $retorno = false )
{
	$return = "<pre>". print_r($array, true) ."</pre>";
	
	if( $retorno == true )
		return $return;
		
	echo $return;
}


//
// Função implementada em 02/02/2012
// Retorna o nível de permissão do usuário informado ou caso não seja passado do usuário logado
function permissoes_nivel( $usuario = 0 )
{
	// Conversao
	$usuario = (int) $usuario;
	
	// Verificação
	if( $usuario == 0 ) $usuario = $_SESSION['MM_BBhive_Codigo'];
	
	// Torna local
	global $database_bbhive, $bbhive;
	
	// SQL
	$sql = "
	SELECT
		MAX(bbh_perfil.bbh_per_matriz) as bbh_per_matriz, MAX(bbh_perfil.bbh_per_unidade) as bbh_per_unidade,
		bbh_usuario.bbh_usu_codigo, bbh_usuario.bbh_usu_nome, bbh_usuario.bbh_usu_apelido, bbh_usuario.bbh_usu_permissao_dep
		
	FROM 
		bbh_usuario_perfil
		
		INNER JOIN bbh_usuario ON bbh_usuario.bbh_usu_codigo = bbh_usuario_perfil.bbh_usu_codigo
		INNER JOIN bbh_perfil ON bbh_perfil.bbh_per_codigo = bbh_usuario_perfil.bbh_per_codigo
		
	WHERE 
		bbh_usuario.bbh_usu_codigo = $usuario
	
	ORDER BY
		bbh_perfil.bbh_per_matriz DESC, bbh_perfil.bbh_per_unidade DESC
	
	LIMIT 1
	";
    list($query, $fetch, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql);
	
	// Associa
	
	// Retorno
	$return						= array();
	$return['codigo']			= $fetch['bbh_usu_codigo'];
	$return['nome']				= $fetch['bbh_usu_nome'];
	$return['apelido']			= $fetch['bbh_usu_apelido'];
	$return['per_matriz']		= $fetch['bbh_per_matriz'];
	$return['per_unidade']		= $fetch['bbh_per_unidade'];
	$return['per_departamento']	= $fetch['bbh_usu_permissao_dep'];
	
	// Retorna as informações
	return $return;
}

?>