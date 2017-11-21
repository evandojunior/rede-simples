<?php
//Inicia sessão caso não esteja criada
if(!isset($_SESSION)){session_start();}
include($_SESSION['caminhoFisico']."/Connections/bbpass.php");
include($_SESSION['caminhoFisico']."/servicos/bbpass/includes/function.php");
require_once("gerencia_perfil.php");

 $usuario = new perfil();//instância classe
?><table style="height:103px; width:79px; border:1px groove #CCCCCC; margin-top:10px;">
   <tr>
        <td>
          <a href="#">
            <img id='foto' src='<?php echo $usuario->verificaImagem($database_bbpass, $bbpass); ?>' border='0' align='absmiddle' style='margin-top:2px;' />
          </a>                
        </td>
  </tr>
</table>
<div class="legendaLabel11" align="left" style="margin-left:25px; margin-top:5px;position:absolute">
  <div style="width:130px;">
    <div id="fileUpload3">Problemas com javascript</div>
    <label style="display:none">
    <a href="javascript:$('#fileUpload3').fileUploadStart()">Start Upload</a> |  <a href="javascript:$('#fileUpload3').fileUploadClearQueue()">Clear Queue</a></label>
   </div> 
</div>