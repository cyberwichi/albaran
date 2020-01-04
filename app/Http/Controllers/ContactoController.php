<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbContacto;
use Illuminate\Support\Facades\DB;

class ContactoController extends Controller
{
    public function index()
    {
        $contactos = tbContacto::get();
        return json_encode($contactos);
    }
    public function porid($id)
    {
        $articulo = tbContacto::find($id);
        return json_encode($articulo);
    }
    public function new(Request $request)
    {
        $contacto = new tbContacto();
        $ultimoContacto = tbContacto::orderBy('Id', 'DESC')->limit(1)->first();
        $contacto->Nombre = $request->Nombre;
        $contacto->Direccion = $request->Direccion;
        $contacto->Id = ($ultimoContacto->Id) + 1;
        $contacto->AutoId = ($ultimoContacto->Id) + 1;
        $contacto->Nif = $request->Nif;
        $contacto->Telefono = $request->Telefono;
        $contacto->Email = $request->Email;

        $contacto->save();
        return $contacto;
    }
    public function delete($id)
    {
        DB::table('tbcontacto')->where('Id', '=', $id)->delete();
        return;
    }
    public function edit(Request $request, $id)
    {
        DB::table('tbcontacto')
            ->where('Id', $id)
            ->update(array('Nombre' => $request->Nombre, 'Direccion' => $request->Direccion, 'Nif' => $request->Nif, 'Telefono' => $request->Telefono, 'Email' => $request->Email));

        return;
    }
    public function pornombre($dd){
        $contactos = tbContacto::where('Nombre', 'LIKE', '%' . $dd . '%')->get();
        return response()->json($contactos);
    }

}
