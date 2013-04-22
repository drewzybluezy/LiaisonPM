<?php
$dao = new TodoDao();
$db = $dao->getDb();

if (isset($_GET['tid'])) {
	$pid = $_SESSION['ms'];
	$tid = $_GET['tid'];
	$sql = "DELETE FROM task WHERE tid = '$tid' AND pid = '$pid'";
	$db->query($sql) or die("Error deleting");

	$sql = "DELETE FROM onTask WHERE tid = '$tid' AND pid = '$pid'";
	$db->query($sql) or die("Error deleting");
}

Flash::addFlash('Milestone '.$_GET['tid'].' deleted successfully.');
Utils::redirect('detail', array('id' => $pid));

?>
