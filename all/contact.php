<? top('Обратная связь') ?>

<h1>Обратная связь</h1>

<p><input type="text" placeholder="E-mail" value="<?=$_SESSION['email']?>" id="email"></p>
<p><textarea id="message" placeholder="Текст сообщения"></textarea></p>
<p><input type="text" placeholder="<?captcha_show()?>" id="captcha"></p>
<p><button onclick="post_query('mail', 'contact', 'email.message.captcha')">Отправить</button> </p>

<? bottom() ?>