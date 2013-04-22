<?php

if (isset($_SESSION['ms'])) {
	if(isset($_POST['save'])) {

		$title = $_POST['milestone'];
		$start = $_POST['start'];	
		$end = $_POST['end'];
		$assignTo = $_POST['assignTo'];
		$pid = $_SESSION['ms'];

		if(!$title) {
			$errors[] = new Error('milestone','Milestone name cannot be empty');
		}
		else if(!isset($_POST['assignTo'])) {
			$errors[] = new Error('assignTo','Minimum number of assigned employees is 1');
		}
		else {
			$dao = new TodoDao();
			$db = $dao->getDb();
			if(isset($_GET['tid'])) {
				$tid = $_GET['tid'];
				$sql = "DELETE FROM task WHERE tid = '$tid'";
				$db->query($sql) or die("error inserting");
			
				$sql = "DELETE FROM onTask WHERE tid = '$tid'";
				$db->query($sql) or die("error inserting");
			}

			$sql = "INSERT INTO task (title, start, end, pid) VALUES ('$title', '$start', '$end', '$pid')";		
			$db->query($sql) or die("error inserting");

			$sql2 = "SELECT tid FROM task WHERE title = '$title' AND pid = '$pid'";
			$result = $db->query($sql2) or die("error selecting id");
			$row = $result->fetch(PDO::FETCH_ASSOC);
			$tid = $row['tid'];

			if($assignTo) {
   				if(count($assignTo) != 0) {
					$sql3 = "INSERT INTO onTask (tid, pid, eid) VALUES";
					for($i = 0; $i < count($assignTo); $i++) {
						$sql3 = $sql3."('$tid','$pid','$assignTo[$i]')";
						if($i < count($assignTo) - 1) {
							$sql3 = $sql3.',';
						}
					}
					$db->query($sql3) or die("Could not insert employees");
					$dao->__destruct();
   				}
			}
			//display confirmation message
			Flash::addFlash('Milestone added.');
       		 // redirect
        		Utils::redirect('detail', array('id' => $pid));

		}
	}
	else if(isset($_POST['cancel'])) {
		$pid = $_SESSION['ms'];
        	Utils::redirect('detail', array('id' => $pid));
	}
}
?>