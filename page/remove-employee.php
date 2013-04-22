
<?php
if(isset($_POST['save'])) {
	$name = $_POST['name'];

	$dao = new TodoDao();
	$db = $dao->getDb();
	$sql="SELECT * FROM employee WHERE name = '$name'";
	$result = $db->query($sql) or die('Error: Getting id failed');
	$row = $result->fetch(PDO::FETCH_ASSOC);
	$id = $row['id'];

	$sql="DELETE FROM worksOn WHERE eid = '$id'";
	$result = $db->query($sql) or die('Error: SQL Query Failed: '.$name.' could not be removed from worksOn.'.' ID: '.$id.'');

	$sql="DELETE FROM employee WHERE name = '$name'";
 
	$result = $db->query($sql) or die('Error: SQL Query Failed: '.$name.' could not be removed.');
	Flash::addFlash('Employee Removed');
	$dao->__destruct();
	Utils::redirect('home', array(null));
}
?>
