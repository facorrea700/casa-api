<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembro;


class MiembroController extends ApiController
{
       public function index()
    {
        $Miembro = Miembro::where('id','!=',0)
        ->select('id','name','surname','email', 'password')
                    ->get();
                    
        return $this->sendResponse($Miembro,"Miembros obtenidos correctamente");
        // return $this->sendError("Error Conocido", "Error controlado", 200);

    }
    public function store(Request $request)
    {
        try {
            $Miembro = new Miembro();
            $Miembro->name = $request->input('name');
            $Miembro->surname = $request->input('surname');
            $Miembro->email = $request->input('email');
            $Miembro->password = $request->input('password');
            $Miembro->save();
            return $this->sendResponse($Miembro, "Miembro ingresado correctamente");
        } catch (\Exception $e) {
            return $this->sendError("Error Conocido", "Error al crear el miembro", 200);
        }
    }
    public function show($id)
    {
        $Miembro = Miembro::where('id', '=', $id)
            ->select('id', 'name', 'email', 'password')
            ->get();
        return $this->sendResponse($Miembro, "Miembro obtenido correctamente");
    }
}
