<?php
// define a imagem a partir da qual será gerada a minuatura
//$imagem = "imagem_original.jpg";
$imagem = "../../../datafiles/servicos/bbhive/corporativo/perfis/1/images/1.jpg";

// **** configurações da miniatura *******
$tamanho_fixo 	= "N";    // S ou N
$largura_fixa 	= 192;    // usado somente com tamanho_fixo=S
$altura_fixa 	= 144;    // usado somente com tamanho_fixo=S
$percentual 	= 40;      // usado somente com tamanho_fixo=N
// **************************************

if(!file_exists($imagem))
{
    echo "Arquivo da imagem não encontrado!";
    exit;
}
if($tamanho_fixo=="N" && ($percentual<1 || $percentual>100))
{
    echo "O percentual deve ser um número entre 1 e 100!";
    exit;
}

// monta o nome do arquivo resultante
$arquivo_miniatura = explode('.', $imagem);
$arquivo_miniatura = $arquivo_miniatura[0]."_mini.jpg";

// lê a imagem de origem e obtém suas dimensões
$img_origem = ImageCreateFromJPEG($imagem);
$origem_x = ImagesX($img_origem);
$origem_y = ImagesY($img_origem);

// se não for tamanho fixo, calcula as dimensões da miniatura
if($tamanho_fixo=="S"){
    $x = $largura_fixa;
    $y = $altura_fixa;
}else{
    $x = intval ($origem_x * $percentual/100);
    $y = intval ($origem_y * $percentual/100);
}

// cria a imagem final, que irá conter a miniatura
$img_final = ImageCreateTrueColor($x,$y);

// copia a imagem original redimensionada para dentro da imagem final
ImageCopyResampled($img_final, $img_origem, 0, 0, 0, 0, $x+1, $y+1, $origem_x , $origem_y);

// salva o arquivo
ImageJPEG($img_final, $arquivo_miniatura);

// libera a memória alocada para as duas imagens
ImageDestroy($img_origem);
ImageDestroy($img_final);
?>

<html>
<head>
<title>Miniatura</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body>
<p align="center">
<img src="<?php echo $imagem; ?>">
&nbsp;&nbsp;&nbsp;&nbsp;
<img src="<?php echo $arquivo_miniatura; ?>">
</p>
<p align="center">
<b>Imagem original</b>: <?php echo $imagem." (".$origem_x." x ".$origem_y.")";?><br>
<b>Miniatura gerada</b>: <?php echo $arquivo_miniatura." (".$x." x ".$y.")";?>
</p>
</body>
</html>