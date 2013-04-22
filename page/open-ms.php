<?php
$dao = new TodoDao();
$db = $dao->getDb();

if (isset($_GET['tid'])) {
	$pid = $_SESSION['ms'];
	$tid = $_GET['tid'];

	$sql = "UPDATE task SET completedOn = NULL WHERE tid = '$tid' AND pid= '$pid'";
	$db->query($sql) or die("Error deleting");

	Flash::addFlash('Milestone opened successfully.');
	Utils::redirect('detail', array('id' => $pid));

}
?>