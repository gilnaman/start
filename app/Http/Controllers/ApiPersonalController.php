<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Personal;
use Codedge\Fpdf\Fpdf\Fpdf;
use DB;

class ApiPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Personal::where('status','=',1)->get();
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
    }

    public function asistencia(){

        $periodo=2;



        

        $personal=Personal::where('status','=',1)->orderBy('noreferencia','ASC')->get();



        $pdf=new Fpdf('P','mm','A4');   

        foreach ($personal as $per) {

             $asist = DB::select("SELECT fechas.fecha,quincenas.nombre,quincenas.inicio,quincenas.fin,
                CheckEntrada(fechas.fecha,$per->noreferencia) as entrada,
                CheckSalida(fechas.fecha,$per->noreferencia) as salida
                FROM fechas INNER JOIN quincenas ON quincenas.id_periodo=fechas.id_periodo
                WHERE quincenas.id_periodo=$periodo");
             // return $asist;

            $pdf->AddPage();


            //ENCABEZADO

                    // $pdf->SetXY(10,8);
                    // $pdf->Image(public_path().'/imagenes/logos/logo.png', 8, 5, 30);//x, y, tamaño
                    $pdf->SetFont('Arial','B', 11);
                    
                    $pdf->Cell(190,8,utf8_decode('UNIVERSIDAD TECNOLÓGICA DEL CENTRO'),0,1,'C');
                    $pdf->Cell(190,8,utf8_decode(''),0,1,'C');
                    $pdf->Cell(190,8,utf8_decode('TARJETA DE REGISTRO'),0,1,'C');
                    $pdf->Ln(5);

                    $pdf->SetFont('Arial','', 10);
                    $pdf->Cell(10,8,utf8_decode('No: '),0,0,'L');
                    $pdf->Cell(20,8,utf8_decode($per->noreferencia),'B',0,'C');

                    $pdf->Cell(20,8,utf8_decode('GRUPO: '),0,0,'L');

                    if($per->clave_tipo==1)
                        $pdf->Cell(30,8,utf8_decode('ADMINISTRATIVO'),'B',0,'C');
                    else
                        $pdf->Cell(30,8,utf8_decode('DOCENTE'),'B',0,'C');

                    $pdf->Cell(25,8,utf8_decode('EMPLEADO: '),0,0,'R');
                    $pdf->Cell(85,8,utf8_decode("$per->nombre $per->appat $per->apmat"),'B',1,'C');
                    $pdf->Ln(5);

                    $pdf->Cell(190,8,utf8_decode('Hago constar que la presente tareta ha sido marcada por mí, en las horas de entrada señaladas;  corresponde al'),'LRT',1,'C');

                    $pdf->Cell(190,8,utf8_decode('registro de mi asistencia.'),'LRB',1,'L');
                    $pdf->Ln(5);

                    $pdf->Cell(45,8,utf8_decode('PERIODO DEL: '),0,0,'L');
                    $pdf->Cell(50,8,utf8_decode($asist[0]->inicio),'B',0,'C');
                     $pdf->Cell(45,8,utf8_decode('AL  : '),0,0,'L');
                    $pdf->Cell(50,8,utf8_decode($asist[0]->fin),'B',1,'C');
                    $pdf->Ln(10);

                    $pdf->Cell(20,6,utf8_decode(''),0,0,'L');
                    $pdf->Cell(30,6,utf8_decode('FECHA '),1,0,'L');
                    $pdf->Cell(30,6,utf8_decode('ENTRADA '),1,0,'L');
                    $pdf->Cell(30,6,utf8_decode('SALIDA '),1,0,'L');
                    $pdf->Cell(30,6,utf8_decode('HORAS '),1,0,'L');
                    $pdf->Cell(40,6,utf8_decode('OBSERVACIONES'),1,1,'L');


                
                
            
                foreach ($asist as $a) {
                    $pdf->Cell(20,6,utf8_decode(''),0,0,'L');
                    $pdf->Cell(30,6,utf8_decode($a->fecha),1,0,'L');
                    $pdf->Cell(30,6,utf8_decode($a->entrada),1,0,'L');
                    $pdf->Cell(30,6,utf8_decode($a->salida),1,0,'L');

                    $prod=strtotime($a->entrada);

                    $pdf->Cell(30,6,utf8_decode($prod),1,0,'L');

                    // $interval = date_diff(strtotime($a->entrada), strtotime($a->salida));
                    

                    // $pdf->Cell(30,6,utf8_decode($diff),1,0,'L');
                    $pdf->Cell(40,6,utf8_decode(''),1,1,'L');


                    


                }


                // IMPRESION DEL PIE DE PAGINA
                $pdf->Ln(10);

                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode(''),'B',0,'L');
                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode(''),'B',1,'L');

                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode('BR. SANDRA PECH'),0,0,'L');
                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode("$per->nombre $per->appat $per->apmat"),0,1,'L');

                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode('RECURSOS HUMANOS'),0,0,'L');
                $pdf->Cell(10,6,utf8_decode(''),0,0,'L');
                $pdf->Cell(70,6,utf8_decode('EMPLEADO'),0,0,'L');

            }
                

               

                

                





                $pdf->output();
        exit;

    }
}
