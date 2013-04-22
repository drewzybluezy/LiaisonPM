
<?php
	if(isset($_POST['save'])) {
 		$name = $_POST['name'];
		if(!$name) {
			$errors[] = new Error('name','Name cannot be Empty');
		}
		else if(strcmp($_POST['isAdmin'],'Yes') == 0) {
			if(!$_POST['uName']) {
				$errors[] = new Error('user name','User Name cannot be Empty');
			}
			else if(!$_POST['pWord']) {
				$errors[] = new Error('password','Password cannot be Empty');
			}
		}
		
		if(empty($errors)) {
 			$dao = new TodoDao();
 			$db = $dao->getDb();
 			if(strcmp($_POST['isAdmin'],'Yes') == 0) {
				$uName = $_POST['uName'];
				$pWord = $_POST['pWord'];
				$perm = $_POST['perm'];
				$sql="INSERT INTO user (displayName, userName, password, permission) VALUES('$name','$uName','$pWord', '$perm')";
				$result = $db->query($sql);
				if(!$result) {
					$errors[] = new Error('user',"User $_POST[name] already exists");
				}
				else {
					if(strcmp($perm, 'Super Administrator') == 0) {
						Flash::addFlash('Super Admin Saved');
					}
					else {
						Flash::addFlash('Admin Saved');
					}
					$dao->__destruct();
					Utils::redirect('home', array(null));
					exit();
				}
			}
 			else {
				$sql="INSERT INTO employee (name) VALUES ('$name')";
				$result = $db->query($sql);
				if(!$result) {
					$errors[] = new Error('employee',"Employee $_POST[name] already exists");
				}
				else {
					Flash::addFlash('Employee Saved');
					$dao->__destruct();
					Utils::redirect('home', array(null));
					exit();
				}
 			}
		}
	}
?>
