<?php
if(! isset($_SESSION) ) session_start();

//-- Variaveis publicas
$thisPath	= strtolower(__FILE__);
$thisPath	= str_replace('\\','/', $thisPath);
$thisPath	= explode('web', $thisPath);
$thisPath	= (string) array_shift($thisPath);
$thisPath	= rtrim( $thisPath, '/') .'/';
$thisPath	= $thisPath.'database/servicos/bbpass/tema/';
$pathTheme	= $thisPath.'temas/';
$pathTmp	= $thisPath.'tmp/';

ini_set('display_errors', true);

//-- Verifica se no existe a pasta temas
if(! file_exists( $pathTheme ) )
	mkdir( $pathTheme, 0777, true );	

//-- Verifica se no existe a pasta temas
if(! file_exists( $pathTmp ) )
	mkdir( $pathTmp, 0777, true );	

//-- D permisso de escrita
@chmod( $pathTheme, 0777 );
@chmod( $pathTmp, 0777 );

include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/temas/functions.php");

if( isset($_FILES['tema']) && isset($_POST) )
{
	//-- Altera o nome do tema
	$file_uploaded = preg_replace('/[^a-zA-Z0-9_\.]/', '_', $_FILES['tema']['name']);	
	
	//-- Salva na pasta temas
	move_uploaded_file($_FILES['tema']['tmp_name'], $pathTheme.$file_uploaded);
	
	//-- Cria um Arquivo TXT contendo algumas informações
	$fileTXT = fopen($pathTheme.str_replace('.zip', '.txt', $file_uploaded), 'w');
	
	//-- Peço pata listar todo o conteudo do arquivo
	//$lista_arquivos = lista_zip( $pathTheme.$file_uploaded );
	
	//-- Guarda informações sobre o arquivo
	
	$fileData				= array();
	$fileData['name']		= $_FILES['tema']['name'];
	$fileData['size']		= $_FILES['tema']['size'];
	$fileData['date']		= date('d/m/Y');
	$fileData['hierarquia'] = string2tree($lista_arquivos);
	$fileData['hierarquia'] = array();
	
	//-- Deleta o conteudo da pasta novamente
	deleteTree( $pathTmp, false );
	
	//-- Debug
	//print_r($fileData['hierarquia']);
	
	//-- Escreve  no arquivo
	fwrite($fileTXT, serialize($fileData));
	
	//-- Fecha o arquivo
	fclose($fileTXT);
	
	//-- Oculta
	header('location: ../index.php?'. time() );
}


include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
?>
<?php require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Cadastro  de temas</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
   	<form action="<?php echo getCurrentPage(); ?>" method="post" enctype="multipart/form-data" name="form1" id="form1">
        <table width="366" border="0" align="center">
          <tr>
            <td width="621"><input type="file" name="tema" id="tema" /></td>
          </tr>
          <tr>
            <td align="right">
            <input name="cadastrar" onclick="voltarURL('/e-solution/servicos/bbpass/temas/index.php');" type="button" class="botaoVoltar back_input" id="cadastrar" value="&nbsp;&nbsp;&nbsp;Cancelar"/>
            <input type="button" class="botaoAvancar back_input" name="button" id="button" value="Enviar" onclick="var tema = document.getElementById('tema').value.split('.');if( tema[tema.length-1] != 'zip'){ alert('Apensa arquivos ZIP poder&atilde;o ser enviados'); }else{ document.getElementById('form1').submit(); }" />
            </td>
          </tr>
        </table>
   	</form>
    </td>
  </tr>
</table>

<?php 
/*===============================INICIO AUDITORIA POLICY=========================================*/
$_SESSION['relevancia']="0";
$_SESSION['nivel']="2";
$Evento="Acessou a página de gerenciamento de temas.";
EnviaPolicy($Evento);
/*===============================FIM AUDITORIA POLICY============================================*/
?>