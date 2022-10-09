<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \App\Models\Cliente;


class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //Auth::user()->authorizeRoles(['user', 'administrador', 'operador']);
        $clientes=Cliente::all();    
            
        return view("clientes.index", compact("clientes"));  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //Auth::user()->authorizeRoles(['user', 'administrador', 'operador']);        
        return view("clientes.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $cliente = new Cliente();        
        $cliente ->razonsocial = $request->razonsocial;
        $cliente ->direccion = $request->direccion;
        $cliente ->documento = $request->documento;
        $cliente ->telefono = $request->telefono;
        
        
        $cliente->save();        

        return redirect("/clientes");
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
        $cliente = Cliente::findOrFail($id);
        return view("clientes.view", compact("cliente")); 
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
        $cliente = Cliente::findOrFail($id);
        return view("clientes.edit", compact("cliente")); 
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
        //
        $cliente = Cliente::findOrFail($id);        
        $cliente ->razonsocial = $request->razonsocial;
        $cliente ->direccion = $request->direccion;
        $cliente ->documento = $request->documento;
        $cliente ->telefono = $request->telefono;

        $cliente->update();
      
        return redirect("/clientes");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $cliente = Cliente::findOrFail($id);
        $cliente ->delete(); 
    }

    public function buscar(Request $request)
    {
        //
        $texto = $request->texto;
		$clientes = Cliente::where('razonsocial', 'LIKE', '%'.$texto.'%')
        ->get();
        return Response()->json([
			'clientes' => $clientes
		]);
    }

}


