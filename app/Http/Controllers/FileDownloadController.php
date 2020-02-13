<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Uploadcare;
use GuzzleHttp\Exception\ClientException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Imgur;
use Yish\Imgur\Upload;
use Maatwebsite\Excel\Facades\Excel;
use App\Entities\CheckoutOrder;
use App\Entities\Page;
use App\Entities\ShipSet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Exports\OrderExport;


class FileDownloadController extends Controller
{
   //系統說明文件下載
   public function DownloadManual(Request $request)
   {
       if (Gate::allows('seller-only',  Auth::user())) {
            //PDF file is stored under project/public/download/
            $file= public_path(). "/download/LiveGo_manual.pdf";

            $headers = [
                'Content-Type' => 'application/pdf',
             ];
  
            return response()->download($file, 'LiveGo系統操作說明文件.pdf', $headers);
       }
       else
       {
          return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
       }
   }

   //excel訂單下載
   public function Excel_printer(Request $request)
   {
       if (Gate::allows('seller-only',  Auth::user())) {

         $order_id = json_decode($request->input('order_id'));
         $file_name = "出貨單".date('Y-m-d H:i:s');

         $new_excel = new OrderExport($order_id);

         return Excel::download($new_excel , $file_name.".xlsx");


       }
       else
       {
          return redirect('/')->with('fail', '您尚未開通，請聯繫我們！');
       }
   }
}