<!DOCTYPE html>
<html lang="en">
    <head>
        <title>{{ $invoice->name }}</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <style type="text/css" media="screen">
            html {
                font-family: sans-serif;
                line-height: 1.15;
                margin: 0;
            }

            .panel {
                margin-bottom: 20px;
                background-color: #fff;
                border: 1px solid transparent;
                border-radius: 4px;
                -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05);
                box-shadow: 0 1px 1px rgba(0,0,0,.05);
            }
            .panel-default {
                border-color: #ddd;
            }
            .panel-body {
                padding: 15px;
            }

            body {
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
                font-weight: 400;
                line-height: 1.5;
                color: #212529;
                text-align: left;
                background-color: #fff;
                font-size: 10px;
                margin: 36pt;
            }

            h4 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }

            h2 {
                margin-top: 0;
                margin-bottom: 0.5rem;
            }
            p {
                margin-top: 0;
                margin-bottom: 0rem;
            }

            strong {
                font-weight: bolder;
            }

            img {
                vertical-align: middle;
                border-style: none;
            }

            table {
                border-collapse: collapse;
            }

            th {
                text-align: inherit;
            }

            h4, .h4 {
                margin-bottom: 0.5rem;
                font-weight: 500;
                line-height: 1.2;
            }

            h4, .h4 {
                font-size: 1.0rem;
            }

            .table {
                width: 100%;
                margin-bottom: 0rem;
                color: #212529;
                
            }

            .table th,
            .table td {
                padding: 0.30rem;
                vertical-align: top;
                

            }
          

            .table.table-items{
                /*border-top: 10px solid #dee2e6;*/
                height:400px;
            }

            .table thead th {
                vertical-align: bottom;
               /* border-bottom: 2px solid #dee2e6;*/
            }

            .mt-5 {
                margin-top: 3rem !important;
            }

            .pr-0,
            .px-0 {
                padding-right: 0 !important;
            }

            .pl-0,
            .px-0 {
                padding-left: 0 !important;
            }

            .text-right {
                text-align: right !important;
            }

            .text-center {
                text-align: center !important;
            }

            .text-uppercase {
                text-transform: uppercase !important;
            }
            * {
                font-family: "Arial, Helvetica, sans-serif";
            }
            body, h1, h2, h3, h4, h5, h6, table, th, tr, td, p, div {
                line-height: 1.1;
            }
            .party-header {
                font-size: 1.5rem;
                font-weight: 400;
            }
            .total-amount {
                font-size: 12px;
                font-weight: 700;
            }
            .border-0 {
                border: none !important;
            }
            .cool-gray {
                color: #6B7280;             
            }
            .carvitur-name {
                font-size: 15px;
                
            }
            .border-td {
               border-bottom: 1px solid #dee2e6;
                padding: 0.50rem;
            }
            .border-top {
                margin-top: 0.5rem !important;
                border-top: 1px solid #dee2e6;
                padding: 0.50rem;
            }
            .body-items {
                height:800px;
                
            }
            
            pre {
            display: block;
            font-family: "Arial, Helvetica, sans-serif";
            white-space: pre;
            margin: 0em 0px;
            }
            
        </style>
    </head>

    <body>
        {{-- Header --}}
        
        <table class="table">
            <thead>
                
            </thead>
            <tbody>
                <tr class="text-center">
                    <td class="border-0">
                    @if($invoice->logo)
                        <img src="{{ $invoice->getLogo() }}" alt="logo" height="80" width="200">
                    @endif
                    </td>
                    <td >
                        @if($invoice->seller->name)
                            <p class="carvitur-name">
                                <strong>{{ $invoice->seller->name }}</strong>
                                
                            </p>
                        @endif
                        @if($invoice->seller->address)
                            <p class="seller-address">
                                {{ $invoice->seller->address }}
                            </p>
                        @endif
                       
                        @if($invoice->seller->address1)
                            <p class="seller-address">
                                {{ $invoice->seller->address1 }}
                            </p>
                        @endif
                        @if($invoice->seller->vat)
                            <p class="seller-vat">
                                {{ $invoice->seller->vat }}
                            </p>
                        @endif

                        @if($invoice->seller->phone)
                            <p class="seller-phone">
                                {{ $invoice->seller->phone }}
                            </p>
                        @endif

                        @foreach($invoice->seller->custom_fields as $key => $value)
                            <p class="seller-custom-field">
                                {{ $value }}
                            </p>
                        @endforeach
                    </td>
                    <td class="border-0 pl-0">
                    <div class="panel panel-default text-uppercase">
                        <div class="panel-body">
                            @if($invoice->status)
                                <h4 class="text-uppercase">
                                    <strong>{{ $invoice->status }}</strong>
                                </h4>
                            @endif
                            <div class="text-uppercase">
                                <p><h2><strong>DOCUMENTO DE COBRANZA</strong></h2></p>
                            </div>
                            <br>
                            <p><h2><strong>Nro. {{ $invoice->getSerialNumber() }}</strong></h2></p>                       
                            </div>
                        </div>  
                    </td>
                    
                </tr>

            </tbody>
        </table>
       
        
        {{-- Table --}}
    <div class="panel panel-default text-uppercase">
    <div class="panel-body">
    <table class="table">
     <tr>
            <td>
                <table class="table text-left">
                    <thead>
                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>                         
                                <p>
                                    <strong> SEÑORES : </strong>
                                    @if($invoice->buyer->name)
                                                {{ $invoice->buyer->name }}
                                            @endif       
                                </p>
                            </td>
                            <td>
                                <p> 
                                    <strong>FECHA DE EMISION : </strong> 
                                    @if($invoice->buyer->fecha)
                                        {{ $invoice->buyer->fecha }}
                                    @endif       
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>                         
                                <p>
                                    <strong> DIRECCION : </strong>
                                            @if($invoice->buyer->direccion)
                                                {{ $invoice->buyer->direccion }}
                                            @endif       
                                </p>
                            </td>
                            <td>                         
                                <p>
                                    <strong> CONDICION : </strong>
                                            @if($invoice->buyer->condicion)
                                                {{ $invoice->buyer->condicion }}
                                            @endif       
                                </p>
                            </td>
                        </tr>
                        <tr class="border-td">
                        <td>                         
                                <p>
                                    <strong>DNI / RUC: </strong>
                                            @if($invoice->buyer->ruc)
                                                {{ $invoice->buyer->ruc }}
                                            @endif       
                                </p>
                            </td>
                            <td>                         
                                <p>
                                    <strong> TELEFONO : </strong>
                                            @if($invoice->buyer->telefono)
                                                {{ $invoice->buyer->telefono }}
                                            @endif       
                                </p>
                            </td>
                         </tr>
                    </tbody>
                </table>
            </td>
        </tr>  
        <tr>
            <td> 
            <table class="table table-items">
                <thead>
                    <tr>
                        
                        <th scope="col" class="text-left border-0">DESCRIPCION DE SERVICIOS</th>                    
                        <th scope="col" class="text-right border-0">P.UNITARIO</th>
                        <th scope="col" class="text-right border-0">TOTAL</th>
                    
                    </tr>
                </thead>
                <tbody>
                    {{-- Items --}}
                    {{ $total =0; }}
                    @foreach($invoice->items as $item)
                    <tr>
                        <td class="text-left td-text" >                            
                            @if($item->title)
                            <pre>{{$item->title}}</pre>
                            @endif
                        </td>
                        <td class="text-right">
                            {{ $invoice->formatCurrency($item->price_per_unit) }}
                        </td>
                        <td class="text-right">{{ $invoice->formatCurrency($item->quantity) }}</td>
                    
                    </tr>
                    {{  $total = $item->quantity + $total }}
                    @endforeach
                
                </tbody>
            </table>
            </td>
        </tr>  
        <tr>
            <td> 
            <table class="table border-top">
                    <tr>
                        <td class="border-0">
                            @if($invoice->notes)
                                <p>
                                {!! $invoice->notes !!}
                                </p>
                            @endif
                        </td> 
                        <td scope="col" class="text-right">
                        <p>
                            <strong>TOTAL : {{ $invoice->formatCurrency($total);}}</strong>
                        </p>
                        </td>
                    </tr>
                    <tr>
                        <td class="border-0 text-center">
                                <p>
                                S.E.U.O.         
                                </p>
                            
                        </td> 
                        <td>
                        </td>
                    </tr>   
            </table>
            </td> 
            </tr>   
        <tr>
            <td> 
            <table class="table border-top">
                <tr>
                    <td class="border-0">
                     
                            <p>
                            RESOLUCION 067 - 93 EF/SUNAT (9-6-93)
                            </p>
                            <p>
                            CONSIDERAN COMPROBANTE DE PAGO LOS BOLETOS DE TRANSPORTE AEREO DE PASAJEROS
                            </p>
                            <p>
                           <strong> NO VALIDO PARA EFECTOS TRIBUTARIOS, SOLO PARA FINES DE COBRANZA</strong>
                            </p>
                        </td> 
                </tr>
            </table>
            </td> 
        </tr>  
        </table>
        </div>
        </div>   
        <script type="text/php">
            if (isset($pdf) && $PAGE_COUNT > 1) {
                $text = "Page {PAGE_NUM} / {PAGE_COUNT}";
                $size = 10;
                $font = $fontMetrics->getFont("Verdana");
                $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
                $x = ($pdf->get_width() - $width);
                $y = $pdf->get_height() - 35;
                $pdf->page_text($x, $y, $text, $font, $size);
            }

            function getTotalAmountInWords()
            {
                
            }

        </script>
    
    </body>
</html>
