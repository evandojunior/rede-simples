<?php
if($pages>1){
	echo '<div align="center" class="legandaLabel11"><br>';
	
	$paginacao  = ($page == 1)       ? '' : ' <a href="#" rev="'.$homeDestino.'&page=1" onclick="enviaURL(this);">Primeiro</a> - ';
	$paginacao .= (($page - 1) <= 0) ? '' : ' <a href="#" rev="'.$homeDestino.'&page='.($page - 1).'" onclick="enviaURL(this);">&laquo; Anterior</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
	
		for($a=5; $a>0; $a--){
			$paginacao .= (($page - $a) <= 0) ? '' : ' <a href="#" rev="'.$homeDestino.'&page='.($page - $a).'" onclick="enviaURL(this);">'.($page - $a).'</a>';
		}
	
	$paginacao .= ' [ '.$page.' ] ';
	
		for($b=1; $b<6; $b++){
			$paginacao .= (($page + $b) > $pages) ? '' : ' <a href="#" rev="'.$homeDestino.'&page='.($page + $b).'" onclick="enviaURL(this);">'.($page + $b).'</a>';
		}
	
	$paginacao .= (($page + 1) > $pages) ? '' : '&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#" rev="'.$homeDestino.'&page='.($page + 1).'" onclick="enviaURL(this);">Pr&oacute;ximo &raquo;</a> - ';
	$paginacao .= ($page == $pages)      ? '' : ' <a href="#" rev="'.$homeDestino.'&page='.($pages).'" onclick="enviaURL(this);">&Uacute;ltimo</a>';
	
	echo $paginacao;
	echo "</div>";
}
?>