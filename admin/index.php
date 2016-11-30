K<!DOCTYPE html>
<html>
<head>
	<title>Form</title>
</head>
<body>
<?php  if (isset($_GET['ok'])):?>
    <h2>Congratulations!!! Partner added!</h2>
<?php endif;?>
	<form enctype="multipart/form-data" action="addPartner.php" method="post">
        <label for="name">Name: </label>
        <input required id="name" type="text" name="name"><br>
        <label for="description">Description: </label>
        <input required id="description" type="text" name="description"><br>
        <label for="image">Image File: </label>
		<input required id="image" type="file" name="image"><br>
        <label for="hidden">Hide?</label>
		<input id="hidden" type="checkbox" name="hidden" value="yes"><br>
		<input type="submit">
	</form>
</body>
</html>