<?php
 if(!isset($_SESSION)){ session_start(); } 
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/servicos/bbhive/includes/functions.php");

$localizacao_documento =  explode("web",$_SESSION['caminhoFisico']);
$path = $localizacao_documento[0];

if(isset($_POST['bbh_pro_arquivo'])){
	//monta url
	$nome_arquivo 	= $_POST['bbh_pro_arquivo'];
	$origem 		= $path. "database/servicos/bbhive/protocolo/protocolo_".$_POST['bbh_pro_codigo']."/".$nome_arquivo;
	
	@unlink($origem); 
	
		/*===============================INICIO AUDITORIA POLICY=========================================*/
		$_SESSION['relevancia']="0";
		$_SESSION['nivel']="1";
		$Evento="Removeu um documento com o nome (".$nome_arquivo.") do protocolo (".$_POST['bbh_pro_codigo'].")  - BBHive público.";
		EnviaPolicy($Evento);
		/*===============================FIM AUDITORIA POLICY============================================*/
	?>
    <script type="text/javascript">
		window.top.window.document.removeArquivo.reset();
		window.top.window.LoadSimultaneo('protocolos/cadastro/passo2.php?confirmaDigitalizacao=true','conteudoGeral');
	</script>	
<?php }?>