<?
top('Услуги') ?>


<table>
<tr>

<td>Услуга 1</td>
<td>Услуга 2</td>
<td>Услуга 3</td>
<td>
<h1>Получить скидку</h1>
</td>

</tr>
	

<tr>
<td>Стоимость: <?=calc_promo(1)?> $</td>
<td>Стоимость: <?=calc_promo(2)?> $</td>
<td>Стоимость: <?=calc_promo(3)?> $</td>


<td>
<input type="text" placeholder="Промокод" id="code">
</td>

</tr>


<tr>

<td>
<input type="hidden" value="1" id="sid1">
<button onclick="post_query('buy', 'services', 'sid1')">Купить</button>
</td>



<td>
<input type="hidden" value="2" id="sid2">
<button onclick="post_query('buy', 'services', 'sid2')">Купить</button>
</td>


<td>
<input type="hidden" value="3" id="sid3">
<button onclick="post_query('buy', 'services', 'sid3')">Купить</button>
</td>





<td>
<button onclick="post_query('buy', 'promo', 'code')">Отправить</button>
</td>

</tr>





</tr>


</table>





<? bottom() ?>