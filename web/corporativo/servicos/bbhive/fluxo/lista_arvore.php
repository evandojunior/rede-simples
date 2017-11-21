<?PHP
//
// Arquivo de conexão com DB
//
require "../../../../Connections/bbhive.php";
require "../../../../../database/config/globalFunctions.php";

//
// Manda mostrar todos os erros
//
ini_set('display_errors', true);

//
// Pega a iformação se é para concatenar sim ou não
//
$concatena = true;



//
// Simula um GET
//
if( preg_match('/\?=([^&]+)/', $_SERVER['REQUEST_URI'], $matches) )
{
	$_GET['nomeDinamico'] = $matches[1];
}

if( preg_match('/&=([^&]+)/', $_SERVER['REQUEST_URI'], $matches) )
{
	$_GET['titulo'] = $matches[1];
}


//
// Tira a decodificação
//
$_GET['titulo'] = urldecode($_GET['titulo']);

//
// Função que retorna um array ordernado pela maskara
//
function recursiveMaskara( $maskara = '', $recursivo = 0 )
{
	// Torna a conexão global
	global $database_bbhive, $bbhive;
	
	//
	$maskara = $maskara != '' ? $maskara.'.' : $maskara;
	
	// SQL
	$sql = "
	SELECT
		*
	FROM
		`bbh_campo_lista_dinamica` as din
		
	WHERE
		din.bbh_cam_list_mascara <> '0'
		 AND
		din.bbh_cam_list_mascara LIKE '$maskara%'
		 AND
		din.bbh_cam_list_titulo = '".$_GET['titulo']."'
	
	GROUP BY
		LEFT(din.bbh_cam_list_mascara,".(strlen($maskara)+2).") 
		
	ORDER BY 
		RIGHT(din.bbh_cam_list_mascara, 2)
	";
    list($exe, $rows, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	
	// Retorno
	$retorno = array();
		
	while( $fetch = mysqli_fetch_assoc($exe) )
	{
		
		// Pega todos os filhos desta maskara
		$filhos = array();
		
		//-- Caso seja recursivo
		if( $recursivo )
		{
			$filhos = recursiveMaskara( $fetch['bbh_cam_list_mascara'], $recursivo );
			$countFilhos = count($filhos);
		}
		else
		{
			$filho = recursiveMaskara( $fetch['bbh_cam_list_mascara'], 0 );	
			$countFilhos = count($filho);
		}
		
		
		// Verifica se a maskara é pai e/ou filho
		$fetch['pai'] = 0 == $countFilhos ? '0' : '1'; 
		$fetch['filho'] = $maskara == '' ? '0':'1';

		// Anexa os resultados ao array
		$retorno[] = $fetch;
		
		// Concatena os resultados
		$retorno = array_merge($retorno, $filhos);
	}
	
	//-- Volta
	return $retorno;
}

//
// Via ajax
//
if( isset($_GET['maskara']))
{
	
	foreach( recursiveMaskara($_GET['maskara'],0) as $lista )
	{
    //-- Formatação da tabela
    $class = array('pai');
    
    //-- Caso seja pai
	//if( $lista['pai'] == '1' ) $class[] = 'pai';
    
    //-- Caso seja filho
    //if( $lista['filho'] == '1' ) $class[] = 'filho';
    
	//-- Escreve os resultados
    echo '<table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="'.join(' ', $class).'">';
    echo '<tr>';
	echo '<td width="150" height="20" class="verdana_12">';
	echo '<img ';
	
		//-- Verifica se é para mostra imagem de pai ou não
		if( $lista['pai'] == '1' )
			echo 'src="/corporativo/servicos/bbhive/images/debito.gif" onclick="consulta.infor(\''.$lista['bbh_cam_list_mascara'].'\', this);"';
		else
			echo 'src="/corporativo/servicos/bbhive/images/espaco.gif"';
	
	echo ' width="10" heigh="10" align="absmiddle" />&nbsp;';
	echo '<a href="javascript:void(0)" onclick="parent.popula(\''.( ($concatena)?$lista['bbh_cam_list_mascara']:'').' '.$lista['bbh_cam_list_valor'].'\');">';
	echo $lista['bbh_cam_list_mascara'];
	echo '</a>';
	echo '</td>';
    echo '<td width="350" class="verdana_12">';
	echo '<a href="javascript:void(0)" onclick="parent.popula(\''.( ($concatena)?$lista['bbh_cam_list_mascara']:'').' '.$lista['bbh_cam_list_valor'].'\');">';
	echo str_pad('', strlen($lista['bbh_cam_list_mascara'])-2, '-').' '.trim($lista['bbh_cam_list_valor']).'</td>';
	echo '</a>';
    echo '</tr>';
	echo '<tr>';
    echo '<td colspan="3" background="/corporativo/servicos/bbhive/images/separador.gif" height="1"></td>';
  	echo '</tr>';
    echo '</table>';
    echo '<div id="div_'.strtr($lista['bbh_cam_list_mascara'],'.','_').'" style="display:none" class="div_filho verdana_12">&nbsp;</div>';
    }
	
	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" type="text/css" href="/corporativo/servicos/bbhive/includes/bbhive.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Lista dinamica - árvore</title>
<style>
.pai{
	cursor:pointer;
}
.filho{
	display:none;	
}
.divFilho{
	min-height: 1px;
	display : none;
}
table tr td{
	padding-left: 10px;	
}
</style>
<script type="text/javascript">
var consulta = {
	
	getAjax : function()
	{
			if(typeof(XMLHttpRequest)!='undefined')
			{
				return new XMLHttpRequest();
			}
			
			var xmlajax = ['Microsoft.XMLHTTP','Msxml2.XMLHTTP','Msxml2.XMLHTTP.6.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0'];
			
			for(var i=0;i<xmlajax.length;i++)
			{
				try
				{
					return new ActiveXObject(xmlajax[i]);
				}
				catch(e){}
			}
			
			return null;
	},
	
	infor : function(maskara, _this)
	{
		//
		msk = 'div_'+maskara.replace(/\./g,'_');
		
		//
		ajax = this.getAjax();
		
		//
		document.getElementById(msk).style.display = '';
		document.getElementById(msk).innerHTML = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Carregando lista...';
		
		//
		_url = '/corporativo/servicos/bbhive/fluxo/lista_arvore.php?=<?PHP echo $_GET['nomeDinamico']; ?>&=<?PHP echo $_GET['titulo']; ?>&maskara='+ maskara +'&time='+new Date().getTime();
		
		//	
		ajax.open("GET", _url, true);
		ajax.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		ajax.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
		ajax.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
		ajax.setRequestHeader("Pragma", "no-cache");
		ajax.onreadystatechange = function()
		{
				if(ajax.readyState == 4)
				{
					if( ajax.status == 200 )
					{	
						document.getElementById(msk).innerHTML = ajax.responseText;
					}
				}
		}
		ajax.send();
		
		//-- Retira a imagem
		if( _this != '' )
		{
			_this.onclick = function onclick(event){ consulta.toggle(maskara, this); }
			_this.src = '/corporativo/servicos/bbhive/images/credito.gif';
		}
	},
	
	// Quando se recarrega a div, troca-se a função, asumindo-se essa nova
	// que irá abrir ou ocultar a div
	toggle : function(maskara, _this)
	{
		//
		msk = 'div_'+maskara.replace(/\./g,'_');
		
		if( document.getElementById(msk).style.display == 'none' )
		{
			document.getElementById(msk).style.display = '';
			_this.src = '/corporativo/servicos/bbhive/images/credito.gif';
		}else{
			document.getElementById(msk).style.display = 'none';
			_this.src = '/corporativo/servicos/bbhive/images/debito.gif';
		}
	}
	
}
</script>
</head>

<body style="background:#FFFFFF">


<table width="500" border="0" cellspacing="0" cellpadding="0" align="center" style='font-weight:bold;'>
  <tr>
    <td width="500" height="20" colspan="2" align="center" class="verdana_18">
    <h2 style='margin:0;padding:0;'><?PHP echo $_GET['titulo']; ?></h2>
    </td>
  </tr>
  <tr>
    <td width="150" height="30" style="background:url(/corporativo/servicos/bbhive/images/barra_horizontal.jpg);">M&aacute;scara</td>
    <td width="350" height="30" style="background:url(/corporativo/servicos/bbhive/images/barra_horizontal.jpg);">T&iacute;tulo</td>
  </tr>
</table>

<div id="div_" class="verdana_12"></div>
<script type="text/javascript">
consulta.infor('','');
</script>

</body>
</html>
