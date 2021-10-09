<?php
// define constants
define("RECIPIENT_NAME", "Cliente");
define("RECIPIENT_EMAIL", "email@goeshere.com");     // update recipient email
define("EMAIL_SUBJECT", "Mensagem vinda do site Santini Delivery");

//dados para upload
$uploaddir = 'uploads/';
$temp = explode(".", $_FILES["file"]["name"]);
$timestamp = date('dmYHis').str_replace(" ", "");
$newfilename= $timestamp . "-" . basename($_FILES["file"]["name"]);
$uploadfile = $uploaddir . $newfilename;

// read form values
$send = false;
$name = isset($_POST['name']) ? preg_replace("/[^\.\-\' a-zA-Z0-9]/", "", $_POST['name']) : "";
$email = isset($_POST['email']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['email']) : "";
$phone = isset($_POST['phone']) ? preg_replace("/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['phone']) : "";
$conteudo = "Nome: $name <br />Email: " . $email . "<br />Telefone: " . $_POST['phone'] . "<br />Protocolo: " . $timestamp . "<br />Curriculum: <a href='http://santinidelivery.com/uploads/$newfilename'>Clique aqui</a> ";

$message = isset($_POST['phone']) ? preg_replace("/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $conteudo) : "";

$uploaded = false;
//tenta enviar o arquivo
if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
    
    // check availability of values, then send mail
    if ($name && $email && $message) {
        $recipient = RECIPIENT_EMAIL ;
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
        $headers .= "From: " . $name . " <" . $email . ">";
        $send = mail($recipient, EMAIL_SUBJECT, $message, $headers);
    }
    
    //resposta para cliente
    if( $send ){
        echo '<i class="fa fa-check-circle" style="color: green"></i> Success! Your protocol: ' . $timestamp;
    }else{
        echo '<i class="fas fa-exclamation" style="color: red"></i> Error! Try again';
    }
}
?>
