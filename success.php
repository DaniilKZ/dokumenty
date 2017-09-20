<?php 
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include("PG_Signature.php");

  /*
   * Секретный ключ магазина в системе Platron (выдается при подключении магазина к Platron)
   */
  $MERCHANT_SECRET_KEY = "7pZygz5iqFSceZlw";
  

  $arrParams = $_GET;
  $thisScriptName = PG_Signature::getOurScriptName();


  if ( !PG_Signature::check($arrParams['pg_sig'], $thisScriptName, $arrParams, $MERCHANT_SECRET_KEY) )
    die("Bad signature");

	$order_id = $arrParams['pg_order_id']; //Номер заказа в нашей системе (ID заказа из таблицы)

	$clCheck = $query ="SELECT `id` FROM `clients` WHERE `oplata` = 'Оплачен' AND `id`= '$order_id' + 1";

	if($clCheck == true) {
		$sendto   = "info@dextergroup.kz"; // почта, на которую будет приходить письмо
		$usermail = "info@dextergroup.kz"; // сохраняем в переменную данные получе

			// Формирование заголовка письма
		$subject  = "Клиент успешно оплатил";
		$headers  = "From: " . strip_tags($usermail) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($usermail) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html;charset=utf-8 \r\n";

			// Формирование тела письма
		$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
		$msg .= "<h2 style='font-weight:bold;border-bottom:1px dotted #ccc;'>Клиент успешно оплатил</h2>\r\n";
		$msg .= "<p><strong>ID Заказа:</strong> ". $order_id."</p>\r\n";
		$msg .= "</body></html>";

			// отправка сообщения
		mail($sendto, $subject, $msg, $headers);

		$clStatus = 'Оплата прошла успешно.';
	} else {
		$clStatus = 'Произошла ошибка, попробуйте еще раз!';
	}

  	
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1><?php echo $clStatus;?></h1>
	<?php 
	if($clCheck == true) {
		?>
		<script>
			setTimeout( 'window.location="http://dokumenty.kz/file.rar";', 0);
		</script>
	<?php
	};
	?>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-103170861-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>