<?php
if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error, que hay que enviar el formulario!";
}
$name = $_POST['name'];
$tel = $_POST['tel'];
$visitor_email = $_POST['email'];
$message = $_POST['message'];

//Validate first
if(empty($name)||empty($visitor_email)) 
{
    echo "Nombre, Teléfono e Email son obligatorios!";
    exit;
}

if(IsInjected($visitor_email))
{
    echo "email in valido!";
    exit;
}

$email_from = 'contacto@npixel.com.mx';//<== update the email address
$email_subject = "Correo desde Web";
$email_body = "Ha recibido un nuevo mensaje del usuario $name.\n".
			"Su Teléfono es: $tel.\n".
			"Su Correo es: $visitor_email.\n".
    "Aquí está el mensaje:\n $message".
    
$to = "hedyepiz@gmail.com";//<== update the email address
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";
//Send the email!
mail($to,$email_subject,$email_body,$headers);
//done. redirect to thank-you page.
header('Location: enviado.html');


// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}
   
?> 