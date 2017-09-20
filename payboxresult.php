<?php
	$dir = $_SERVER['DOCUMENT_ROOT'];
	
	include($dir."/PG_Signature.php");

	/*
	 * Секретный ключ магазина в системе Platron (выдается при подключении магазина к Platron)
	 */
	$MERCHANT_SECRET_KEY = "7pZygz5iqFSceZlw";
	

	$arrParams = $_GET;
	$sum = $arrParams['pg_amount']; //Сумма оплаченная покупателем
	$order_id = $arrParams['pg_order_id']; //Номер заказа в нашей системе (ID заказа из таблицы)
	$paybox_id = $arrParams['pg_payment_id']; //ID оплаты платежной системы


	$thisScriptName = PG_Signature::getOurScriptName();

   $filename ='file.txt';

   object2file($arrParams, $filename);

 function object2file($arrParams, $filename)
{
	$order_id = $arrParams['pg_order_id'];
    $str_value = 'id:'.$order_id;
    //file_put_contents($filename, $data);
    $f = fopen($filename, 'w');
    fwrite($f, $str_value);
    fclose($f);
}

	if ( !PG_Signature::check($arrParams['pg_sig'], $thisScriptName, $arrParams, $MERCHANT_SECRET_KEY) ) {
		$filename ='file.txt';
		 $f = fopen($filename, 'w');
	    fwrite($f, 'bad');
	    fclose($f);
		die("Bad signature");
	}

	

	if ( $arrParams['pg_result'] == 1 ) {
		// обрабатываем случай успешной оплаты заказа с номером $order_id
		
		/* Здесь нужно проверить, если оплата не была проведена ранее, то запись в таблицу данные об успешной оплате,
		например, за показатель успешной оплаты у нас отвечает поле таблицы, которое называется `done`.
		Если оплата уже прошла, то done = 1, в противном случае NULL.
		
		Елси на момент проверки `done` = 0, то мы отправляем пользователю на почту письмо с логином и паролем. 
		Логин и пароль также можно сформировать на текущем этапе.
		
		После этого записываем, что поле `done` становится равно 1.
		
		Если же на момент проверки поле уже равно 1, то ничего не делаем в теле условия.
		
		Для чего нужна предварительная проверка, что оплата не была проведена ранее:
		Дело в том, что платежный шлюз может несколько раз отправлять на наш сайт информацию об успешной оплате одного и того же заказа.
		И если мы не сделаем проверку, то сколько раз платежный шлюз обратится к нам на сервер, столько раз клиент получит письмо с доступом.
		Платежный шлюз может и 200 раз обратиться к нам с одним и тем же заказом, и получится, что пользователь получит письмо с логином и паролем также 200 раз.
		
		Ниже примерный код проверки оплаты
		*/
		$filename ='file.txt';
		 $f = fopen($filename, 'w');
	    fwrite($f, 'bd');
	    fclose($f);
	require_once "db.php";
	$query ="UPDATE `clients` SET `oplata` = 'Оплачен' WHERE `id` = '$order_id'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	}
	else {

	}


/*
 * Формируем ответный XML
 * ТУТ ничего менять не нужно.
 */
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
$xml->addChild('pg_salt', $arrParams['pg_salt']); // в ответе необходимо указывать тот же pg_salt, что и в запросе
$xml->addChild('pg_status', 'ok');
$xml->addChild('pg_description', "Оплата принята");
$xml->addChild('pg_sig', PG_Signature::makeXML($thisScriptName, $xml, $MERCHANT_SECRET_KEY));

header('Content-type: text/xml');
print $xml->asXML();
?>