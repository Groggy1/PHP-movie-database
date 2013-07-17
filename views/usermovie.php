<?php
require_once 'class/arraytools.php';
$ar = new ArrayTools();

if (is_numeric($_REQUEST['mid']) && is_numeric($_REQUEST['uid']) && !empty($_REQUEST['mid']) && !empty($_REQUEST['uid']) && is_numeric($_REQUEST['action']) && isset($_REQUEST['action']) && $_REQUEST['action'] != "4") {
	$sql = "SELECT count(*) FROM `userviewed` WHERE
			`movieid` = :mid AND `userid` = :uid";

	$result = $ar -> unique_flat_array($db -> select_query($sql, array(':mid' => $_REQUEST['mid'], ':uid' => $_REQUEST['uid'])));

	if ($result[0] == 0) {
		$sql = "INSERT INTO userviewed (userid, movieid, date)
				VALUE (:userid,:movieid,NOW())";

		$db -> select_query($sql, array(':movieid' => $_REQUEST['mid'], ':userid' => $_REQUEST['uid']));
	}
	$pass = TRUE;
}

if (is_numeric($_REQUEST['action']) && isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == 1 && is_numeric($_REQUEST['mid']) && is_numeric($_REQUEST['userid']) && !empty($_REQUEST['mid']) && !empty($_REQUEST['userid'])) {
		$sql = "INSERT INTO `usercomment`(`userid`, `movieid`, `comment`, date)
				VALUES (:userid,:movieid,:comment,now())";

		$param = array(':userid' => $_POST['userid'], 'movieid' => $_POST['mid'], ':comment' => strip_tags($_POST['comment']));
		$db -> select_query($sql, $param);
	} elseif ($_REQUEST['action'] == 3 && is_numeric($_REQUEST['mid']) && is_numeric($_REQUEST['uid']) && is_numeric($_REQUEST['vote']) && !empty($_REQUEST['mid']) && !empty($_REQUEST['uid']) && !empty($_REQUEST['vote'])) {
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
		}
	}elseif ($_REQUEST['action'] == 4 && is_numeric($_REQUEST['mid']) && is_numeric($_REQUEST['uid'])) {
		$sql = "INSERT INTO towatch(movieid, userid, date) 
				VALUES (:mid,:uid,now())";
				
		$db -> select_query($sql, array(':mid' => $_GET['mid'], ':uid' => $_GET['uid']));
	} elseif (!$pass) {
		require_once 'template/header.php';
		echo '<div class="hero-unit">Något gick fel 1!</div>';
		require_once 'template/footer.php';
	} 
} elseif (!$pass) {
	$sitetitle = "Kunde inte slutföra återgärden";
	require_once 'template/header.php';
	echo '<div class="hero-unit">Något gick fel!</div>';
	require_once 'template/footer.php';
	break;
}

header('location:dispmovie.php?id=' . $_REQUEST['mid']);
