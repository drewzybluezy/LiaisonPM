<?php
if(isset($_POST['remove-alert'])) {

	$title = $_POST["remove-alert"];

	$dao = new TodoDao();
	$db = $dao->getDb();

	$sql="DELETE FROM alert WHERE title = '$title'";

	$db->query($sql) or die('Error: ' . mysql_error());
	$dao->__destruct();
	Flash::addFlash($title.' Removed');
	Utils::redirect('home', array(null));
}
?>
