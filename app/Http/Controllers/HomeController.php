<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->isAdmin()){
            return redirect('admin');
		}
        return view('home');
    }

    public function get_city_list(Request $request)
    {
        $country = $request->country;
        $city_list = DB::table('tbl_city')->where('country', $country)->get();
        $html_txt = "<option value='0'>Select a city...</option>";
        for($i = 0; $i < count($city_list); $i++){
            $cityName = $city_list[$i]->city;
            $html_txt .= "<option value='".$cityName."'>".$cityName."</option>";
        }
        $response = array(
            'ctrl'     => $request->ctrl,
            'isOrigin' => $request->origin,
            'result'   => 'success',
            'cityList' => $html_txt,
        );
        return response()->json($response);
    }

    public function get_broadcaster_list(Request $request)
    {
        $html_txt = "<option value='0'>Select a Broadcaster...</option>";
    
        $response = array(
            'ctrl'     => $request->ctrl,
            'isOrigin' => $request->origin,
            'result'   => 'success',
            'broadcasterList' => $html_txt,
        );
        return response()->json($response);
    }
}
