<?

$handle = @fopen('ban.txt', 'r');

if ($handle) {
   

    while (($buffer = fgets($handle, 4096)) !== false) {


    	if ( trim($buffer) == $_SERVER['REMOTE_ADDR'] )
    		exit('Доступ с этого IP запрещен');
       

    
    }



    if (!feof($handle)) {
        echo 'Error: unexpected fgets() fail';
    }



    fclose($handle);
}








if ( is_numeric($_GET['ref']) ) {

	setcookie('ref', $_GET['ref'], strtotime('+1 week') );

	header('location: /home');
}





if ( $_SERVER['REQUEST_URI'] == '/' ) $page = 'home';
else {

	$page = substr($_SERVER['REQUEST_URI'], 1);
	if ( !preg_match('/^[A-z0-9]{3,15}$/', $page) ) not_found();
}





$CONNECT = mysqli_connect('localhost', 'shiftmr_hrthtrhr', '7DKn5uSF', 'shiftmr_hrthtrhr');

if ( !$CONNECT ) exit('MySQL error');



session_start();




if ( file_exists('all/'.$page.'.php') ) include 'all/'.$page.'.php';

else if ( $_SESSION['id'] and file_exists('auth/'.$page.'.php') ) include 'auth/'.$page.'.php';

else if ( !$_SESSION['id'] and file_exists('guest/'.$page.'.php') ) include 'guest/'.$page.'.php';


else if ( $_SESSION['admin'] and file_exists('admin/'.$page.'.php') ) include 'admin/'.$page.'.php';



else not_found();




function message( $text ) {
	exit('{ "message" : "'.$text.'"}');
}



function go( $url ) {
	exit('{ "go" : "'.$url.'"}');
}



function random_str( $num = 30 ) {
	return substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, $num);
}


function not_found() {
	exit('Страница 404');
}


function captcha_show() {

	$questions = array(
		1 => 'Столица России ?',
		2 => 'Столица Украины ?',
		3 => 'Столица США ?',
		4 => 'Имя короля поп музыки ?',
		5 => 'Разработчки GTA 5 ?',
		);

	$num = mt_rand(1, count($questions) );
	$_SESSION['captcha'] = $num;

	echo $questions[$num];

}


function services_price( $id ) {
	$arr = array(
		1 => 10,
		2 => 50,
		3 => 200,
		);
	return $arr[$id];
}




function services_promo( $code ) {
	$arr = array(
		'gnf348yngy834u' => 10,
		'v34ybhg2383h35' => 50,
		);
	return $arr[$code];
}





function calc_promo($id) {
if ($_SESSION['promo']) $promo = $_SESSION['promo'];
else $promo = 0;

$per = (services_price($id) * $promo ) / 100;
return (services_price($id) - $per);
}





function captcha_valid() {

	$answers = array(
		1 => 'москва',
		2 => 'киев',
		3 => 'вашингтон',
		4 => 'майкл',
		5 => 'RockStarGames',
		);

if ( $_SESSION['captcha'] != array_search( strtolower($_POST['captcha']), $answers) )
	message('Ответ на вопрос указан неверно');
 
}









function email_valid() {
	if ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL))
		message('E-mail указан неверно');
}



function password_valid() {
	if ( !preg_match('/^[A-z0-9]{10,30}$/', $_POST['password']) )
		message('Пароль указан неверно и может содеражть 10 - 30 символов A-z0-9');
	$_POST['password'] = md5($_POST['password']);
}



function send_mail( $email, $title, $text ) {

mail($email, $title, '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
</head>

<body style="margin:0">


<div style="margin:0; padding:0; font-size: 18px; font-family: Arial, sans-serif; font-weight: bold; text-align: center; background: #FCFCFD">


<div style="margin:0; background: #464E78; padding: 25px; color:#fff">'.$title.'</div>


<div style="padding:30px;">


<div style="background: #fff; border-radius: 10px; padding: 25px; border: 1px solid #EEEFF2">'.$text.'</div>

</div>

</div>

</body>
</html>', "From: admin@mysite.com\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UTF-8");

}







function top( $title ) {
echo '<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>'.$title.'</title>
<link rel="stylesheet" href="/style.css">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<script src="https://code.jquery.com/jquery-1.12.4.js" integrity="sha256-Qw82+bXyGq6MydymqBxNPYTaUXXq7c8v3CwiYwLLNXU=" crossorigin="anonymous"></script>
<script src="/script.js"></script>
</head>

<body>


<div class="wrapper">

<div class="menu">
<a href="/contact">Обратная связь</a>
';

if ($_SESSION['id'])
	echo '
<a href="/profile">Профайл</a>
<a href="/history">История</a>
<a href="/referral">Рефералы</a>
<a href="/reviews">Отзывы</a>
<a href="/services">Услуги</a>
<a href="/logout">Выход</a>

';

else 
	echo '
<a href="/login">Вход</a>
<a href="/register">Регистрация</a>
';




echo'
</div>
<div class="content">
<div class="block">
';
}
















function bottom() {
echo '
</div>
</div>
</div>

</body>
</html>';
}






?>