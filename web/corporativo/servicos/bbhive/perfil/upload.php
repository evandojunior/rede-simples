<?php
if(!isset($_SESSION)){ session_start(); }

// início
$erro = $config = array();

// Prepara a variável do arquivo
$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;

// Tamanho máximo do arquivo (em bytes)
$config["tamanho"] = 81920;
// Largura máxima (pixels)
//$config["largura"] = 640;
$config["largura"] = 125;
// Altura máxima (pixels)
//$config["altura"]  = 480;
$config["altura"]  = 128;

// Formulário postado... executa as ações
if($arquivo){
$err[]="";
    // Verifica se o mime-type do arquivo é de imagem
    if(!eregi("^image\/(pjpeg|jpeg)$", $arquivo["type"])){
        $erro[] = ("Arquivo em formato inv&alido! A imagem deve ser jpg. Envie outro arquivo");
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = ("Arquivo em tamanho muito grande! Tamanho máximo " . $config["tamanho"] . " bytes.
		Envie outro arquivo");
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);

        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $erro[] = ("Largura da imagem deve ser no máximo " . $config["largura"] . " pixels!");
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $erro[] = ("Altura da imagem deve ser no máximo " . $config["altura"] . " pixels!");
        }
    }
    
    // Imprime as mensagens de erro
    if(sizeof($erro)){
        foreach($erro as $err){
            echo "<br> - " . $err . "<BR>";
        }
	?>	
	<script type="text/javascript">
	  window.top.window.alerta("<?php echo $err; ?>");
	</script>    
    <?php
		exit;
    }

    // Verificação de dados OK, nenhum erro ocorrido, executa então o upload...
    else  {
        // Pega extensão do arquivo
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        // Gera um nome único para a imagem
		$materia =  $_SESSION['usuCod'];
		
		$imagem_nome = $materia . "." . $ext[1];

        // Caminho de onde a imagem ficará
		$codigo_usuario = $_SESSION['usuCod'];
		//verifico se existe diretório
		$diretorio = "../../../../datafiles/servicos/bbhive/corporativo/perfis/".$codigo_usuario;
		if(!file_exists($diretorio)) {	
			mkdir($diretorio, 777);
			chmod($diretorio,0777);
		}
		
		if(!file_exists($diretorio."/images")) {	
			mkdir($diretorio."/images", 777);
			chmod($diretorio."/images",0777);
		}

        $imagem_dir = $diretorio ."/images/". strtolower($imagem_nome);
		
        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        
		//limpa a imagem miniatura
		if(file_exists($diretorio."/".$codigo_usuario."_mini.jpg")) {
			unlink($diretorio."/".$codigo_usuario."_mini.jpg");
		}
    }
}
// fim
?>
<script>
	window.top.window.atualizaFoto();
</script>