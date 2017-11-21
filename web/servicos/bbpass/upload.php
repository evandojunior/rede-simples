<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Uploadify scriptData Sample</title>

<link rel="stylesheet" href="includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/uploadify/uploadify.css" type="text/css" />

<script type="text/javascript" src="includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/jquery.uploadify (Source).js"></script>

<script type="text/javascript">

$(document).ready(function() {
	$("#fileUpload").fileUpload({
		'uploader': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/uploader.swf',
		'cancelImg': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/cancel.png',
		'script': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/upload.php',
		'folder': '1',
		'multi': false,
		'displayData': 'speed'
	});

	$("#fileUpload2").fileUpload({
		'uploader': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/uploader.swf',
		'cancelImg': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/cancel.png',
		'script': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/upload.php',
		'folder': 'files',
		'multi': true,
		'buttonText': 'Select Files',
		'checkScript': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/check.php',
		'displayData': 'speed',
		'simUploadLimit': 2
	});

	$("#fileUpload3").fileUpload({
		'uploader': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/uploader.swf',
		'cancelImg': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/cancel.png',
		'script': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/upload.php',
		'folder': 'files',
		'fileDesc': 'Image Files',
		'fileExt': '*.jpg;*.jpeg;*.gif;*.png',
		'multi': true,
		'checkScript': 'includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/check.php',
		'auto': true
	});
});

</script>
</head>

<body>
      <fieldset style="border: 1px solid #CDCDCD; padding: 8px; padding-bottom:0px; margin: 8px 0">
		<legend>Trocar foto</legend>
		<div id="fileUpload3">Problemas com javascript</div>
        <label style="display:none">
		<a href="javascript:$('#fileUpload3').fileUploadStart()">Start Upload</a> |  <a href="javascript:$('#fileUpload3').fileUploadClearQueue()">Clear Queue</a></label>
        <form name="form1" enctype="multipart/form-data" method="post" action="/servicos/bbpass/includes/javascript_backsite/tratamento/jquery.uploadify-v1.6.2/upload.php">
          <label>
            <input type="file" name="Filedata" id="Filedata">
          </label>
          <label>
            <input type="submit" name="button" id="button" value="Submit">
          </label>
        </form>
      </fieldset>
</body>
</html>