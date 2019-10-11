<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;
use App\User;
use Auth;

class SalesController extends Controller
{
    private $view = "admin.sales.";
    private $route = "sales.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'administrator'){
            $data = Sale::all();
        }else{
            $data = Sale::where('user_from','=',Auth::user()->id)->get();
        }
        $title = "Creditos Asignados";
        return view($this->view."index",['title' => $title, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Nueva Asignacion de Credito";
        $method = "insert";
        if(Auth::user()->role == 'administrator'){
            $users = User::where('role','<>','administrator')->get();
        }else{
            $users = User::where('role','=','sales_point')->where('created_by_id','=',Auth::user()->id)->get();
        }
        return view($this->view."save",['title' => $title, 'method' => $method, 'users' => $users]);
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
            'user_to' => 'required',
            'credits' => 'required'
        ]);

        if(Auth::user()->role == 'sales'){
            if(!$this->validate_credit($request->input('credits'))){
                return redirect()->back()->withErrors('No tienes creditos suficentes para Asignar!!');
            }
        }

        $object = new Sale();
        $object->user_from = Auth::user()->id;
        $object->user_to = $request->input('user_to');
        $object->credits = $request->input('credits');
        $object->is_variation = $request->input('is_variation');
        $object->variation_type = $request->input('variation_type');
        $object->variation = $request->input('variation');

        if($object->save()){
            $this->add_credit($object->user_to, $object->credits);
            if(Auth::user()->role == 'sales'){
                $this->del_credit($object->credits);
            }
            flash()->overlay('Datos Registrados con Exito!!','Exito');
        }else{
            flash()->overlay('Error al tratar de insertar los Datos!!', 'Exito');
        }

        return redirect()->route($this->route."index");
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

    public function add_credit($id, $credit){
        $user = User::findorfail($id);
        $old_credit = $user->total_credit;
        $new_credit = $old_credit+$credit;
        $user->total_credit = $new_credit;
        $user->save();
    }

    public function del_credit($credit){
        $user = User::findorfail(Auth::user()->id);
        $old_credit = $user->total_credit;
        $new_credit = $old_credit-$credit;
        $user->total_credit = $new_credit;
        $user->save();
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
