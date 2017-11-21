<form style="padding-top:5px;" action="/e-solution/servicos/policy/filtros/consulta_log.php" name="consulta_evento" id="consulta_evento" method="post" onsubmit="if(document.getElementById('pol_aud_codigo').value==''){alert('Preencha o número por favor.');return false;}">
 <label class="verdana_11" style="margin-left:120px;">C&oacute;digo : 
   <input name="pol_aud_codigo" type="text" class="formulario2" id="pol_aud_codigo" onkeyup="SomenteNumerico(this)" value="" size="28" maxlength="25" />
 </label>
 <input name="consulta" type="submit" value="Consultar Evento" class="back_input" style="cursor:pointer"  >
  <input name="url" id="url" type="hidden" value="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo $_SERVER['QUERY_STRING']; ?>" >
</form>
<label style="color:#FF0000" class="verdana_12">
<?php if(isset($_GET['msg'])){ echo '<script type="text/javascript">
alert("Mensagem de registro não encontrado ou rotacionado. Procure um administrador do sistema.");
</script>
<label>Código não encontrado</label>'; }?>
</label>


