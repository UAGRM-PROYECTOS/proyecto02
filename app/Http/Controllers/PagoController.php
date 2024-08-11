<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Utilidades\LogsController;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\PagoRequest;
use App\Models\DetalleOrden;
use App\Models\Orden;
use App\Models\Visit;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Return_;
date_default_timezone_set('America/La_Paz');
class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $pagos = Pago::paginate();

        return view('pago.index', compact('pagos'))
            ->with('i', ($request->input('page', 1) - 1) * $pagos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ordenPago($id): View
    {
        $visits = Visit::where(['page_name' => 'orden.pago'])->first();
        try {

            $orden = Orden::findOrFail($id);

            $detalleOrdens = DetalleOrden::where('orden_id', $orden->id)->paginate();
            $iduser= Auth::id();
            $cliente = User::findOrFail($iduser);

            return view('pago.create', compact('orden', 'detalleOrdens','cliente','visits'));

        } catch (ModelNotFoundException $e) {

            return Redirect::back()->with('error', 'No se pudo encontrar la orden.');
        }
    }

    public function create(): View
    {
        $pago = new Pago();
        $visits = Visit::where(['page_name' => 'pagos.create'])->first();
        return view('pago.create', compact('pago','visits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PagoRequest $request): RedirectResponse
    {
        Pago::create($request->validated());

        return Redirect::route('pagos.index')
            ->with('success', 'Pago created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        $pago = Pago::find($id);

        return view('pago.show', compact('pago'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id): View
    {
        $pago = Pago::find($id);

        return view('pago.edit', compact('pago'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PagoRequest $request, Pago $pago): RedirectResponse
    {
        $pago->update($request->validated());

        return Redirect::route('pagos.index')
            ->with('success', 'Pago updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        Pago::find($id)->delete();

        return Redirect::route('pagos.index')
            ->with('success', 'Pago deleted successfully');
    }


    /*ConsumirServicio***/

    public function RecolectarDatos(Request $request){

        try {

            $lcComerceID           = "d029fa3a95e174a19934857f535eb9427d967218a36ea014b70ad704bc6c8d1c";
            $lnMoneda              = 2; //bs
            $lnTelefono            = $request->tnTelefono;
            $lcNombreUsuario       = $request->tcRazonSocial;
            $lnCiNit               = $request->tcCiNit;
            $lcNroPago             = "UAGRM-SC-GRUPO18-SA" . rand(100000, 999999);
            $lnMontoClienteEmpresa = $request->tnMonto;
            $lcCorreo              = $request->tcCorreo;
            $lcUrlCallBack         = "http://tecnoweb.org.bo/inf513/grupo18sa/inventario/public/api/callback/";
            $lcUrlReturn           = "http://tecnoweb.org.bo/inf513/grupo18sa/inventario/public/";
            $laPedidoDetalle       = $request->taPedidoDetalle;
            $lcUrl                 = "";


            $loClient = new Client();

            if ($request->tnTipoServicio == 1) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/generarqrv2";
            } elseif ($request->tnTipoServicio == 2) {
                $lcUrl = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/realizarpagotigomoneyv2";
            }

            $laHeader = [
                'Accept' => 'application/json'
            ];

            $laBody   = [
                "tcCommerceID"          => $lcComerceID,
                "tnMoneda"              => $lnMoneda,
                "tnTelefono"            => $lnTelefono,
                'tcNombreUsuario'       => $lcNombreUsuario,
                'tnCiNit'               => $lnCiNit,
                'tcNroPago'             => $lcNroPago,
                "tnMontoClienteEmpresa" => $lnMontoClienteEmpresa,
                "tcCorreo"              => $lcCorreo,
                'tcUrlCallBack'         => $lcUrlCallBack,
                "tcUrlReturn"           => $lcUrlReturn,
                'taPedidoDetalle'       => $laPedidoDetalle
            ];

            $loResponse = $loClient->post($lcUrl, [
                'headers' => $laHeader,
                'json' => $laBody
            ]);

            // dd($loResponse, $loResponse->getBody()->getContents());

            $laResult = json_decode($loResponse->getBody()->getContents());
  
            if ($request->tnTipoServicio == 1) {

                $laValues = explode(";", $laResult->values)[1]; //0
                $laTransaccion = explode(";", $laResult->values)[0]; //1

                // dd($laValues, $laTransaccion);

                // 'orden_id', 'metodopagos_id', 'estado_id', 'nombre', 'monto_pago', 'fecha_pago'


                $pago = new Pago();
                $pago->orden_id = $request->orden_id;
                $pago->metodopagos_id = 4;
                $pago->estado_id = 1;
                $pago->transaccion = $laTransaccion;
                $pago->nombre = 'orden'.$request->orden_id;
                $pago->monto_pago = $lnMontoClienteEmpresa;
                $pago->save();

                // dd($pago);

                $orden = new OrdenController();
                $orden->ordenPedido($pago->orden_id);
                // actualizar estado de la orden

            //dd($laValues);
                $laQrImage = "data:image/png;base64," . json_decode($laValues)->qrImage;

            //dd($laQrImage);

                echo '<p class="text-center mb-4">' . $laTransaccion . '</p>';
                echo '<img src="' . $laQrImage . '" alt="Imagen base64">';
            } elseif ($request->tnTipoServicio == 2) {

                dd('pago 2 ');
                $csrfToken = csrf_token();

                echo '<h5 class="text-center mb-4">' . $laResult->message . '</h5>';
                echo '<p class="blue-text">Transacción Generada: </p><p id="tnTransaccion" class="blue-text">'. $laResult->values . '</p><br>';
                echo '<iframe name="QrImage" style="width: 100%; height: 300px;"></iframe>';
                echo '<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>';

                echo '<script>
                        $(document).ready(function() {
                            function hacerSolicitudAjax(numero) {
                                // Agrega el token CSRF al objeto de datos
                                var data = { _token: "' . $csrfToken . '", tnTransaccion: numero };

                                $.ajax({
                                    url: \'/consultar\',
                                    type: \'POST\',
                                    data: data,
                                    success: function(response) {
                                        var iframe = document.getElementsByName(\'QrImage\')[0];
                                        iframe.contentDocument.open();
                                        iframe.contentDocument.write(response.message);
                                        iframe.contentDocument.close();
                                    },
                                    error: function(error) {
                                        console.error(error);
                                    }
                                });
                            }

                            setInterval(function() {
                                hacerSolicitudAjax(' . $laResult->values . ');
                            }, 7000);
                        });
                    </script>';



            }
        } catch (\Throwable $th) {

            return $th->getMessage() . " - " . $th->getLine();
        }
    }


    public function ConsultarEstado(Request $request)
    {
        $lnTransaccion = $request->tnTransaccion;

        $loClientEstado = new Client();

        $lcUrlEstadoTransaccion = "https://serviciostigomoney.pagofacil.com.bo/api/servicio/consultartransaccion";

        $laHeaderEstadoTransaccion = [
            'Accept' => 'application/json'
        ];

        $laBodyEstadoTransaccion = [
            "TransaccionDePago" => $lnTransaccion
        ];

        $loEstadoTransaccion = $loClientEstado->post($lcUrlEstadoTransaccion, [
            'headers' => $laHeaderEstadoTransaccion,
            'json' => $laBodyEstadoTransaccion
        ]);

        $laResultEstadoTransaccion = json_decode($loEstadoTransaccion->getBody()->getContents());

        $texto = '<h5 class="text-center mb-4">Estado Transacción: ' . $laResultEstadoTransaccion->values->messageEstado . '</h5><br>';

        return response()->json(['message' => $texto]);
    }
    public function AccessPagoFacil(){

        $loUserAuth = curl_init();
        curl_setopt_array($loUserAuth,
        [
        CURLOPT_URL => "https://serviciostigomoney.pagofacil.com.bo/api/auth/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION =>
        CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "{ \n \"TokenService\": \" 51247fae280c20410824977b0781453df59fad5b23bf2a0d14e884482f91e09078dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5041c31d7cc6124be82afedc4fe926b806755efe678917468e31593a5f427c79cdf016b686fca0cb58eb145cf524f62088b57c6987b3bb3f30c2082b640d7c52907 \", \n \"TokenSecret\": \" 9E7BC239DDC04F83B49FFDA5 \"\n}",
        CURLOPT_HTTPHEADER => [ "Accept: */*", "Content-Type: application/json" ],
        ]);

        $laTokenAuth = curl_exec($loUserAuth);  //toUserAuth
        $laError = curl_error($loUserAuth);  //toUserAuth
        curl_close($loUserAuth);  //toUserAuth
        if ($laError) {
            echo "cURL Error #:" . $laError;
        } else { echo $laTokenAuth; }

        return view('pago.index');
    }

    public function AccessPagoFacilv2(){

        $loClient = new Client();
        $loUserAuth = $loClient->post( 'https://serviciostigomoney.pagofacil.com.bo/api/auth/login', [
            'headers' => [
                'Accept' => 'application/json'],
                'json' => array(
                    'TokenService' => "51247fae280c20410824977b0781453df59fad5b23bf2a0d14e884482f91e09078dbe5966e0b970ba696ec4caf9aa5661802935f86717c481f1670e63f35d5041c31d7cc6124be82afedc4fe926b806755efe678917468e31593a5f427c79cdf016b686fca0cb58eb145cf524f62088b57c6987b3bb3f30c2082b640d7c52907",
                    'TokenSecret' => "9E7BC239DDC04F83B49FFDA5" )
        ]);
        $laTokenAuth = json_decode($loUserAuth->getBody()->getContents());
        echo $laTokenAuth;

        //return $laTokenAuth;
    }

    public function UrlCallback()
    {
        // Campos del formulario del cliente
        $mapi = new Orden();

        $Venta = $_POST["PedidoID"];
        preg_match('/(\d+)$/', $Venta, $matches);
        $numeroPedido = isset($matches[1]) ? $matches[1] : null;
        $Fecha = $_POST["Fecha"];
        $nuevafecha = date("Y-m-d H:i:s", strtotime($Fecha));
        $Hora = $_POST["Hora"];
        $MetodoPago = $_POST["MetodoPago"];
        $Estado = $_POST["Estado"];
        $ingreso = true;

        try {
            // Aquí verifico si tienen datos todos los parámetros
            if (isset($numeroPedido, $Fecha, $Hora, $MetodoPago, $Estado)) {
                // Aquí verifico si existe la venta
                // El Mapi es un modelo que verifica si existe esa venta en la base de datos
                $laVentaobtenida = $mapi->obtenerventa($numeroPedido);

                if (!$laVentaobtenida) {
                    $arreglo = [
                        "error" => 1,
                        'status' => 1,
                        'message' => "No se encuentra la venta",
                        'values' => false
                    ];
                    $ingreso = false;
                }

                // Aquí verifico si existe el método de pago que se mandó
                $metodopagoobtenido = $mapi->verificarmetodopago($MetodoPago);

                if (!$metodopagoobtenido) {
                    $arreglo = [
                        'error' => 1,
                        'status' => 1,
                        'message' => "No se encuentra el método de pago",
                        'values' => false
                    ];
                    $ingreso = false;
                }

                // Si la variable $ingreso es true, significa que están bien los parámetros y puede realizar la consulta
                if ($ingreso) {
                    // Aquí llama al modelo Mapi y le manda los datos para cambiar el estado del pedido o venta
                    // Método pagarventa actualiza los datos del ESTADO de esa venta o pedido en la base de datos
                    $result = $mapi->pagarventa($numeroPedido, $nuevafecha, $metodopagoobtenido, $Estado);

                    if ($result) {
                        // Se guardó con éxito
                        $arreglo = [
                            "error" => 0,
                            'status' => 1,
                            'message' => "Pago realizado correctamente.",
                            'values' => true
                        ];
                    } else {
                        $arreglo = [
                            "error" => 1,
                            'status' => 1,
                            'message' => "No se pudo realizar el pago. Por favor, inténtelo de nuevo.",
                            'values' => false
                        ];
                    }
                }
            } else {
                $arreglo = [
                    "error" => 1,
                    'status' => 1,
                    'message' => "Faltan datos",
                    'values' => false
                ];
            }
        } catch (\Throwable $th) {
            $arreglo = [
                "error" => 1,
                'status' => 1,
                'messageSistema' => "[TRY/CATCH] " . $th->getMessage(),
                'message' => "No se pudo realizar el pago. Por favor, inténtelo de nuevo.",
                'values' => false
            ];
        }

        echo json_encode($arreglo);
    }



    public function CallBack(Request $request){
        // $estados = [
        //     '1' => 'en_proceso',
        //     '2' => 'pagado',
        //     '3' => 'revertido',
        //     '4' => 'anulado',
        // ];

        
    // se actualizara el estado de la venta
    // $loVenta = Venta::where('nota_venta', $request->PedidoID)->first();
    // $loVenta->estado_pago = $estados[$request->Estado];
    // $loVenta->hora_pago_confirmado = $request->Fecha;
    // $loVenta->save();

    // realizar factura
    // if ($loVenta->facturar == '1') {
    //     $requestFactura = new Request();
    //     $requestFactura->merge([
    //         'tnNotaVenta' => $loVenta->nota_venta,
    //     ]);
    //     // $requestFactura = response()->json([
    //     //     'tnNotaVenta' => $loVenta->id,
    //     // ]);
    //     $response = ConsumirServicioController::RealizarFacturacion($requestFactura);
    // }

    LogsController::guardarLog(true, "CallBack", $request->all());

    // $loPaquete = new  mPaquetePagoFacil(0, 1, "Success", true)

    $loPaquete = [
        'error' => 0,
        'status' => 1,
        'message' => 'Success',
        'values' => true
    ];
    return response()->json($loPaquete);

    }
}
