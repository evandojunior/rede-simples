<?php
if($pages>1){
	echo '<div align="center" class="legandaLabel11"><br>';
	
	$paginacao  = ($page == 1)       ? '' : ' <a href="'.$homeDestino.'&page=1">Primeiro</a> - ';
	$paginacao .= (($page - 1) <= 0) ? '' : ' <a href="'.$homeDestino.'&page='.($page - 1).'">&laquo; Anterior</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
	
		for($a=5; $a>0; $a--){
			$paginacao .= (($page - $a) <= 0) ? '' : ' <a href="'.$homeDestino.'&page='.($page - $a).'">'.($page - $a).'</a>';
		}
	
	$paginacao .= ' [ '.$page.' ] ';
	
		for($b=1; $b<6; $b++){
			$paginacao .= (($page + $b) > $pages) ? '' : ' <a href="'.$homeDestino.'&page='.($page + $b).'">'.($page + $b).'</a>';
		}
	
	$paginacao .= (($page + 1) > $pages) ? '' : '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="'.$homeDestino.'&page='.($page + 1).'">Pr&oacute;ximo &raquo;</a> - ';
	$paginacao .= ($page == $pages)      ? '' : ' <a href="'.$homeDestino.'&page='.($pages).'">&Uacute;ltimo</a>';
	
	echo $paginacao;
	echo "</div>";
}
?>