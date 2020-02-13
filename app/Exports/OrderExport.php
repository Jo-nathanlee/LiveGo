<?php

namespace App\Exports;

use DB;
use App\Entities\OrderDetail;
use App\Entities\StreamingOrder;
use App\Entities\ShopOrder;
use App\Entities\CheckoutOrder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OrderExport implements FromView, WithEvents, ShouldAutoSize
{
    protected $order_id;

    protected $row_count;
    
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
        $this->row_count = DB::table('checkout_order')->where('order_id', '=', $this->order_id)->count();
        $this->row_count += 8;
    }

    public function view(): View
    {
        return view('print_excel', [
            'streaming_order' => DB::table('streaming_order')->where('order_id', '=', $this->order_id)
                                ->join('streaming_product', 'streaming_order.product_id', '=', 'streaming_product.product_id')
                                ->select('streaming_order.order_id', 'streaming_order.created_time', 'streaming_order.goods_num as order_num', 'streaming_order.single_price', 'streaming_product.*')
                                ->get(),
            'shop_order' => DB::table('shop_order')->where('order_id', '=', $this->order_id)
                            ->join('shop_product', 'shop_order.product_id', '=', 'shop_product.product_id')
                            ->select('shop_order.order_id', 'shop_order.created_time', 'shop_order.goods_num as order_num', 'shop_order.total_price', 'shop_product.*')
                            ->get(),                    
            'page_name' => DB::table('checkout_order')
                        ->where('order_id', '=', $this->order_id)
                        ->join('page','checkout_order.page_id', '=', 'page.page_id')
                        ->select('page.page_name')
                        ->first(),
            'phone' => DB::table('order_detail')->select('buyer_phone')->where('order_id', '=', $this->order_id)->first(),
            'fb_name' => DB::table('checkout_order')
                        ->where('order_id', '=', $this->order_id)
                        ->join('member','checkout_order.fb_id', '=', 'member.fb_id')
                        ->select('member.fb_name')
                        ->first(),
            'adderss' => DB::table('order_detail')->select('buyer_address')->where('order_id', '=', $this->order_id)->first(),
            'note' => DB::table('order_detail')->select('note')->where('order_id', '=', $this->order_id)->first(),
            'total' => DB::table('order_detail')->select('goods_total')->where('order_id', '=', $this->order_id)->first(),
            'freight' => DB::table('order_detail')->select('freight')->where('order_id', '=', $this->order_id)->first(),
            'all_total' => DB::table('order_detail')->select('all_total')->where('order_id', '=', $this->order_id)->first(),
            'order_id' => $this->order_id,
            'tabel_create_time' => date('Y/m/d H:i')
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                //行高
                for ($i = 0; $i<=1265; $i++) {
                    if($i==5 || $i==7){
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(40);    
                    }else{
                        $event->sheet->getDelegate()->getRowDimension($i)->setRowHeight(15);
                    }
                    
                }
                //列寬
                    $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(50);
                //表頭放大
                $event->sheet->getDelegate()->getStyle('A1:I2')->getFont()->setSize(14);
                //內外框線
                $borderArray = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
                            'color' => ['rgb' => '000000'],
                        ],
                        'inside' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ]
                    ]

                ];
                $event->sheet->getDelegate()->getStyle('A4:I'.$this->row_count)->applyFromArray($borderArray);
                //標題灰底
                $tilteArray = [
                    'fill' => [
                        'fillType' => 'linear', //漸層
                        //'rotation' => 45, //漸層角度
                        'startColor' => [
                            'argb' => 'E3E3E1' //初始颜色
                        ],
                        //結束顏色，如果需要單一背景色，和開始顏色設一樣
                        'endColor' => [
                            'argb' => 'E3E3E1'
                        ]
                    ]
                ];
                $event->sheet->getDelegate()->getStyle('A4:I4')->applyFromArray($tilteArray);
                $event->sheet->getDelegate()->getStyle('A6:I6')->applyFromArray($tilteArray);
                $event->sheet->getDelegate()->getStyle('A8:I8')->applyFromArray($tilteArray);
                //合計黃底
                $totalArray = [
                    'fill' => [
                        'fillType' => 'linear', //漸層
                        //'rotation' => 45, //漸層角度
                        'startColor' => [
                            'argb' => 'F6ED12' //初始顏色
                        ],
                        //結束顏色，如果需要單一背景色，和開始顏色設一樣
                        'endColor' => [
                            'argb' => 'F6ED12'
                        ]
                    ]
                ];
                for($i=$this->row_count+1;$i<$this->row_count+4;$i++){
                    $event->sheet->getDelegate()->getStyle('H'.$i.':I'.$i)->applyFromArray($totalArray);
                }
                //置中
                $event->sheet->getDelegate()->getStyle('I5')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A2:I2')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A4:I4')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A6:I6')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A8:I8')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A5:I5')->getAlignment()->setVertical('center');
                $event->sheet->getDelegate()->getStyle('A7:I7')->getAlignment()->setVertical('center');
            },
        ];
    }
}

