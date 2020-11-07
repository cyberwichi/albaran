<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\DetalleAviso;
use App\Aviso;
use App\Configuracion;
use App\Empleado;
use App\tbStockArt;
use Exception;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use App\tbContacto;

class AvisoController extends Controller
{
    public function delete($id)
    {
        DB::table('avisos')->where('id', '=', $id)->delete();
        DetalleAviso::where('aviso_id', '=', $id)->delete();
        return;
    }
    public function edit(Request $request, $id)
    {
        $aviso = Aviso::find($id);
        $aviso->contacto_id = $request->contacto_id;
        $aviso->fechaPrevista = $request->fechaPrevista;
        $aviso->comentario = $request->comentario;
        $aviso->empleado_id = $request->empleado_id;
        $aviso->valorar = $request->valorar;
        $aviso->franquiciado = $request->franquiciado;
        $aviso->correo = $request->correo;
        $aviso->update();
        return ($aviso);
    }

    public function new(Request $request)
    {
        if ($request->id == 0) {
            $aviso = new Aviso();
            $aviso->contacto_id = $request->clientid;
            $aviso->fechaPrevista = $request->fechaPrevista;
            $aviso->comentario = $request->observaciones;
            $aviso->franquiciado = $request->franquiciado;
            $aviso->valorar = $request->valorar;
            $aviso->correo = $request->correo;
            $aviso->empleado_id = $request->empleado;
            $aviso->save();
            $valortbcontacto = tbContacto::where('id', $aviso->contacto_id)->get();
            if ($request->empleado) {
                $config = Configuracion::first();
                $empleado = Empleado::find($request->empleado);
                $mail_username = $config->email; //Correo electronico saliente ejemplo: tucorreo@gmail.com
                $mail_userpassword = $config->password; //Tu contraseña de gmail
                $mail_addAddress = $empleado->email; //correo electronico que recibira el mensaje
                $template = '
                    <p> Nuevo aviso generado</p>
                    <p> Cliente : <strong> ' . $valortbcontacto[0]->Nombre . ' </strong> </p>
                    <p> Trabajo a realizar : <strong> ' . $aviso->comentario . ' </strong> </p>
                    <br> 
                    <p> Aviso  numero <strong> ' . $aviso->id . ' </strong> </p>
                    <br>
                    <p> Fecha prevista realizacion  <strong> ' .  $aviso->fechaPrevista . ' </strong> </p>
                    <br> ';
                /*Inicio captura de datos enviados por $_POST para enviar el correo */
                $mail_setFromEmail = $mail_username;
                $mail_setFromName = $mail_username;
                $mail_subject = 'Nuevo aviso recibido numero' . $aviso->id;
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
                    $mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
                    $mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
                    $mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
                    $mail->Password = $mail_userpassword;         // Tu contraseña de gmail
                    $mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
                    $mail->Port = 25;                          // Puerto TCP  para conectarse 
                    $mail->setFrom($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
                    $mail->addReplyTo($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
                    $mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado         // Add attachments
                    $message = $template;
                    $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

                    $mail->Subject = $mail_subject;
                    $mail->msgHTML($message);
                    if (!$mail->send()) {
                        echo '<p style="color:red">No se pudo enviar el mensaje..';
                        echo 'Error de correo: ' . $mail->ErrorInfo;
                        echo "</p>";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                };
            }

            foreach ($request->listaarticulos as $key => $linea) {
                $detalle = new DetalleAviso();
                $detalle->aviso_id = $aviso->id;
                $detalle->articulo_id = $linea['articuloId'];
                $detalle->articulo_nombre = $linea['articuloNombre'];
                $detalle->cantidad = $linea['articuloCantidad'];
                $detalle->precio = $linea['articuloPrecio'];
                $detalle->save();
            };
            $config = Configuracion::first();
            $mail_username = $config->email; //Correo electronico saliente ejemplo: tucorreo@gmail.com
            $mail_userpassword = $config->password; //Tu contraseña de gmail
            $mail_addAddress = $config->correo_tecnicos; //correo electronico que recibira el mensaje
            $template = '
                    <p> Nuevo aviso asignado</p>
                    <br>
                    <p> Cliente : <strong> ' . $valortbcontacto[0]->Nombre . ' </strong> </p>
                    <p> Trabajo a realizar : <strong> ' . $aviso->comentario . ' </strong> </p>
                    <br> 
                    <p> Aviso  numero <strong> ' . $aviso->id . ' </strong> </p>
                    <br>
                    <p> Fecha prevista realizacion  <strong> ' .  $aviso->fechaPrevista . ' </strong> </p>
                    <br> ';
            /*Inicio captura de datos enviados por $_POST para enviar el correo */
            $mail_setFromEmail = $mail_username;
            $mail_setFromName = $mail_username;
            $mail_subject = 'Nuevo aviso recibido numero' . $aviso->id;
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
                $mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
                $mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
                $mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
                $mail->Password = $mail_userpassword;         // Tu contraseña de gmail
                $mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
                $mail->Port = 25;                          // Puerto TCP  para conectarse 
                $mail->setFrom($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
                $mail->addReplyTo($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
                $mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado         // Add attachments
                $message = $template;
                $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

                $mail->Subject = $mail_subject;
                $mail->msgHTML($message);
                if (!$mail->send()) {
                    echo '<p style="color:red">No se pudo enviar el mensaje..';
                    echo 'Error de correo: ' . $mail->ErrorInfo;
                    echo "</p>";
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            };
        } else {
            $aviso = Aviso::find($request->id);
            $aviso->contacto_id = $request->clientid;
            $aviso->fechaPrevista = $request->fechaPrevista;
            $aviso->comentario = $request->observaciones;
            $aviso->terminada = $request->terminada;
            $aviso->valorar = $request->valorar;

            $aviso->franquiciado = $request->franquiciado;
            $aviso->correo = $request->correo;
            $valortbcontacto = tbContacto::where('id', $aviso->contacto_id)->get();
            if ($aviso->empleado_id !== $request->empleado) {
                $config = Configuracion::first();
                $empleado = Empleado::find($request->empleado);
                $mail_username = $config->email; //Correo electronico saliente ejemplo: tucorreo@gmail.com
                $mail_userpassword = $config->password; //Tu contraseña de gmail
                $mail_addAddress = $empleado->email; //correo electronico que recibira el mensaje
                $template = '
                    <p> Nuevo aviso asignado</p>
                    <br>
                    <p> Cliente : <strong> ' . $valortbcontacto[0]->Nombre . ' </strong> </p>
                    <br>
                    <p> Aviso  numero <strong> ' . $aviso->id . ' </strong> </p>
                    <br>
                    <p> Fecha prevista realizacion  <strong> ' .  $aviso->fechaPrevista . ' </strong> </p>
                    <br> ';
                /*Inicio captura de datos enviados por $_POST para enviar el correo */
                $mail_setFromEmail = $mail_username;
                $mail_setFromName = $mail_username;
                $mail_subject = 'Nuevo aviso recibido numero' . $aviso->id;
                try {
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();                            // Establecer el correo electrónico para utilizar SMTP
                    $mail->Host = 'smtp.gmail.com';             // Especificar el servidor de correo a utilizar 
                    $mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
                    $mail->Username = $mail_username;          // Correo electronico saliente ejemplo: tucorreo@gmail.com
                    $mail->Password = $mail_userpassword;         // Tu contraseña de gmail
                    $mail->SMTPSecure = 'tls';                  // Habilitar encriptacion, `ssl` es aceptada
                    $mail->Port = 25;                          // Puerto TCP  para conectarse 
                    $mail->setFrom($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
                    $mail->addReplyTo($mail_setFromEmail, $mail_setFromName); //Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
                    $mail->addAddress($mail_addAddress);   // Agregar quien recibe el e-mail enviado         // Add attachments
                    $message = $template;
                    $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

                    $mail->Subject = $mail_subject;
                    $mail->msgHTML($message);
                    if (!$mail->send()) {
                        echo '<p style="color:red">No se pudo enviar el mensaje..';
                        echo 'Error de correo: ' . $mail->ErrorInfo;
                        echo "</p>";
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                };
            }
            $aviso->empleado_id = $request->empleado;
            $aviso->update();
            if ($request->listaarticulos) {
                $detalle = DetalleAviso::where('aviso_id', $request->id);
                $detalle->delete();
                foreach ($request->listaarticulos as $key => $linea) {
                    $detalle = new DetalleAviso();
                    $detalle->aviso_id = $aviso->id;
                    $detalle->articulo_id = $linea['articulo_id'];
                    $detalle->articulo_nombre = $linea['articulo_nombre'];
                    $detalle->cantidad = $linea['cantidad'];
                    $detalle->precio = $linea['precio'];
                    $detalle->save();
                };
            }
        }
        return $aviso->id;
    }
    public function  index()
    {
        $avisos = Aviso::orderBy('Id', 'desc')->with('tbContacto')->with('Empleado')->get();
        return ($avisos);
    }
    public function porid($id)
    {
        $aviso = Aviso::where('id', $id)->with('tbContacto')->with('Empleado')->get();
        return ($aviso);
    }
    public function porcliente($id)
    {
        $aviso = Aviso::where('contacto_id', $id)->orderBy('Id', 'desc')->with('tbContacto')->with('empleado')->get();
        return json_encode($aviso);
    }
    public function finalizado($id)
    {
        Aviso::find($id)->update(['terminada' => "1"]);
        return "ok";
    }
    public function detalles($id)
    {
        $detalles = DetalleAviso::where('aviso_id', $id)->with('articulo.referencias')->get();
        return json_encode($detalles);
    }
    public function porempleado($id)
    {
        $avisos = Aviso::where('empleado_id', $id)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
    public function noterminados()
    {
        $avisos = Aviso::where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
    public function noterminadosporempleado($id)
    {
        $avisos = Aviso::where('empleado_id', $id)->where('terminada', null)->orderBy('Id', 'desc')->with('empleado')->with('tbContacto')->get();
        return json_encode($avisos);
    }
    public function asignarempleado($id)
    {
    }
}
