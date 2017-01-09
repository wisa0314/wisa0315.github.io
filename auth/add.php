<?

if ($_POST['reviews_f']) {


	if ( strlen($_POST['message']) < 10 or strlen($_POST['message']) > 100 )
		message('Длина сообщения должна составлять 10 - 100 символов');



	mysqli_query($CONNECT, 'INSERT INTO `reviews` VALUES ("", "'.$_SESSION['id'].'", "'.mysqli_real_escape_string($CONNECT, $_POST['message']).'")');

	go('reviews');
}



?>