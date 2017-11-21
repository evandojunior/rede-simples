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
@chmod( $thisPath, 0777 );
@chmod( $pathTheme, 0777 );
@chmod( $pathTmp, 0777 );

include(__DIR__ . "/../../../../../database/globalConfig.php");
include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/temas/functions.php");

//-- Deleta um tema da pasta de temas
if( isset($_GET['action']) && $_GET['action'] == 'deletar' && isset($_GET['deletarTema']) )
{
	//-- Deleta o ZIP
	@unlink($pathTheme. str_replace('.txt','.zip',$_GET['deletarTema']) );
	
	//-- Deleta o TXT
	@unlink($pathTheme.$_GET['deletarTema']);
		
	//-- Oculta
	header('location: ../index.php');

}


//-- Aplica um tema da pasta de temas
if( isset($_GET['action']) && $_GET['action'] == 'aplicar' && isset($_GET['aplicarTema']) )
{
	//-- Salva algumas informaçoes enviadas pelo usuário
	$local = rtrim(str_replace('\\','/', strtolower(array_shift(explode('web',__FILE__))) ), '/') .'/';
	$thema = str_replace('.txt','.zip', strip_tags($_GET['aplicarTema']));
	
	//-- Verifica se o arquivo de tema existe
	if( file_exists($pathTheme.$thema) )
	{
        //-- Extrai a pasta para o tmp
        $zip = new ZipArchive();

        //-- Abre o arquivo
        $zip->open($pathTheme . $thema);

        $entries = array();
        for ($idx = 0; $idx < $zip->numFiles; $idx++) {
            $fileReference = $zip->getNameIndex($idx);

            // ignora tudo que não estiver no datafiles :D
            if (strpos($fileReference, "datafiles") === false) {
                continue;
            }

            $entries[] = $fileReference;
        }

        //-- Extrai arquivos para destino
        $zip->extractTo($global->project->rootPath, $entries);

        $res = shell_exec("chmod 775 -Rf " . $global->project->rootPath . "/web/datafiles");

		//-- Mostra a mensagem
		$mensagem = array('tipo'=>'aviso', 'msg'=>'O tema foi aplicado com sucesso!');
	}
	
	//-- Oculta
	header('location: ../index.php?'. time() );

}

include($_SESSION['caminhoFisico']."/e-solution/servicos/bbpass/perfil/index.php"); 
?>
<?php require_once("../perfil/index.php"); ?>
<table width="765" border="0" align="left" cellpadding="0" cellspacing="0" style="margin-top:5px;margin-bottom:10px;">
  <tr>
    <td width="4" height="37" align="left" background="/e-solution/servicos/bbpass/images/canto_esquerdo.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
    <td width="758" align="left" bgcolor="#F2E6B5" class="fonteDestaque" style="color:#3078B6"><strong>Gerenciamento de temas</strong></td>
    <td width="4" align="left" background="/e-solution/servicos/bbpass/images/canto_direito.gif" bgcolor="#F2E6B5" class="legendaLabel14">&nbsp;</td>
  </tr>
  <tr>
    <td height="410" colspan="3" align="left" valign="top" bgcolor="#FFFFFF" class="legendaLabel14" style="border-left:#DCDFE1 solid 1px;border-right:#DCDFE1 solid 1px;border-bottom:#DCDFE1 solid 1px;">
        <table width="764" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="258" height="25" class="fundoTitulo  legendaLabel12"><strong>&nbsp;Nome do tema</strong></td>
            <td width="277" class="fundoTitulo legendaLabel12">&nbsp;</td>
            <td width="149" class="fundoTitulo  legendaLabel12">&nbsp;</td>
            <td colspan="4" align="center" class="fundoTitulo legendaLabel11">
            <a href="#" title="Clique para enviar" rev="/e-solution/servicos/bbpass/temas/enviar.php" onclick="enviaURL(this);">
            <img src="/e-solution/servicos/bbpass/images/btn_novo.gif" width="16" height="16" border="0" align="absbottom">&nbsp;Novo
            </a>
            </td>
          </tr>
          <tr>
            <td height="5" colspan="7"></td>
          </tr>
        <?PHP
		$temas_files = glob($pathTheme.'*.txt');
		foreach($temas_files as $temas)
		{
			$fileDataSelect = unserialize( file_get_contents($temas) );
		?>
        <tr>
            <td width="684" colspan='3' height="25" class="legendaLabel11" style="border-bottom:#EEEEEE solid 1px;">
            &nbsp;<strong>
			<a href=" /e-solution/servicos/bbpass/temas/download.php?arquivo=<?PHP echo $fileDataSelect['name']; ?>" title="Baixar o arquivo: <?PHP echo $fileDataSelect['name']; ?>"><?PHP echo $fileDataSelect['name']; ?>
            </a>
            </strong>
            </td>
            <td colspan="4" class="legendaLabel11" align="center" style="border-bottom:#EEEEEE solid 1px;">
            <a href='<?PHP echo getCurrentPage(); ?>?action=deletar&deletarTema=<?PHP echo basename($temas); ?>' title='Excluir tema' onclick='if(!confirm("Deseja deletar este tema?\n\nEste processo não pode ser cancelado!")){ return false; }'>
			<img src='/e-solution/servicos/bbpass/images/btn_excluir.gif' border="0" />
            </a>
            &nbsp;
            <a href='<?PHP echo getCurrentPage(); ?>?action=aplicar&aplicarTema=<?PHP echo basename($temas); ?>' title='Aplicar tema' onclick='if(!confirm("Deseja aplicar este tema?\n\nEste processo não pode ser cancelado!")){ return false; }'>
            <img src='/e-solution/servicos/bbpass/images/cad_apl.gif' border="0" />
            </a>
            </td>
        </tr>
        <?PHP
		}
		//-- Caso não se enha nenhum tema
		if( !isset($temas_files[0]) ){
		?>
        <tr>
            <td colspan="7" class="legendaLabel11">
            Nenhum arquivo de tema encontrado!
            </td>
        </tr>
        <?PHP
		}
		?>
        </table>
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