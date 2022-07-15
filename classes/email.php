<?php
namespace Class;
use PHPMailer\PHPMailer\PHPMailer;
class Email {
  public $email;
  public $display;
  public $token;
  public function __construct($email, $display, $token) {
    $this->email = $email;
    $this->display = $display;
    $this->token = $token;
  }
  public function sendConfirm() {
    // CREATE THE EMAIL OBJECT
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Port = 2525;
    $mail->Username = '04ff2bf9dd454e';
    $mail->Password = 'dd052ac862a24c';

    $mail->setFrom('santraez@gmail.com');
    $mail->addAddress('santraez@gmail.com', 'mytinycats.com');
    $mail->Subject = 'Confirm your account';

    // SET HTML
    $mail->isHTML(TRUE);
    $mail->CharSet = 'UTF-8';

    $content  = '<html>';
    $content .= '<p><strong>hola ' . $this->display . '</strong> You created your account on MyTinyCats.com, only you confirm click the follow link</p>';
    $content .= '<p>Click here: <a href="http://localhost:8000/confirm-account?token=' . $this->token . '">Confirm your Account</a></p>';
    $content .= '<p>If you not getting this account, ignored the message</p>';
    $content .= '</html>';

    $mail->Body = $content;

    // SEND EMAIL
    $mail->send();
  }
}