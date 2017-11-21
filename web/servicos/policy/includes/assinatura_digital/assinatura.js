  function encodeDocuments(){
     appt = document.applets[0];alert(appt)
     appt.setSignDocument(true);
          appt.setEncryptDocument(true);
     appt.signAndSendMarkedDocuments();
  }

  function showConfig(){
     appt = document.applets[0];
     appt.showConfiguration();
  }

  function markDocument(index, checked){
     appt = document.applets[0];
	
     if(checked=="checked") {
        appt.markDocument(index);
     }
     else {
        appt.unmarkDocument(index);
     }
  }

  function viewDocument(){
     var index = getFirstIndex();
     if(index >=0) {
       appt = document.applets[0];
       appt.showDocument(index);
     }
  }

  function getFirstIndex(){
     var len = document.form1.fileIndex.length;
     for(i=0;i<len;i++){
        if(document.form1.fileIndex[i].checked == true) {
            return i;
        }
     }
     alert("Marque um documento a ser visualizado!");
     return -1;
  }
