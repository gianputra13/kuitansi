<?php

namespace App\Http\Controllers;

// use notify;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Payments::orderBy('created_at', 'DESC')->simplePaginate(7);
        $dataAll = Payments::all();
        return view('index', compact(["data", "dataAll"]));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.request.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $data = $request->all();
        // dd($data);

        $tanggal = $data['payment_date'];
        $carbonDate = Carbon::parse($tanggal);
        $monthNumber = $carbonDate->format('n');
        
        $lastNo = Payments::where('month', $monthNumber)
        ->max('no');

        
        if ($lastNo) {
            $no = $lastNo + 1;
        } else {
            $no = 1;
        }
        
        $data['no'] = $no;
        $tahun = date('Y');
        $month = Carbon::parse($tanggal)->format('m');
        $data['month'] = $month;
        $data['code'] = sprintf('%03d', $no) . '/KU/UPS-FAT/' . $month . '/' . $tahun;

        // dd($data['no']);
        $kuitansi = new Payments();
        $kuitansi->no = $data['no'];
        $kuitansi->code = $data['code'];
        $kuitansi->month = $data['month'];
        $kuitansi->received_from = $data['received_from'];
        $kuitansi->for_payment = $data['for_payment'];
        $kuitansi->type_payment = $data['type_payment'];
        $kuitansi->payment_number = $data['payment_number'];
        $kuitansi->save();

        $id = $kuitansi->id;

        // format nominal
        $formatter = new \NumberFormatter('id', \NumberFormatter::SPELLOUT);
        $data['payment_number_text'] = ucfirst($formatter->format($data['payment_number']) ." ". "rupiah");
        $data['payment_number'] = 'Rp. ' . number_format($data['payment_number'], 0, ',', '.');


        // Generate PDf
        $pdf = new Dompdf();
        $imagePath = public_path('images/logo.png');
        $imageData = file_get_contents($imagePath);
        $base64Image = 'data:image/png;base64,' . base64_encode($imageData);
        $content = view('pages.request.pdf', compact('data', 'base64Image'))->render();
        $stylesheet = '
            <style>
                @page { margin: 20px; }
                body { margin: 50px; }
            </style>
        ';
        $html = $stylesheet . $content;

        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');
        $pdf->loadHtml($html);

        // render pdf
        $pdf->render();

        // Logo
        $signatureImage = public_path('images/logo.png');
        setlocale(LC_TIME, 'id_ID');
        
        $date = Carbon::createFromFormat('Y-m-d', $data['payment_date'])->isoFormat('D MMMM Y');
        $imageX = 40;
        $imageY = 140;
        $imageWidth = 90;
        $textY = 60;
        $textX = $imageX + $imageWidth + 10;
        
        // Header kiri
        $pdf->getCanvas()->image($signatureImage, $imageX, $imageY, $imageWidth, 0, 'PNG');
        $pdf->getCanvas()->text($textX, $textY, 'PT. Unitedtronik Perkasa Sejahtera', null, 10, [0, 0, 0]);
        $pdf->getCanvas()->text($textX, $textY + 15, 'Jl. Batan Selatan no. 54', null, 10, [0, 0, 0]);
        $pdf->getCanvas()->text($textX, $textY + 30, 'Semarang Jawa Tengah', null, 10, [0, 0, 0]);
        $pdf->getCanvas()->text($textX, $textY + 45, 'Kode pos: 50134', null, 10, [0, 0, 0]);
        $pdf->getCanvas()->text($textX, $textY + 60, 'Telp: (024) 3517625', null, 10, [0, 0, 0]);

        // Header kanan
        $pdf->getCanvas()->text(430, 75 , 'KUITANSI', null, 12, [0, 0, 0]);
        $pdf->getCanvas()->line(430, 90, 430 + 60 , 90, [0, 0, 0], 1, ['dashed'], 'round');
        $pdf->getCanvas()->text(433, 92 , 'RECEIPT', null, 12, [0, 0, 0]);
        $pdf->getCanvas()->text(380, 112 , 'No : ' . $data['code'], 'Helvetica-Bold', 12, [0, 0, 0]);

        // DATE
        $pdf->getCanvas()->text(340 + 20, $pdf->getCanvas()->get_height() - 340, 'Semarang, '. $date, "Arial", 13, [0, 0, 0]);
        $pdf->getCanvas()->text(340, $pdf->getCanvas()->get_height() - 320, 'PT Unitedtronik Perkasa Sejahtera', "Arial", 13, [0, 0, 0]);

        // SIGNATURE
        $pdf->getCanvas()->text(340 + 20, $pdf->getCanvas()->get_height() - 225, 'Danang Hendro Widyarto', "Arial", 13, [0, 0, 0]);
        $pdf->getCanvas()->line(360, $pdf->getCanvas()->get_height() - 210, 360 + 135 , $pdf->getCanvas()->get_height() - 210, [0, 0, 0], 1, ['dashed'], 'round');
        $pdf->getCanvas()->text(333, $pdf->getCanvas()->get_height() - 205, 'Manager Finance Accounting & Tax', "Arial", 13, [0, 0, 0]);


        // save pdf
        $output = $pdf->output();
        // $filename = $data['code'] . '.pdf';
        $filePath = 'pdfs/' . $id . '.pdf';
        Storage::disk('local')->put($filePath, $output);

        $response = Response::make($output);

        // Set the appropriate headers for PDF display
        $response->header('Content-Type', 'application/pdf');
        // return $response;
        // Return the response
        notify()->success('Data Created Successfully');
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $no
     * @return \Illuminate\Http\Response
     */
    public function show($nomer)
    {
        $data = Payments::where('id', $nomer)->first();
        if ($data) {
            $filePath = 'pdfs/' . $nomer . '.pdf';
            // dd($filePath);
            if (Storage::disk('local')->exists($filePath)) {

                // Dapatkan path lengkap file PDF
                $fullPath = Storage::path($filePath);
        
                // Buat respons dengan konten file PDF
                return response()->file($fullPath, [
                    'Content-Type' => 'application/pdf',
                ]);
            }
        }

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $data = Payments::where('id', $id)->first();
        if ($data) {

            $filePath = 'pdfs/' . $data['id'] . '.pdf';
    
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
    
            $data->delete();
    
            notify()->success('Data Deleted Successfully');
        } else {
            notify()->error('Data Not Found');
        }
    
        return redirect('/');
    }
}
