<?


if ($_POST['login_f']) {

captcha_valid();



if ( $_POST['password'] != '12345' or $_SERVER['REMOTE_ADDR'] != 'ip админа')
	message('Доступ запрещен');


$_SESSION['admin'] = 1;
go('a_home');



}

?>