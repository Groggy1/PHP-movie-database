<?php
$starting_time_measure = MICROTIME(TRUE);
require_once 'class/database.php';
$db = new Database();

if (empty($_POST) && (!is_numeric($_GET['uid']) || !is_numeric($_GET['mid']) || !is_numeric($_GET['vote']))) {
	require_once 'template/header.php';
	echo '<div class="hero-unit"><p>N&aring;got gick fel!</p></div>';
	require_once 'template/footer.php';
	break;
}
if (empty($_POST)) {
	$sql = "SELECT user_id FROM `uservote`
			WHERE `user_id` = :userid AND `movie_id` = :movieid";

	$result = $db -> select_query($sql, array(':userid' => $_GET['uid'], ':movieid' => $_GET['mid']));

	if (count($result) == 1) {
		$sql = "UPDATE `uservote` SET `value`=:vote
				WHERE `movie_id` = :movieid AND `user_id` = :userid";

		$db -> select_query($sql, array(':vote' => $_GET['vote'], ':movieid' => $_GET['mid'], ':userid' => $_GET['uid']));
	} else {
		$sql = "INSERT INTO `uservote`(`user_id`, `movie_id`, `value`)
				VALUES (:userid,:movieid,:vote)";

		$result = $db -> select_query($sql, array(':vote' => $_GET['vote'], ':movieid' => $_GET['mid'], ':userid' => $_GET['uid']));

		$sql = "INSERT INTO userviewed (userid, movieid, date)
				VALUE (:userid,:movieid,NOW())";

		$db -> select_query($sql, array(':movieid' => $_GET['mid'], ':userid' => $_GET['uid']));
	}

	header('location:dispmovie.php?id=' . $_GET['mid']);
} else {
	$sql = "INSERT INTO `usercomment`(`userid`, `movieid`, `comment`, date)
			VALUES (:userid,:movieid,:comment,now())";
	$param = array(':userid' => $_POST['userid'], 'movieid' => $_POST['mid'], ':comment' => strip_tags($_POST['comment']));
	$db -> select_query($sql, $param);

	$sql = "SELECT `userid` FROM `userviewed`
			WHERE `userid` = :userid";

	$result = $db -> select_query($sql, array(':userid' => $_POST['userid']));
	if (count($result) == 0) {
		$sql = "INSERT INTO userviewed (userid, movieid, date)
				VALUE (:userid,:movieid,NOW())";

		$db -> select_query($sql, array(':movieid' => $_POST['mid'], ':userid' => $_POST['userid']));
	}

	header('location:dispmovie.php?id=' . $_POST['mid']);
}
