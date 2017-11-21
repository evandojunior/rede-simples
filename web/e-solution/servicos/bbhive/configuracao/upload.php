<?php
if(!isset($_SESSION)){session_start();}

include($_SESSION['caminhoFisico']."/Connections/bbhive.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/autentica.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbhive/includes/functions.php");
require_once("../fluxos/modelosFluxos/detalhamento/includes/functions.php");

$dirKey = __DIR__ . "/../../../../../database/keys/";
$uploadfile = sprintf("%s%s", $dirKey, "urbem-cmp.pem");

if (!file_exists($dirKey)) {
    mkdir($dirKey, 0777, true);
}

if (file_exists($uploadfile)) {
    unlink($uploadfile);
}

$message = "Falha ao enviar chave de acesso.";
if (move_uploaded_file($_FILES['securityKey']['tmp_name'], $uploadfile)) {
    $message = "Chave gravada com sucesso!";
    chmod($uploadfile, 0664);
}

header("Location: /e-solution/servicos/bbhive/index.php?message-upload={$message}");