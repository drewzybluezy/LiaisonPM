<?php


$todo = Utils::getTodoByGetId();

$dao = new TodoDao();
$dao->delete($todo->getId());
Flash::addFlash('Project deleted successfully.');

Utils::redirect('list', array('status' => $todo->getStatus()));

?>
