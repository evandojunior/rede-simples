	function showConfig(){
		appt = document.applets['oApplet'];
		appt.showConfiguration();
	}
    
	function generateResponse(){
	    try {
			appt = document.applets['oApplet'];
			var frm = document.forms["challengeForm"];
			frm.response.value = appt.getResponse();
			frm.cert.value = appt.getUserCertificate();
			
//			document.getElementById('resultado').innerHTML = appt.getResponse();
                  if(frm.response.value == "" || frm.cert.value == ""){
                     return false; 
                  }
				  
	    }
	    catch(err) {
	        alert("Erro: "+err);
	        return false;
	    }
		return true;
	}

  // Habilita e desabilita dos botões

  function enableButtons(flag) {
     document.challengeForm.sign.disabled  = !flag;
     document.challengeForm.config.disabled  = !flag;
  }

 // Verifica se a applet foi iniciada ou não.

  var started = false;
  function checkAppletStarted() {
    if (document.applets['oApplet']) {
	  try{
        started = document.applets['oApplet'].isStarted();
	  }catch (err) {}
	}
    if (!started)
      window.setTimeout("checkAppletStarted()", 1000);
	else
      enableButtons(true);
  }
