<?php
////-- funÃ§Ãµes -- \\
function arrumadata($data_errada)
 {return implode(preg_match("~\/~", $data_errada) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data_errada) == 0 ? "-" : "/", $data_errada)));
}

function Real($valor){  
	$valorretorno=number_format($valor, 2, ',', '.');  
	return $valorretorno;  
}
//---\\

?>