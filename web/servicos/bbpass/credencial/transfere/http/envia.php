<?php

function transfereLogon($urlAplicacao){
    //prepara variáveis
    $email = $_SESSION['MM_BBpass_Email'];
    $chave = session_id();
    $string= "email=".$email."|chave=".$chave."|&".time()."0";
    //tratamento de envio HTTP
    $compl = substr($urlAplicacao, (strlen($urlAplicacao)-1),1) == "/" ? "" : "/";

    $url= $urlAplicacao.$compl."includes/bbpass/tranfere.php?".base64_encode(base64_encode($string));

    $arguments = base64_encode("chave") . "=" . base64_encode(session_id());
    $arguments.= base64_encode("email") . "=" . base64_encode($_SESSION['MM_BBpass_Email']);

    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_POST, 1);
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $arguments);
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt( $ch, CURLOPT_HEADER, 0);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec( $ch );
    if($errno = curl_errno($ch)) {
        $error_message = curl_strerror($errno);
        echo "cURL error ({$errno}):\n {$error_message} => " . $_SESSION['EndURL_POLICY'];
    }

    return $response . "_bbpass_vld_" . base64_encode(base64_encode($response));
}