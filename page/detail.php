<?php


// data for template
$todo = Utils::getTodoByGetId();
$tooLate = $todo->getStatus() == Todo::STATUS_CURRENT && $todo->getDueOn() < new DateTime();
$id = $todo->getId();

$_SESSION['ms'] = $id;

?>

<head>
    <script src="js/jquery-1.6.2.min.js"></script>
    <script src="js/jquery-ui-1.8.16.custom.min.js"></script>
</head>
