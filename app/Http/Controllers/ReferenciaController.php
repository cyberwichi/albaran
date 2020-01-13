<?php

namespace App\Http\Controllers;

use App\Referencia;

use Illuminate\Http\Request;

class ReferenciaController extends Controller
{

    public function articulosporreferencia($referencia)
    {
        $articulos = Referencia::where('referencia', 'LIKE','%'.$referencia.'%')->orderBy('articulo_id')->get();
        $auxarticulo=[];
        $auxarticulo_id=0;
        foreach ($articulos as $index => $articulo) {
            if ($auxarticulo_id==0) {
                $auxarticulo_id= $articulo->articulo_id;
                $auxarticulo[0] = Referencia::where('articulo_id',  $auxarticulo_id)->with('tbArticulo')->orderBy('articulo_id')->latest()->first();
            } else if ($auxarticulo_id != $articulo->articulo_id) {
                array_push($auxarticulo, Referencia::where('articulo_id',  $auxarticulo_id)->with('tbArticulo')->orderBy('articulo_id')->latest()->first());
                $auxarticulo_id=$articulo->articulo_id;
            }
        }
        return $auxarticulo;
    }
    public function referenciaid($id)
    {
        $referencia=Referencia::where('articulo_id',  $id)->with('tbArticulo')->orderBy('articulo_id')->latest()->first();
        return $referencia;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articulos = Referencia::with('tbArticulo')->orderBy('articulo_id')->get();
        return $articulos;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $referencia = Referencia::where([['referencia', '=', $request->referencia], ['articulo_id', '=', $request->articulo_id]])
            ->get();
        if (count($referencia)) {
            return "Referencia ya existente en este articulo No se ha almacenado ningun dato nuevo";
        } else {
            $referencia = new Referencia;
            $referencia->referencia = $request->referencia;
            $referencia->articulo_id = $request->articulo_id;
            $referencia->save();
            return 'Referencia registrada correctamente';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $referencia = Referencia::where([['referencia', '=', $request->referencia], ['articulo_id', '=', $request->articulo_id]])
            ->get();
        if (count($referencia)) {
            return (["0", $referencia]);
        } else {
            $referencia = Referencia::find($id);
            $referencia->referencia = $request->referencia;
            $referencia->save();
            return (["1", $referencia]);
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Referencia::destroy($id);
    }
}
