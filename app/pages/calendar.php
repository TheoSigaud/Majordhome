<?php
session_start();
if (!isset($_SESSION['user']) || ($_SESSION['user']['statut'] != 2 && $_SESSION['user']['statut'] != 3 )) {
    header('Location: ../index.php');
}

$month = $_GET['month'];
$year = $_GET['year'];

include 'functionsCalendar.php';

?>

<h1 id="titleCalendar"><?php echo month($month)." ".$year; ?></h1>

<div>
	<?php calendar($month, $year); ?>
</div>