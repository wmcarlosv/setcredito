<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProviderCredit;
use App\User;
use App\Sale;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $provider_c = ProviderCredit::where('user_sales_point_id','=',Auth::user()->id)->orderBy('created_at','DESC')->limit('10')->get();
        $sellers = User::where('role','=','sales')->get();
        $sales_point = User::where('role','=','sales_point')->get();
        $sales_point_by_seller = User::where('role','=','sales_point')->where('created_by_id','=',Auth::user()->id)->get();
        $sales = Sale::orderBy('created_at','DESC')->limit(10)->get();
        $sales_by_seller = Sale::where('user_from','=',Auth::user()->id)->orderBy('created_at','DESC')->limit(10)->get();
        return view('home',['provider_c' => $provider_c, 'sellers' => $sellers, 'sales_point' => $sales_point, 'sales' => $sales, 'sales_point_by_seller' => $sales_point_by_seller, 'sales_by_seller' => $sales_by_seller]);
    }
}
