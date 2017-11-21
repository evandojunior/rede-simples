// JavaScript Document
function tecla(event, nmForm, campo){
   var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
   if (keyCode == 13) {
		eval("document."+nmForm+".submit()");
		return false;
  	}
}