<?php

$todo = Utils::getTodoByGetId();
$todo->setStatus(Utils::getUrlParam('status'));
if (array_key_exists('comment', $_POST)) {
    $todo->setComment($_POST['comment']);
}

$dao = new TodoDao();
$dao->save($todo);
//display confirmation message
Flash::addFlash('Project status changed successfully.');
//redirect
Utils::redirect('detail', array('id' => $todo->getId()));

?>
