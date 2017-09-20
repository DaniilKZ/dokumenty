<?php
$dir = $_SERVER['DOCUMENT_ROOT'];
include($dir."/PG_Signature.php");

$phone = $_GET['phone'];
$email = $_GET['email'];
$id_current = $_GET['id'];
	
/*
 * Следующие параметры выдаются при подключении магазина к Platron
 */
$MERCHANT_ID = 500336;
$MERCHANT_SECRET_KEY = "7pZygz5iqFSceZlw";

$arrReq = array();

/* Обязательные параметры */
$arrReq['pg_merchant_id'] = 500336;// Идентификатор магазина
$arrReq['pg_order_id']    = $id_current;	// Идентификатор заказа в системе магазина


$arrReq['pg_amount']      = 18000;		// Сумма заказа
$arrReq['pg_lifetime']    = 3600*24;	// Время жизни счёта (в секундах)
$arrReq['pg_description'] = "Услуга"; // Описание заказа (показывается в Платёжной системе)
$arrReq['pg_currency'] = 'KZT';
$arrReq['pg_request_method'] = 'GET';
$arrReq['pg_result_url'] = 'http://dokumenty.kz/payboxresult.php';
$arrReq['pg_success_url'] = 'http://dokumenty.kz/success.php';
$arrReq['pg_user_phone'] = $phone;
$arrReq['pg_user_contact_email'] = $email;
$arrReq['pg_user_email'] = $email;

/*
 * Название ПС из справочника ПС. Задаётся, если не требуется выбор ПС. Если не задано, выбор будет
 * предложен пользователю на сайте platron.ru.
 */
//$arrReq['pg_payment_system'] = $payment

/*
 * Нижеследующие параметры имеет смысл определять, только если они отличаются от заданных
 * в настройках магазина на сайте platron.ru (https://www.platron.ru/admin/merchant_settings.php)
 */
//$arrReq['pg_success_url'] = 'http://example.com/payment_ok.php';
//$arrReq['pg_success_url_method'] = 'AUTOGET';
//$arrReq['pg_failure_url'] = 'http://example.com/payment_failure.php';
//$arrReq['pg_failure_url_method'] = 'AUTOGET';

/* Параметры безопасности сообщения. Необходима генерация pg_salt и подписи сообщения. */
$arrReq['pg_salt'] = rand(21,43433);
$arrReq['pg_sig'] = PG_Signature::make('payment.php', $arrReq, $MERCHANT_SECRET_KEY);
$query = http_build_query($arrReq);

header("Location: https://www.paybox.kz/payment.php?$query");

?>
