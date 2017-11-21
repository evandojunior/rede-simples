<?php
if(!isset($_SESSION)){ session_start(); }
unset($_SESSION['bbh_flu_codigo']);
unset($_SESSION['bbh_arq_autor']);
unset($_SESSION['bbh_arq_compartilhado']);

unset($_SESSION['MM_insert']);
unset($_SESSION['MM_update']);
unset($_SESSION['MM_delete']);

	//Redireciona de volta
	header("Location: ../../index.php?a=1");
exit;
?>

<script language="javascript">
//window.top.location.href='/corporativo/servicos/bbhive/index.php';
window.top.window.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&arquivos=1|arquivos/index.php?<?php if(isset($_POST['bbh_flu_codigo_sel'])){ echo "bbh_flu_codigo=".$_POST['bbh_flu_codigo_sel']; } if(isset($_POST['bbh_ati_codigo'])){echo "&bbh_ati_codigo=".$_POST['bbh_ati_codigo']; } ?>|includes/colunaDireita.php?fluxosDireita=1&arquivos=1&equipeArquivos=1','menuEsquerda|colCentro|colDireita');
</script>