<?php
 if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/corporativo/servicos/bbhive/includes/functions.php");

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

if(isset($_POST['bbh_pro_arquivo'])){
	//monta url
	$nome_arquivo 	= $_POST['bbh_pro_arquivo'];
	$origem 		= $path. "database/servicos/bbhive/protocolo/protocolo_".$_POST['bbh_pro_codigo']."/".$nome_arquivo;
	
	unlink($origem); ?>
    <script type="text/javascript">
		window.top.window.removeArquivo.reset();
		window.top.window.showHome('includes/home.php','conteudoGeral', 'perfil/index.php?perfil=1&perfis=1|protocolo/regra.php?bbh_pro_codigo=<?php echo $_POST['bbh_pro_codigo']; ?>','menuEsquerda|conteudoGeral');
	</script>	
<?php }?>