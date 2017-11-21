<?php if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");

$ondeJava = "http://".$_SERVER['HTTP_HOST'].str_replace("formulario.php","",getCurrentPage());
$endJSPBio= $endJSPBio;//variável esta no setup.php -> connections
?>
<script type="text/javascript">
function validadoComSucesso(param)
{
	alert("Usuário cadastrado com sucesso");
	history.back(-1);
}

function erro(param)
{
	alert("Houve uma falha ao se cadastrar o usuário. " + param);
	history.back(-1);
}
</script>
<applet code="com.griaule.fingerprintsdk.appletsample.FormPrincipal" archive="<?php //echo $ondeJava; ?>BiometriaSDK_eSolution.jar,<?php //echo $ondeJava; ?>SignedFingerprintSDKJava.jar" width="650" height="240" style="margin-top:10px;">
    <param name="total" value="1">
    <param name="campo0" value="<?php echo $_GET['bbp_adm_loc_codigo']; ?>">
    <param name="urlEnvio" value="<?php echo $endJSPBio; ?>/cadastra.jsp">
</applet>