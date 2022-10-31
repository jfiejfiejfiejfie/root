<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>JavaScriptのFileAPIで画像のプレビュー</title>
</head>
<body>
<form>
<input type="file" accept='image/*' onchange="previewImage(this);">
</form>
<p>
Preview:<br>
<img id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
</p>
<script>
</script>
</body>
</html>