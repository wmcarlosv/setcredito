<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\User;
use Auth;

class UsersController extends Controller
{

    private $view = "admin.users.";
    private $route = "users.";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role == 'administrator'){
            $data = User::all();
            $title = "Usuarios";
        }else{
            $data = User::where('role','=','sales_point')->where('created_by_id','=',Auth::user()->id)->get();
            $title = "Puntos de Venta";
        }
        
        return view($this->view."index",['title' => $title, 'data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role == 'administrator'){
            $title = "Nuevo Usuario";
        }else{
            $title = "Nuevo Punto de Venta";
        }
        
        $method = "insert";
        return view($this->view."save",['title' => $title, 'method' => $method]);
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
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            'role' => 'required'
        ]);

        $object = new User();
        $object->name = $request->input('name');
        $object->last_name = $request->input('last_name');
        $object->reason_social = $request->input('reason_social');
        $object->email = $request->input('email');
        $object->phone = $request->input('phone');
        $object->password = bcrypt('123456789');
        $object->role = $request->input('role');
        $object->created_by_id = Auth::user()->id;
        if($request->hasFile('avatar')){
            $object->avatar = $request->avatar->store('users/avatar');
        }else{
            $object->avatar = NULL;
        }

        if($object->save()){
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findorfail($id);
        if(Auth::user()->role == 'administrator'){
            $title ="Editar Usuario";
        }else{
            $title ="Editar Punto de Venta";
        }
        $method = "edit";

        return view($this->view."save",['title' => $title, 'method' => $method, 'data' => $data]);
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
        $request->validate([
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'email|required',
            'role' => 'required'
        ]);

        $object = User::findorfail($id);
        $object->name = $request->input('name');
        $object->last_name = $request->input('last_name');
        $object->reason_social = $request->input('reason_social');
        $object->email = $request->input('email');
        $object->phone = $request->input('phone');
        $object->role = $request->input('role');

        if($request->hasFile('avatar')){
            Storage::delete($object->avatar);
            $object->avatar = $request->avatar->store('users/avatar');
        }

        if($object->update()){
            flash()->overlay('Datos Registrados con Exito!!','Exito');
        }else{
            flash()->overlay('Error al tratar de insertar los Datos!!', 'Exito');
        }

        return redirect()->route($this->route."index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $object = User::findorfail($id);
        if($object->isactive == "active"){
            $object->isactive = "inactive";
        }else{
            $object->isactive = "active";
        }

        if($object->update()){
            flash()->overlay("Estatus Cambiado con Exito!!","Exito");
        }else{
            flash()->overlay("Error al tratar de camiar el Estatus!!","Error");
        }

        return redirect()->route($this->route."index");
    }

    public function profile(){
        $title = "Perfil";
        return view($this->view."profile", ['title' => $title]);
    }

    public function change_profile(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required'
        ]);

        $object = User::findorfail(Auth::user()->id);
        $object->name = $request->input('name');
        $object->last_name = $request->input('last_name');
        $object->email = $request->input('email');

        if($request->hasFile('avatar')){
            Storage::delete($object->avatar);
            $object->avatar = $request->avatar->store('profile');
        }

        $object->phone = $request->input('phone');
        if($object->update()){
            flash()->overlay('Registro Actualizado con Exito!!','Exito');
        }else{
            flash()->overlay('Error al intentar actualizar el Registro!!','Error');
        }

        return redirect()->route('home');
    }

    public function change_password(Request $request){
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $object = User::findorfail(Auth::user()->id);
        $object->password = $request->input('password');
        if($object->update()){
            flash()->overlay('Registro Actualizado con Exito!!');
        }else{
            flash()->overlay('Error al intentar actualizar el Registro!!');
        }

        return redirect()->route('home');
    }

    public function sales_points(){
        
    }
}
