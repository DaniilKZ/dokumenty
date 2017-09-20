<?php 
$phrase = htmlspecialchars($_GET['phrase']);
$referer = htmlspecialchars($_GET['referer']);
// ini_set('error_reporting', E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
?>
<!DOCTYPE html>
<head>
<meta charset="UTF-8">
<title>Страница благодарности</title>
</head>
<style>
    html,body {
        height: 100%;
    }
    body {
        background-color: #efefef;
    }
    .thx-wrapp {
        text-align: center;
        margin-top: 150px;
    }
</style>
<body>
    <div class="thx-wrapp">
        <h1>Спасибо Ваша заявка принята! <br>Мы перезвоним Вам в течении 15 минут!</h1>
    </div>
</body>
<?php 
function complete_mail() {  

    $leadData = $_POST['DATA'];
    // Получаем данные из форм и сохраняем в массив
    $postData = array(
        'Имя:' => $leadData['name'],
        'Телефон:' =>$leadData['phone'],
        'E-mail:' =>$leadData['email'],
        'Вопрос:' =>$leadData['questions'],
        'Форма:' =>$leadData['formname'],
        'Источник перехода:' =>$leadData['source'],
        'Название компании:' =>$leadData['companyname'],
        'Канал компании:' =>$leadData['chanel']
    );
        $strPostData = '';
        foreach ($postData as $key => $value)
            $strPostData .= ($strPostData == '' ? '' : ' ').$key.' '.($value)."<br>";
        	$str .= "<p><strong>Заявка:</strong> <br/> ".($strPostData)."</p>\r\n";
		require 'class.phpmailer.php'; //Дополнительный скрипт для отправки файла, можете не открывать, просто положите рядом с index.html и этим файлом.
		$mail = new PHPMailer(); 
        $mail->From = 'info@dokumenty.kz';      // от кого 
        $mail->FromName = 'info@dokumenty.kz';   // от кого Имя
        $mail->AddAddress('info@dokumenty.kz', 'Имя'); // кому Ваша почта, Имя 
        $mail->IsHTML(true);        // формат письма HTML 
        $mail->Subject = "Заявка с Landing page dokumenty.kz";  // тема письма 
        // если есть файл, то прикрепляем его к письму 
        if(isset($_FILES['f'])) { 
                 if($_FILES['f']['error'] == 0){ 
                    $mail->AddAttachment($_FILES['f']['tmp_name'], $_FILES['f']['name']); 
                 } 
        } 
        $mail->Body = $str; 
        // отправляем наше письмо 
        if (!$mail->Send()) die ('Mailer Error: '.$mail->ErrorInfo);     
} 

if (!empty($_POST['submit'])) complete_mail(); 
else show_form(); 


$leadData = $_POST['DATA'];
    foreach($leadData as &$value) {
        $value = stripslashes($value);
        $value = htmlspecialchars(strip_tags($value));
    }
$name = trim($leadData['name']);
$email = trim($leadData['email']);
$phone = trim($leadData['phone']);

$arrPay = array();
$arrPay['name'] = $name;
$arrPay['email'] = $email;
$arrPay['phone'] = $phone;
$query = http_build_query($arrPay);
header("Location: http://www.dokumenty.kz/paybox.php?$query");
?> 