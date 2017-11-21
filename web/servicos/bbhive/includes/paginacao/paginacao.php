<?php
if($pages>1){
	echo '<div align="center" class="legandaLabel11"><br>';
	
	$paginacao  = ($page == 1)       ? '' : ' <a href="#" onclick="paginacao(\'1\', \''.$homeDestino.'\', \''.$exibe.'\')">Primeiro</a> - ';
	$paginacao .= (($page - 1) <= 0) ? '' : ' <a href="#" onclick="paginacao(\''.($page - 1).'\', \''.$homeDestino.'\', \''.$exibe.'\')">&laquo; Anterior</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
	
		for($a=5; $a>0; $a--){
			$paginacao .= (($page - $a) <= 0) ? '' : ' <a href="#" onclick="paginacao(\''.($page - $a).'\', \''.$homeDestino.'\', \''.$exibe.'\')">'.($page - $a).'</a>';
		}
	
	$paginacao .= ' [ '.$page.' ] ';
	
		for($b=1; $b<6; $b++){
			$paginacao .= (($page + $b) > $pages) ? '' : ' <a href="#" onclick="paginacao(\''.($page + $b).'\', \''.$homeDestino.'\', \''.$exibe.'\')">'.($page + $b).'</a>';
		}
	
	$paginacao .= (($page + 1) > $pages) ? '' : '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" onclick="paginacao(\''.($page+1).'\', \''.$homeDestino.'\', \''.$exibe.'\')">Pr&oacute;ximo &raquo;</a> - ';
	$paginacao .= ($page == $pages)      ? '' : ' <a href="#" onclick="paginacao(\''.($pages).'\', \''.$homeDestino.'\', \''.$exibe.'\')">&Uacute;ltimo</a>';
	
	echo $paginacao;
	echo "</div>";
}
?>