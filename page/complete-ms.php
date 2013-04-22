<?php
$dao = new TodoDao();
$db = $dao->getDb();

if (isset($_GET['tid'])) {
	$pid = $_SESSION['ms'];
	$tid = $_GET['tid'];
	$finished = $_POST['dp'];

	$sql = "UPDATE task SET completedOn = '$finished' WHERE tid = '$tid' AND pid='$pid'";
	$db->query($sql) or die("Error deleting");

	Flash::addFlash('Milestone completed successfully.');
	Utils::redirect('detail', array('id' => $pid));

}
?>
