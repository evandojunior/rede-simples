<applet code="com.griaule.fingerprintsdk.appletsample.FormPrincipal"
    archive="<?php echo $ondeJar; ?>BiometriaSDK_Servicos.jar,<?php echo $ondeJar; ?>SignedFingerprintSDKJava.jar"
    width="385" height="120">
    <param name="urlEnvio" value="<?php echo $endJSPBio; ?>/autentica.jsp">
</applet>