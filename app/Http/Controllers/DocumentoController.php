<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use \App\Models\Cliente;
use \App\Models\Documento;
use \App\Models\Servicios;
use LaravelDaily\Invoices\Invoice as InvoiceDocument;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;
use Luecano\NumeroALetras\NumeroALetras;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $documentos=Documento::join("clientes","clientes.id","=","documentos.cliente_id")
        ->select('clientes.razonsocial','clientes.documento','documentos.*')->get();
        return view("documentos.index", compact("documentos")); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        //$documento = new Documento();        
        $Ultimo=Documento::select('*')->latest()->first();
        $FechaEmision = date("Y-m-d");
        $Estado = "REGISTRADO";
        $Condicion = "CONTADO";
             
        if (is_null($Ultimo))
        {
            $Serie = "001";
            $Valor = "000000";
        }
       else{
            $Serie = $Ultimo->serie;
            $Valor = $Ultimo->numero;
       }
                
        $Valor=(int)$Valor+1;
        $Numero = str_pad($Valor, 6, "0", STR_PAD_LEFT);

        return view("documentos.create",compact('FechaEmision','Estado','Serie','Numero','Condicion','Estado'));
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
        if ($request->listadoServicios !=null)
        {
            $documento = new Documento();        
            $documento  ->cliente_id = $request->cliente_id;
            $documento  ->serie = $request->serie;
            $documento  ->numero = $request->numero;
            $documento  ->fecha_emision = $request->fecha_emision;
            $documento  ->condicion = $request->condicion;
            $documento  ->moneda = $request->moneda;
            $documento  ->estado = $request->estado;
            $documento->save(); 
            $latest_id = $documento->id;

            $Listaservicios = json_decode($request->listadoServicios);
            for ($i=0; $i < count($Listaservicios); $i++) {
                $servicios = new Servicios();
                $servicios->documento_id= $latest_id;
                $servicios->descripcion = $Listaservicios[$i]->descripcion_servicio;
                $servicios->preciounitario = $Listaservicios[$i]->preciounitario;
                $servicios->subtotal = $Listaservicios[$i]->total;
                $servicios->save(); 
            }
        $mensaje = "El comprobante fue cargado correctamente."; 
        
         return redirect("/documentos");
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
        $documento = Documento::findOrFail($id);
        $cliente = Cliente::findOrFail($documento->cliente_id);
        $documento_id = $documento->id;
        $servicios = Servicios::where("documento_id","=",$documento->id)->get();
        $total =0;
        for ($i=0; $i < count($servicios); $i++) {
            
            $total = $servicios[$i]->subtotal + $total;
            
        }
        $formatter = new NumeroALetras();
        $letras = 'SOLES';
        if (($documento->moneda) == "USD")
            
                $letras = 'DOLARES AMERICANOS';
            
        $TotalNumero = $formatter->toInvoice($total, 2, $letras);

        return view("documentos.view", compact("documento","cliente","servicios","total","TotalNumero")); 
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
        $documento = Documento::findOrFail($id);
        $cliente = Cliente::findOrFail($documento->cliente_id);
        $documento_id = $documento->id;
        $servicios = Servicios::where("documento_id","=",$documento->id)->get();
        $total =0;
        for ($i=0; $i < count($servicios); $i++) {
            
            $total = $servicios[$i]->subtotal + $total;
            
        }

        $seller = new Party([
            'name' => 'CARVITUR E.I.R.L',
            'custom_fields' => [
                'address' => 'BI.B Urbanización Residencial Asís Mz.D',
                'address1' => '- Lote 1 - Dpto. 806 - Zona B - Piso 08',
                'address2' =>  'Sachaca - Arequipa - Arequipa',
                'phone' => 'Cel.:958316677',
                'email' => 'administracion@carvitur.com.pe',
                'email1' => 'contabilidad@carvitur.com.pe',
            ],
        ]);
        $newDate = date("d/m/Y", strtotime($documento->fecha_emision));
        $customer = new Buyer([
            'name'               => $cliente->razonsocial,
            'fecha'              => $newDate,
            'direccion'          => $cliente->direccion,
            'condicion'          => $documento->condicion,
            'ruc'                => $cliente->documento,
            'telefono'           => $cliente->telefono,
            'custom_fields' => [
                'mail' =>  'ddd',
            ],
        ]);


        $items = collect();
        
        $servicios->each(function ($servicios) use (&$items) {
           
            $item = new InvoiceItem();
            $item->title($servicios->descripcion)
                ->pricePerUnit($servicios->preciounitario)
                ->quantity($servicios->subtotal);
                $items->push($item);
                
        });

        $formatter = new NumeroALetras();
        $letras = 'NUEVOS SOLES';
        if (($documento->moneda) == "USD")
            
                $letras = 'DOLARES AMERICANOS';
            
        $TotalNumero = $formatter->toInvoice($total, 2, $letras);

        
        $invoiceDocument = InvoiceDocument::make('documento')
        ->status('R.U.C. N° 20498225536')
        ->series($documento->serie)
        ->sequence((int)$documento->numero)
        ->serialNumberFormat('{SERIES}-{SEQUENCE}')
        ->seller($seller)
        ->buyer($customer)
        ->currencySymbol($documento->moneda) 
        ->currencyCode('USD')
        ->currencyFormat('{SYMBOL} {VALUE}')
        ->currencyThousandsSeparator(',')
        ->currencyDecimalPoint('.')
        ->addItems($items->toArray()) 
        ->notes($TotalNumero)
      
        ->logo(public_path('vendor/invoices/carvisur_logo.jpeg'));

        return $invoiceDocument->stream();
       //return $invoiceDocument->toHtml();


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
            $documento = Documento::findOrFail($id);        
            $documento->estado = "ANULADO";
            $documento->save();
            
       
    }

    public function print($id)
    {
        //
        $documento = Documento::findOrFail($id);
        $cliente = Cliente::findOrFail($documento->cliente_id);
        $documento_id = $documento->id;
        $servicios = Servicios::where("documento_id","=",$documento->id)->get();
        $total =0;
        for ($i=0; $i < count($servicios); $i++) {
            
            $total = $servicios[$i]->subtotal + $total;
            
        }

        $seller = new Party([
            'name' => 'CARVITUR E.I.R.L',
            'custom_fields' => [
                'address' => 'BI.B Urbanización Residencial Asís Mz.D',
                'address1' => '- Lote 1 - Dpto. 806 - Zona B - Piso 08',
                'address2' =>  'Sachaca - Arequipa - Arequipa',
                'phone' => 'Cel.:958316677',
                'email' => 'administracion@carvitur.com.pe',
                'email1' => 'contabilidad@carvitura.com.pe',
            ],
        ]);
        $newDate = date("d/m/Y", strtotime($documento->fecha_emision));
        $customer = new Buyer([
            'name'               => $cliente->razonsocial,
            'fecha'              => $newDate,
            'direccion'          => $cliente->direccion,
            'condicion'          => $documento->condicion,
            'ruc'                => $cliente->documento,
            'telefono'           => $cliente->telefono,
            'custom_fields' => [
                'mail' =>  'ddd',
            ],
        ]);


        $items = collect();
        
        $servicios->each(function ($servicios) use (&$items) {
           
            $item = new InvoiceItem();
            $item->title($servicios->descripcion)
                ->pricePerUnit($servicios->preciounitario)
                ->quantity($servicios->subtotal);
                $items->push($item);
        });

        $formatter = new NumeroALetras();
        $letras = 'SOLES';
        if (($documento->moneda) == "USD")
            
                $letras = 'DOLARES AMERICANOS';
            
        $TotalNumero = $formatter->toInvoice($total, 2, $letras);

        
        $invoiceDocument = InvoiceDocument::make('receipt')
        ->status('R.U.C. N° 20498225536')
        ->series($documento->serie)
        ->sequence($documento->numero)
        ->serialNumberFormat('{SERIES}-{SEQUENCE}')
        ->seller($seller)
        ->buyer($customer)
        ->currencySymbol($documento->moneda) 
        ->currencyCode('USD')
        ->currencyFormat('{SYMBOL} {VALUE}')
        ->currencyThousandsSeparator(',')
        ->currencyDecimalPoint('.')
        ->addItems($items->toArray()) 
        ->notes($TotalNumero)
      
        ->logo(public_path('vendor/invoices/carvisur_logo.jpeg'));

        return $invoiceDocument->stream();


    }

}
