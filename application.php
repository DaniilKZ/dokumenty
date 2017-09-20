<?php 
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Dexter group - Юридическая безопасность в сфере трудового права</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.fancybox.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/thanks.css" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="57x57" href="img/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="img/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="img/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="img/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="img/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="img/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="img/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="img/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="manifest" href="img/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="img/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php
require_once "db.php";

$name = htmlspecialchars(mysqli_real_escape_string($link, $_POST['name']));
$email= htmlentities(mysqli_real_escape_string($link, $_POST['email']));
$phone= htmlentities(mysqli_real_escape_string($link, $_POST['phone']));


    // создание строки запроса
$query ="INSERT INTO clients VALUES(NULL, '$name','$email','$phone','Не оплачен')";
// $result = mysqli_query($link, $query) or die("Ошибка: Данные не добавлены" . mysqli_error($link)); 

$link->query($query);
$last_id = $link->insert_id;




$sendto = "info@dextergroup.kz"; // info@dextergroup.kz почта, на которую будет приходить письмо
$name = $_POST['name'];   // сохраняем в переменную данные полученные из поля c именем
$phone = $_POST['phone']; // сохраняем в переменную данные полученные из поля c телефонным номером
$email = $_POST['email']; // сохраняем в переменную данные полученные из поля c адресом электронной почты
$questions = $_POST['questions'];

// Формирование заголовка письма
$subject  = "Заявка с Landing page dokumenty.kz";
$headers  = "From: info@dokumenty.kz \r\n";
$headers .= "Reply-To: info@dokumenty.kz \r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html;charset=utf-8 \r\n";
 
// Формирование тела письма
$msg  = "<html><body style='font-family:Arial,sans-serif;'>";
$msg .= "<p><strong>ID:</strong> ".$last_id."</p>\r\n";
$msg .= "<p><strong>Имя:</strong> ".$name."</p>\r\n";
$msg .= "<p><strong>Телефон:</strong> ".$phone."</p>\r\n";
$msg .= "<p><strong>Почта:</strong> ".$email."</p>\r\n";
$msg .= "<p><strong>Вопрос:</strong> ".$questions."</p>\r\n";
$msg .= "</body></html>";
 
// отправка сообщения
mail($sendto, $subject, $msg, $headers);

$clientId = trim($last_id);
$name = trim($name);
$email = trim($email);
$phone = trim($phone);

$arrPay = array();
$arrPay['id'] = $clientId;
$arrPay['name'] = $name;
$arrPay['email'] = $email;
$arrPay['phone'] = $phone;
$query = http_build_query($arrPay);

?>
  <body> 
  <style>
    .first-li:before {
      display: none;
    }
  </style>
    <section id="thx-page">
      <div class="container">
        <h1>Благодарим Вас за проявленный интерес к нашему продукту!</h1>
        <h4 style="font-size: 20px; text-align: center;">Внедрив приобретаемые документы в своей компании, Вы защитите свой бизнес от административных штрафов и от противоправных действий работников.</h4>
        <ul>
        <li class="first-li"><b>Приобретаемый Вами пакет содержит более 50 документов, который включает в себя:</b></li>
          <li>Трудовые договора для различных категорий работников;</li>
          <li>Все необходимые (обязательные) кадровые документы, соответствующие законодательству РК;</li>
          <li>Более 25 актов работодателя регулирующие деятельность компании;</li>
          <li>Документы по защите конфиденциальной информации;</li>
          <li>Документы для защиты от конкуренции;</li>
          <li>Документы по технике безопасности и охраны труда;</li>
          <li>Документы по защите персональных данных и работе с персональными данными;</li>
          <li>Другие документы необходимые для взаимоотношений с работником.</li>
        </ul>
        <div class="warning">
          Все документы подготовлены на русском и казахском языках
          <br>
          Также имеется инструкция по разработанным нами документам, благодаря которой Вы разберетесь в кадровых вопросах.
          <br>
          <b>Стоимость всего пакета документов 18 000 тенге.</b>
        </div>
        <div class="btn-group">
          <a style="min-width: 270px;" href="http://www.dokumenty.kz/billing.php?id=<?php echo $clientId?>" class="thx-btn">Запросить счет на оплату</a>
         <a style="min-width: 270px;" href="http://www.dokumenty.kz/paybox.php?<?php echo $query; ?>" class="thx-btn">Оплатить другим способом</a>
          <img class="img-responsive" src="img/set.png" alt="">
        </div>
      </div>
    </section>

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
    <script src="js/bootstrap.min.js"></script>
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


