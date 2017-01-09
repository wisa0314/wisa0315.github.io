<?

function go_auth($data) {
	foreach ($data as $key => $value) 
		$_SESSION[$key] = $value;

	go('profile');
}




if ($_POST['login_f']) {
	captcha_valid();
	email_valid();
	password_valid();

	if ( !mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]' AND `password` = '$_POST[password]'")) )
		message('Аккаунт не найден');



	$row = mysqli_fetch_assoc( mysqli_query($CONNECT, "SELECT * FROM `users` WHERE `email` = '$_POST[email]'") );


	if ( $row['ip'] ) {

		$arr = explode(',', $row['ip']);


		if ( !in_array($_SERVER['REMOTE_ADDR'], $arr) )
			message('Доступ запрещен для этого IP');

	}



	if ( $row['protected'] == 1 ) {


	$code = random_str(5);

	 $_SESSION['confirm'] = array(
	 	'type' => 'login',
	 	'data' => $row,
	 	'code' => $code,
	 	);


	 send_mail($_POST['email'], 'Подтверждение входа', "Код подтверждения входа: $code");

	 go('confirm');





	}







	go_auth($row);


}



else if ($_POST['register_f']) {
	captcha_valid();
	email_valid();
	password_valid();



	if ( mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'")) )
	 	message('Этот E-mail занят');


	 $code = random_str(5);

	 $_SESSION['confirm'] = array(
	 	'type' => 'register',
	 	'email' => $_POST['email'],
	 	'password' => $_POST['password'],
	 	'code' => $code,
	 	);

send_mail($_POST['email'], 'Регистрация', "Код подтверждения регистрации: $code");


go('confirm');




}










else if ($_POST['recovery_f']) {
		captcha_valid();
		email_valid();

		if ( !mysqli_num_rows(mysqli_query($CONNECT, "SELECT `id` FROM `users` WHERE `email` = '$_POST[email]'")) )
			message('Аккаунт не найден');

		$code = random_str(5);

	 $_SESSION['confirm'] = array(
	 	'type' => 'recovery',
	 	'email' => $_POST['email'],
	 	'code' => $code,
	 	);

	 send_mail($_POST['email'], 'Восстановление пароля', "Код подтверждения восстановление пароля: $code");

	 go('confirm');


}












else if ($_POST['confirm_f']) {

	


	if ( $_SESSION['confirm']['type'] == 'register') {




		if ( $_SESSION['confirm']['code'] != $_POST['code'] )
				message('Код подтверждения регистрации указан неверно');



			if ( is_numeric($_COOKIE['ref']) )
				$ref = $_COOKIE['ref'];

			else $ref = 0;



			mysqli_query($CONNECT, 'INSERT INTO `users` VALUES ("", "'.$_SESSION['confirm']['email'].'", "'.$_SESSION['confirm']['password'].'", "", 0, '.$ref.', 0)');
			unset($_SESSION['confirm']);

			go('login');

		}




		else if ( $_SESSION['confirm']['type'] == 'recovery') {

			if ( $_SESSION['confirm']['code'] != $_POST['code'] )
				message('Код подтверждения регистрации указан неверно');


			$newpass = random_str(10);


			mysqli_query($CONNECT, 'UPDATE `users` SET `password` = "'.md5($newpass).'" WHERE `email` = "'.$_SESSION['confirm']['email'].'"');
			unset($_SESSION['confirm']);

			message("Ваш новый пароль: $newpass");

	}






	else if ( $_SESSION['confirm']['type'] == 'login') {

		if ( $_SESSION['confirm']['code'] != $_POST['code'] )
				message('Код подтверждения регистрации указан неверно');

			go_auth($_SESSION['confirm']['data'] );



	}













	
	else not_found();






}







?>