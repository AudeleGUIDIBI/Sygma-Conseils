<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../config.php';
require '/var/www/html/workspace/sygma_conseils/vendor/autoload.php';

$Email = $username;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  $name = htmlspecialchars(trim($_POST['name']));
  $email = htmlspecialchars(trim($_POST['email']));
  $tel = htmlspecialchars(trim($_POST['tel']));
  $sujet = htmlspecialchars(trim($_POST['sujet']));
  $message = htmlspecialchars(trim($_POST['message']));

  if (!empty($name) && !empty($email) && !empty($sujet) && !empty($message)) 
  {

    $mail = new PHPMailer(true);

    try 
    {
      $mail -> isSMTP();
      $mail -> Host = $hostname;
      $mail -> Port = 587;
      $mail -> SMTPAuth = true;
      $mail -> Username = $username;
      $mail -> Password = $password;
      $mail -> SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

      $mail -> SMTPDebug = 0;
      $mail -> Debugoutput = ''; 

      $mail -> setFrom($email,$name);
      $mail -> addAddress($Email);

      $mail -> isHTML(true);
      $mail -> Subject = $sujet;
      $mail -> Body = "
        <h2><strong>Contact via le site web de Sygma Conseils</strong></h2>
        <p><strong>Nom :</strong>{$name}</p>
        <p><strong>Email :</strong>{$email}</p>
        <p><strong>Téléphone :</strong>{$tel}</p>
        <p><strong>Sujet :</strong>{$sujet}</p>
        <p><strong>Message :</strong>{$message}</p>
      "; 
      if ($mail->send()) {
        echo 'ok';
      } 
      else {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
      }
    } 
    catch (Exception $e) 
    {
      echo 'Mailer Error:' .$mail -> ErrorInfo;
    }
    
  }
  else {
    echo '<div class="error-message">Veuillez remplir tous les champs du formulaire.</div>';
  }

}
else 
{
  echo '<div class="error-message">Méthode non autorisée.</div>';

}




?>
