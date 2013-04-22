<?php
/*
Purpose: confirmation or rejection of new project information based upon input's validity.
Success: stores information in database, confirmation message is displayed, displays the information as a new project under the 'detail' pages
Failure: Rejection message is sent, identifying the input field with invalid information for the user.
*/

/* 
errors: stores error messages corresponding with the field(s) containing invlid input
todo: (When Editing A Project) retrieves and displayes current project information in input fields
      (When Adding A New Project) sets input fields to standard values
edit: boolean to discern between editing a project and adding a project
*/ 
$errors = array();
$todo = null;
$edit = array_key_exists('id', $_GET);
if ($edit) {
    $todo = Utils::getTodoByGetId();
} else {
    // set defaults
    $todo = new Todo();
    $todo->setPriority(Todo::PRIORITY_MEDIUM);
    $dueOn = new DateTime("+1 day");
    $dueOn->setTime(0, 0, 0);
    $todo->setDueOn($dueOn);
}

if (array_key_exists('cancel', $_POST)) {
    // redirect
    Utils::redirect('detail', array('id' => $todo->getId()));
} elseif (array_key_exists('save', $_POST)) {
    // for security reasons, do not map the whole $_POST['todo']
    $data = array(
        'title' => $_POST['todo']['title'],
        'due_on' => $_POST['todo']['due_on_date'] . ' ' . $_POST['todo']['due_on_hour'] . ':' . $_POST['todo']['due_on_minute'] . ':00',
        'priority' => $_POST['todo']['priority'],
        'description' => $_POST['todo']['description'],
        'comment' => $_POST['todo']['comment'],

    );
        
    // map
    TodoMapper::map($todo, $data);
    // validate
    $errors = TodoValidator::validate($todo);
    // validate
    if (empty($errors)) {
	if(empty($_POST['assignTo'])) {
		$errors[] = new Error('assignTo', 'Minimum Number of Asssigned Employees is 1.');
	}
    }
    if (empty($errors)) {
        // save
        $dao = new TodoDao();
        $db = $dao->getDb();
        $todo = $dao->save($todo);
	$a = $_POST['assignTo'];
	 if(count($a) != 0) {
		$tempId = $todo->getId();
		if($edit) {
			$query = "DELETE FROM worksOn WHERE pid = '$tempId'";
			$db->query($query) or die("error deleting");
		}
		$query = "INSERT INTO worksOn (pid,eid) VALUES";
		for($i = 0; $i < count($a); $i++) {
			$query = $query."('$tempId','$a[$i]')"; ?>
<?php			if($i < count($a) - 1) {
				$query = $query.',';
			}
		}
		$db->query($query) or die("error editing project");
		$dao->__destruct();
	 }
	 //display confirmation message
        Flash::addFlash('Project saved successfully.');
        // redirect
        Utils::redirect('detail', array('id' => $todo->getId()));
    }
}
?>
