<?php

function EnviaPolicy($pol_aud_acao){
    $url= $_SESSION['EndURL_POLICY']."/e-solution/servicos/policy/includes/auditoria.php?TimeStamp=".$_SERVER['REQUEST_TIME'];
    $arguments = "pol_aud_acao=" . $pol_aud_acao;
    $arguments.= "&pol_aud_usuario=" . @$_SESSION['MM_Email_Padrao'];
    $arguments.= "&pol_aud_momento=" . date("Y-m-d H:i:s");
    $arguments.= "&pol_aud_ip=" . $_SERVER['REMOTE_ADDR'];
    $arguments.= "&pol_aud_nivel=" . $_SESSION['nivel'];
    $arguments.= "&pol_aud_relevancia=" . $_SESSION['relevancia'];
    $arguments.= "&pol_apl_codigo=" . $_SESSION['IdAplic'];
    $arguments.= "&pol_aud_ip_aplic=0";

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

    print($response);
    return;
}