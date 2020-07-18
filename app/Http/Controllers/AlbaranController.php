<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Albaran;
use App\Aviso;
use App\DetalleAlbaran;
use App\tbStockArt;
use App\Albaranmaquina;
use App\Configuracion;
use App\tbContacto;
use App\Empleado;
use App\Maquina;
use App\Referencia;
use PhpParser\Node\Stmt\Catch_;
use PhpParser\Node\Stmt\TryCatch;
use Barryvdh\DomPDF\Facade as PDF;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use stdClass;

class AlbaranController extends Controller
{
    public function index()
    {
        $albaranes = Albaran::orderBy('Id', 'desc')->with('detallealbaran')->with('albaranmaquina')->get();
        return json_encode($albaranes);
    }
    public function porcliente($id)
    {
        $avisos = Aviso::where('contacto_id', $id)->get();
        $albaranes = [];
        foreach ($avisos as $key => $aviso) {
            $albaranes[$key] = Albaran::where('aviso_id', $aviso->id)->orderBy('id', 'desc')->with('detallealbaran')->with('albaranmaquina')->get();
        }
        return json_encode($albaranes);
    }
    public function poraviso($id)
    {
        $albaranes = Albaran::where('aviso_id', $id)->with('albaranmaquina')->orderBy('aviso_id', 'desc')->get();
        return json_encode($albaranes);
    }
    public function new(Request $request)
    {
        if ($request->terminada == true) {
            Aviso::find($request->aviso_id)->update(['terminada' => "1"]);
        }
        $albaran = new  Albaran();
        $albaran->aviso_id = $request->aviso_id;
        $albaran->observaciones = $request->observaciones;
        $albaran->firma_cliente = $request->firma_cliente;
        $albaran->firma_empleado = $request->firma_empleado;
        $albaran->trabajos=$request->trabajos;
        $albaran->save();
        foreach ($request->listaarticulos as $key => $linea) {
            $detalle = new DetalleAlbaran();
            $detalle->albaran_id = $albaran->id;
            $detalle->articulo_id = $linea['articulo_id'];
            $detalle->articulo_nombre = $linea['articulo_nombre'];
            $detalle->cantidad = $linea['cantidad'];
            $detalle->precio = $linea['precio'];
            $detalle->save();            
        }
        foreach ($request->listamaquinas as $key => $linea) {
            $maquina = new AlbaranMaquina();
            $maquina->albaran_id = $albaran->id;
            $maquina->maquina_id = $linea['id'];
            $maquina->referencia = $linea['referencia'];
            $maquina->save();
        }
        $id = $albaran->id;
        $albaran = Albaran::where('id', $id)->with('aviso')->with('detallealbaran')->with('albaranmaquina')->get();
        $aviso = Aviso::find($albaran[0]->aviso_id);
        $cliente = tbContacto::find($aviso->contacto_id);
        if (isset($aviso->empleado_id)) {
            $empleado = Empleado::findOrFail($aviso->empleado_id);
        } else {
            $empleado = new Empleado();
            $empleado->name = "Sin Asignar";
        }

        $maquina = [];
        $referencias = [];
        if ($albaran[0]->albaranmaquina !== []) {
            foreach ($albaran[0]->albaranmaquina as $maq) {
                $maquina[$maq->maquina_id] = Maquina::find($maq->maquina_id);
            }
        }
        if ($albaran[0]->detallealbaran !== []) {
            foreach ($albaran[0]->detallealbaran as $det) {
                $aux = Referencia::where('articulo_id', $det->articulo_id)->latest()->first();
                $referencias[$det->articulo_id] = $aux;                
            }
        }



        $pdf = PDF::loadView('pdf/pdf', compact('albaran', 'cliente', 'empleado', 'maquina', 'referencias'));
        $pdf->save('albaranes/parte' . $id . '.pdf');

        /*Configuracion de variables para enviar el correo*/
        $config = Configuracion::first();
        $mail_username = $config->email; //Correo electronico saliente ejemplo: tucorreo@gmail.com
        $mail_userpassword = $config->password; //Tu contraseña de gmail+
        $mail_addAddress = explode(";", $cliente->Email); //correo electronico que recibira el mensaje
        $template = $config->asunto . ' 
             <br>
             <p> Parte numero <strong> ' . $id . ' </strong> </p>
            <p> Gracias por su confianza</p>
            <br> ' . $config->proteccion;

        /*Inicio captura de datos enviados por $_POST para enviar el correo */
        $mail_setFromEmail = $mail_username;
        $mail_setFromName = $mail_username;
        $txt_message = $mail_username;
        $mail_subject = 'Corrreo de envio de parte de trabajo numero' . $id;
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
            foreach($mail_addAddress as $iten) {
                $mail->addAddress($iten);   // Agregar quien recibe el e-mail enviado
            }           

            $mail->addAttachment('albaranes/parte' . $id . '.pdf');         // Add attachments
            $mail->addCC($config->correo_admin);
            $mail->addCC($config->correo_tecnicos);
            if ($empleado->email <> '') {
                $mail->addCC($empleado->email);
            }
            $message = $template;
            $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

            $mail->Subject = $mail_subject;
            $mail->msgHTML($message);
            if (!$mail->send()) {
                echo '<p style="color:red">No se pudo enviar el mensaje..';
                echo 'Error de correo: ' . $mail->ErrorInfo;
                echo "</p>";
            } else {
                return $id;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        };
    } 
    public function delete($id)
    {
        Albaran::where('id', '=', $id)->delete();
        DetalleAlbaran::where('albaran_id', '=', $id)->delete();
        return;
    }
    public function porid($id)
    {
        $albaran = Albaran::where('id', $id)->with('detallealbaran')->with('albaranmaquina')->get();
        return ($albaran);
    }
    public function detalleporid($id)
    {
        $detalles = DetalleAlbaran::where('albaran_id', '=', $id)->get();
        return json_encode($detalles);
    }
}
