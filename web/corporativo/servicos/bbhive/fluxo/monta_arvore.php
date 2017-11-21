<?PHP
//
// Arquivo de conexão com DB
//

require_once "../../../../Connections/bbhive.php";
require_once "../../../../../database/config/globalFunctions.php";

//
// Manda mostrar todos os erros
//
ini_set('display_errors', true);


//
// O filho a quem será procurado 
// todos os seus parentes
// 
if( preg_match('/\?=([^&]+)/', $_SERVER['REQUEST_URI'], $matches) )
{
	$filhoGet = $matches[1];
}

//
// Separa por niveis
//
$filho = explode('.', $filhoGet);

//
// Contagem de niveis
//
$total = count($filho);

//
// Guarda os valores dos resultados obtidos
//
$arrayValores = array();

//
// Pecorre a maskara montando as consultas e trazendos os resultados
//
for( $f=0; $f<$total; $f++ )
{
	$maskara = implode('.', $filho);
	
	$sql = "
		SELECT
		*
	FROM
		`bbh_campo_lista_dinamica` as din
		
	WHERE
		din.bbh_cam_list_mascara <> '0'
		 AND
		din.bbh_cam_list_mascara = '$maskara'
	";
    list($exe, $row, $totalRows) = executeQuery($bbhive, $database_bbhive, $sql, $initResult = false);
	
	if( 0 < mysqli_num_rows($exe) )
	{
		//
		$fetch = mysqli_fetch_assoc($exe);
		//
		$arrayValores[] = array('mascara'=>$fetch['bbh_cam_list_mascara'], 'valor'=> $fetch['bbh_cam_list_valor']);
	}
	
	// Retira o ultimo nivel
	array_pop($filho);
}

//
// Inverte os valores
//
$arrayValores =  array_reverse($arrayValores);

//
// Pecorre os resultados
//
foreach( $arrayValores as $valores )
{
	//
	// Dá uma enfase
	//
	if( $valores['mascara'] == $filhoGet ) 
		$valores['valor']= "<strong>".$valores['valor']."</strong>";
	
	echo '<div>';
	echo str_pad('', strlen($valores['mascara'])-2, '-').' '.trim($valores['valor']);
	echo '</div>';
}
