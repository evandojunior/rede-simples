 <form name="formUpload" id="formUpload" action="/corporativo/servicos/bbhive/perfil/upload.php" method="post" enctype="multipart/form-data" target="upload_target"> 
<table width="420px" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
      <tr>
        <td width="100%" height="25" colspan="2" background="/corporativo/servicos/bbhive/images/back_top.gif" style="border-left:#FBC203 solid 1px; border-right:#FBC203 solid 1px;"><span class="verdana_12">&nbsp;&nbsp;<img src="/corporativo/servicos/bbhive/images/icon_05.gif" width="15" height="12" />&nbsp;&nbsp;&nbsp;Escolha a imagem</span>
        <div style="float:right; margin-right:5px;"><a href="#" onClick="javascript: document.getElementById('upload').innerHTML='&nbsp;'"><img src="/corporativo/servicos/bbhive/images/exc.gif" border="0" /></a></div>
        </td>
      </tr>
      <tr>
        <td height="120" colspan="2" valign="top" style="border-left:#FBC203 solid 1px; border-right:#FBC203 solid 1px; border-bottom:#FBC203 solid 1px"><p id="f1_upload_process">Carregando...<br/><img src="/corporativo/servicos/bbhive/images/loader.gif" /><br/>
           <p id="f1_upload_form" align="center"><br/>
         <label class="verdana_11">Arquivo:  
              <input name="arquivo" type="file" size="30" />
         </label>
         <label>
             <input type="button" name="submitBtn" class="sbtn" value="Enviar" onClick="return UploadFoto();" />
         </label>
         <br />
         <div class="verdana_11" style="color:#666666">
         	A imagem deve ser exatamante: 128px de altura e 125px de largura!
         </div>
        </td>
      </tr>
      <tr>
        <td colspan="2"><iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff; display:none"></iframe></td>
      </tr>
    </table>
</form>