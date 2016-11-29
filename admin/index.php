K<!DOCTYPE html>
<html>
<head>
	<title>Form</title>
</head>
<body>
<?php  if (isset($_GET['ok'])):?>
    <h2>Congratulations!!! Partner added!</h2>
<?php endif; ?>
	<form enctype="multipart/form-data" action="addPartner.php" method="post">
		Name: <input type="text" name="name"><br>
		Description: <input type="text" name="description"><br>
		Image File: <input type="file" name="image"><br>
		<input type="checkbox" name="hidden" value="yes"><br>
		<input type="submit">
	</form>
</body>
</html>