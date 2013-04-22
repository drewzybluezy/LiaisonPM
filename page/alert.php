
<?php
	if(isset($_POST['save'])) {
		$title = $_POST['title'];
		$body = $_POST['body'];
		$exDate = $_POST['ex-date'];

		$dao = new TodoDao();
		$db = $dao->getDb();
		if(!$title) {
			$errors[] = new Error('title','Title cannot be empty');
		}
		else if(!$body) {
			$errors[] = new Error('message','Message cannot be empty');
		}

		if (empty($errors)) {
			$sql="INSERT INTO alert (title, body, expires_on) VALUES ('$title', '$body', '$exDate')";
			$db->query($sql) or die('Error: ' . mysql_error());
			$dao->__destruct();
			Flash::addFlash('Alert Added');
			Utils::redirect('home', array(null));
		}
	}
?>

