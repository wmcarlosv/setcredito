<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProviderCredit;
use App\User;
use Auth;

class ProviderCreditsController extends Controller
{
    private $view = "admin.provider_credits.";
    private $route = "provider-credits.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ProviderCredit::where('user_sales_point_id','=',Auth::user()->id)->get();
        $title = "Credito a Conductor";
        return view($this->view."index",['title' => $title, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nuevo Credito a Conductor";
        $method = "insert";
        $providers  = json_decode(file_get_contents("http://app.safeeasytravel.com/api/provider/external_get_providers"));
        return view($this->view."save",['title' => $title, 'method' => $method, 'providers' => $providers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'provider' => 'required',
            'credit' => 'required'
        ]);

        if(Auth::user()->role == 'sales_point'){
            if(!$this->validate_credit($request->input('credit'))){
                return redirect()->back()->withErrors('No tienes creditos suficentes para Asignar!!');
            }
        }

        $object = new ProviderCredit();
        $object->provider = $request->input('provider');
        $object->user_sales_point_id = Auth::user()->id;
        $object->credit = $request->input('credit');

        if($object->save()){
            $this->del_credit($object->credit);
            $this->add_credit($object->provider, $object->credit);
            flash()->overlay('Datos Registrados con Exito!!','Exito');
        }else{
            flash()->overlay('Error al tratar de insertar los Datos!!', 'Exito');
        }

        return redirect()->route($this->route."index");
    }

    public function del_credit($credit){
        $user = User::findorfail(Auth::user()->id);
        $old_credit = $user->total_credit;
        $new_credit = $old_credit-$credit;
        $user->total_credit = $new_credit;
        $user->save();
    }

    public function add_credit($phone, $credit){
        $add_credit  = json_decode(file_get_contents("http://app.safeeasytravel.com/api/provider/external_add_credit/".$phone."/".$credit));
        return $add_credit;
    }  

    public function validate_credit($credit){
        $user = User::findorfail(Auth::user()->id);
        $valido = false;
        if($user->total_credit >= $credit){
            $valido = true;
        }
        return $valido;
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
