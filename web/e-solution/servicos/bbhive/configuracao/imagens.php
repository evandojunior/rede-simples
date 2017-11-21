<?php
if(isset($_GET['adm'])){
	echo '<img src="/datafiles/servicos/bbhive/e-solution/imagens/sistema/'.$_GET['image'].'" border="0" align="absmiddle" />';
} elseif(isset($_GET['corp'])){
	echo '<img src="/datafiles/servicos/bbhive/corporativo/images/sistema/'.$_GET['image'].'" border="0" align="absmiddle" />';
} elseif(isset($_GET['publ'])) {
	echo '<img src="/datafiles/servicos/bbhive/servicos/imagens/sistema/'.$_GET['image'].'" border="0" align="absmiddle" />';
} elseif(isset($_GET['logo'])){
	echo '<img src="/datafiles/servicos/bbhive/images/logo/'.$_GET['image'].'" border="0" align="absmiddle" />';
}
?>