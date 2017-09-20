<?php
	require_once "order.php";
	
	$client_id = $_POST['id_order'];   // id заказа
	$company_name = $_POST['company_name']; // Имя компании
	$adres = $_POST['adres']; // Адрес
	$bin = $_POST['bin']; // БИН

	$host = 'srv-db-plesk03.ps.kz:3306'; // адрес сервера 
	$database = 'mediagur_dokumenty.kz'; // имя базы данных
	$user = 'media_dexter'; // имя пользователя
	$password = 'uYkh336$'; // пароль
	
	
	// подключаемся к серверу
	$link = mysqli_connect($host, $user, $password, $database);

	// Этот запрос не влияет на поведение ф-ии $mysqli->real_escape_string();
	$link->query("SET NAMES utf8");
	
	// И этот не влияет на $mysqli->real_escape_string();
	$link->query("SET CHARACTER SET utf8");
	
	// но вот этот запрос повлияет на поведение ф-ии $mysqli->	real_escape_string();
	$link->set_charset('utf8');
	
	// а этот НЕ повлияет, потому что нельзя использовать "-" тире/дефис
	$link->set_charset('utf-8'); // (utf8, а не utf-8)
	$query ="UPDATE clients SET oplata='Выставлен счет' WHERE id='$client_id'";
	$link->query($query);

	$order = new order;
	$dt = date("Y-m-d H:i:s");
	$knp = '859'; //Код назначения платежа
	$orgAdress = 'г. Алматы, ул. Желтоксан дом 111"А"'; //Адрес поставщика
	$clBin = $bin; //БИН заказчика
	$clNaim = $company_name;
	$clAdr = $adres;
	$dogNum = 'Без договора'; //Договор
	$itemNaim = 'Оказание юридических услуг'; //Наименование услуги
	$itemKolvo = '1'; //Количество
	$itemEdIzm = 'Услуги'; //Единица измерения
	$itemTsena = '18000';
	$pdf = $order->printPDF($client_id , $dt, 'Товарищество с ограниченной ответственностью "Dexter Group"', "ИИН", "060540001713", "KZ05914002203KZ005W2", "17", 'ДБ АО "Сбербанк"', 'SABRKZKA', $knp, $orgAdress,
					$clBin, $clNaim, $clAdr, $dogNum, $itemNaim, $itemKolvo, $itemEdIzm, $itemTsena);
	$pdf->Output('schet_na_oplatu.pdf', "D");
?>