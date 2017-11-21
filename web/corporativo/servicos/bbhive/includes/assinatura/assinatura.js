 function decodeDocuments(){
     appt = document.applets[0];
     appt.decodeMarkedDocuments();
  }



  function showConfig(){
     appt = document.applets[0];
     appt.showConfiguration();
  }

  function markDocument(index, checked){
     appt = document.applets[0];

     if(checked) {
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
       appt.viewDocument(index);
     }
  }

  function showDocumentStatus(){
     var index = getFirstIndex();
     if(index >=0) {
        var status = appt.getEnvelopeStatus(index);
        if(status == appt.OK_CODE) {
            alert("Documento Verificado com Sucesso!");
        }
        else if(status == appt.ERROR_CODE) {
           alert(appt.getEnvelopeMessageError(index));
        }
     }
  }

  function showSignatures() {
     appt = document.applets[0];
     var index = getFirstIndex();
	 
     if(index >=0) {
       appt = document.applets[0];
       appt.viewSignatures(index);
     }

  }



  function getFirstIndex(){
     var len = document.form1.length;

    // for(i=0; i<len; i++){
        if(document.getElementById('fileIndex').checked == true) {
            return 0;
     // }
     }
     alert("Marque um documento a ser visualizado!");
     return -1;
  }