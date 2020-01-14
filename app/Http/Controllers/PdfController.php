<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Albaran;
use App\Aviso;
use App\Configuracion;
use App\tbContacto;
use App\Empleado;
use App\Maquina;
use App\Referencia;
use Barryvdh\DomPDF\Facade as PDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class PdfController extends Controller
{
    public function imprimir($id)
    {
        $albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
        $aviso = Aviso::find($albaran[0]->aviso_id);
        $cliente = tbContacto::find($aviso->contacto_id);
        $empleado = Empleado::find($aviso->empleado_id);
        foreach ($albaran[0]->albaranmaquina as $maq) {
            $maquina[$maq->maquina_id] = Maquina::find($maq->maquina_id);
        }
        $pdf = PDF::loadView('pdf/pdf', compact('albaran', 'cliente', 'empleado', 'maquina'));
        $pdf->save('albaranes/parte' . $id . '.pdf');
        return ($maquina);


    }
    public function enviar($id)
    {
        $albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
        $aviso = Aviso::find($albaran[0]->aviso_id);
        $cliente = tbContacto::find($aviso->contacto_id);

        $config = Configuracion::first();
        $mail_username = $config->email; //Correo electronico saliente ejemplo: tucorreo@gmail.com
        $mail_userpassword = $config->password; //Tu contraseña de gmail
        $mail_addAddress = $cliente->Email; //correo electronico que recibira el mensaje
        $template = '
            <h1> Corrreo de envio de parte de trabajo</h1>
            <img src="/img/logo.jpeg"  style="margin:auto;" alt="">
            <h4> por favor no responda a este correo este es un mensaje atomatico para el envio de partes de trabajo a clientes</h4>
            <p> Correo enviado a: <strong>' . $cliente->Nombre . '</strong> </p>
            <p> Parte numero <strong> ' . $id . ' </strong> </p>
            <p> Gracias por su confianza</p>
            
	    '; //Ruta de la plantilla HTML para enviar nuestro mensaje

        /*Inicio captura de datos enviados por $_POST para enviar el correo */
        $mail_setFromEmail = $mail_username;
        $mail_setFromName = $mail_username;
        $txt_message = $mail_username;
        $mail_subject = "yo";
        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->SMTPDebug = 2;                         // Establecer el correo electrónico para utilizar SMTP
            $mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
            $mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
            $mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
            $mail->Password = $mail_userpassword;         // Tu contraseña de gmail
            $mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
            $mail->Port = 587;                          // Puerto TCP  para conectarse 
            $mail->setFrom($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
            $mail->addReplyTo($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
            $mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado
            $mail->addAttachment('albaranes/parte' . $id . '.pdf');         // Add attachments
            $message = $template;
            $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

            $mail->Subject = $mail_subject;
            $mail->msgHTML($message);
            if (!$mail->send()) {
                echo '<p style="color:red">No se pudo enviar el mensaje..';
                echo 'Error de correo: ' . $mail->ErrorInfo;
                echo "</p>";
            } else {
                echo '<p style="color:green">Su mensaje ha sido enviado!</p>';
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        };
    }
}
