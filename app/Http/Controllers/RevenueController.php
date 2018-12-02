<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;
use App\Entities\OrderDetail;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RevenueController extends Controller
{
    public function DailyRevenue(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $date1 = date('Y-m-d', strtotime('-7 days'));
            $date2 = date('Y-m-d', strtotime('-6 days'));
            $date3 = date('Y-m-d', strtotime('-5 days'));
            $date4 = date('Y-m-d', strtotime('-4 days'));
            $date5 = date('Y-m-d', strtotime('-3 days'));
            $date6 = date('Y-m-d', strtotime('-2 days'));
            $date7 = date('Y-m-d', strtotime('-1 days'));

            $date1_query = OrderDetail::where('transaction_date', 'like', '%'.$date1.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date2_query = OrderDetail::where('transaction_date', 'like', '%'.$date2.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date3_query = OrderDetail::where('transaction_date', 'like', '%'.$date3.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date4_query = OrderDetail::where('transaction_date', 'like', '%'.$date4.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date5_query = OrderDetail::where('transaction_date', 'like', '%'.$date5.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date6_query = OrderDetail::where('transaction_date', 'like', '%'.$date6.'%')
            ->where('status', '=', 'finished')
            ->get();
            $date7_query = OrderDetail::where('transaction_date', 'like', '%'.$date7.'%')
            ->where('status', '=', 'finished')
            ->get();

            $date1_amount = 0;
            $date2_amount = 0;
            $date3_amount = 0;
            $date4_amount = 0;
            $date5_amount = 0;
            $date6_amount = 0;
            $date7_amount = 0;

            foreach ($date1_query as $order) {
                $date1_amount += (int)($order->total_price);
            }
            foreach ($date2_query as $order) {
                $date2_amount += (int)($order->total_price);
            }
            foreach ($date3_query as $order) {
                $date3_amount += (int)($order->total_price);
            }
            foreach ($date4_query as $order) {
                $date4_amount += (int)($order->total_price);
            }
            foreach ($date5_query as $order) {
                $date5_amount += (int)($order->total_price);
            }
            foreach ($date6_query as $order) {
                $date6_amount += (int)($order->total_price);
            }
            foreach ($date7_query as $order) {
                $date7_amount += (int)($order->total_price);
            }

            $amount = array();
            $date = array();

            for($i=1;$i<8;$i++)
            {
                $temp2="date".(string)$i."_amount";
                $temp="date".(string)$i;
                array_push($date, $$temp);
                array_push($amount, $$temp2);
            }

    

            return view('daily_revenue', ['date' => $date,'amount' => $amount]);
        }   
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
        
        

    }

    public function MonthlyRevenue(Request $request)
    {
        if (Gate::allows('seller-only',  Auth::user())) {
            $month1 = date('Y-m', strtotime('-7 months'));
            $month2 = date('Y-m', strtotime('-6 months'));
            $month3 = date('Y-m', strtotime('-5 months'));
            $month4 = date('Y-m', strtotime('-4 months'));
            $month5 = date('Y-m', strtotime('-3 months'));
            $month6 = date('Y-m', strtotime('-2 months'));
            $month7 = date('Y-m', strtotime('-1 months'));

            $month1_query = OrderDetail::where('transaction_date', 'like', '%'.$month1.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month2_query = OrderDetail::where('transaction_date', 'like', '%'.$month2.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month3_query = OrderDetail::where('transaction_date', 'like', '%'.$month3.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month4_query = OrderDetail::where('transaction_date', 'like', '%'.$month4.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month5_query = OrderDetail::where('transaction_date', 'like', '%'.$month5.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month6_query = OrderDetail::where('transaction_date', 'like', '%'.$month6.'%')
            ->where('status', '=', 'finished')
            ->get();
            $month7_query = OrderDetail::where('transaction_date', 'like', '%'.$month7.'%')
            ->where('status', '=', 'finished')
            ->get();

            $month1_amount = 0;
            $month2_amount = 0;
            $month3_amount = 0;
            $month4_amount = 0;
            $month5_amount = 0;
            $month6_amount = 0;
            $month7_amount = 0;

            foreach ($month1_query as $order) {
                $month1_amount += (int)($order->total_price);
            }
            foreach ($month2_query as $order) {
                $month2_amount += (int)($order->total_price);
            }
            foreach ($month3_query as $order) {
                $month3_amount += (int)($order->total_price);
            }
            foreach ($month4_query as $order) {
                $month4_amount += (int)($order->total_price);
            }
            foreach ($month5_query as $order) {
                $month5_amount += (int)($order->total_price);
            }
            foreach ($month6_query as $order) {
                $month6_amount += (int)($order->total_price);
            }
            foreach ($month7_query as $order) {
                $month7_amount += (int)($order->total_price);
            }

            $amount = array();
            $month = array();

            for($i=1;$i<8;$i++)
            {
                $temp2="month".(string)$i."_amount";
                $temp="month".(string)$i;
                array_push($date, $$temp);
                array_push($amount, $$temp2);
            }
            return view('monthly_revenue', ['month' => $month,'amount' => $amount]);



            
        }
        else
        {
           return redirect('/')->with('alert', '您尚未開通，請聯繫我們！');
        }
    }
}
