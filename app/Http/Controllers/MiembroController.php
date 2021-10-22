<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Miembro;


class MiembroController extends ApiController
{
    public function index()
    {
        $Miembro = Miembro::where('id', '!=', 0)
            ->select('id', 'name', 'surname', 'email', 'password')
            ->get();

        return $this->sendResponse($Miembro, "Miembros obtenidos correctamente");
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

    public function deposit(Request $request)
    {
        $id = $request->input('id');
        $monto = $request->input('monto');

        if ($monto > 0) {
            $Miembro = Miembro::find($id);
            $Miembro->monto += $monto;
            $Miembro->save();
            return $this->sendResponse($Miembro, "Monto depositado correctamente.");
        }
    }

    public function remove(Request $request)
    {
        $id = $request->input('id');
        $montoARetirar = $request->input('monto');
        $Miembro = Miembro::find($id);
        $montoActual = $Miembro->monto;
        if ($montoActual >= $montoARetirar) {
            $Miembro->monto -= $montoARetirar;
            $Miembro->save();
            return $this->sendResponse($Miembro, "Monto extraido correctamente.");
        } else {
            return $this->sendError("Saldo no disponible en cuenta origen.", "Saldo no disponible en la cuenta para extracción.");
        }
    }

    public function transfer(Request $request)
    {
        $idOrigen = $request->input('idOrigen');
        $idDestino = $request->input('idDestino');

        $montoATransferir = $request->input('montoATransferir');

        $MiembroOrigen = Miembro::find($idOrigen);

        $montoActualOrigen = $MiembroOrigen->monto;

        $MiembroDestino = Miembro::find($idDestino);

        if ($montoActualOrigen >= $montoATransferir) {
            $MiembroDestino->monto += $montoATransferir;
            $MiembroOrigen->monto -= $montoATransferir;
            $MiembroDestino->save();
            $MiembroOrigen->save();
            return $this->sendResponse($MiembroDestino, "Monto transferido correctamente.");
        } else {
            return $this->sendError("Saldo no disponible en cuenta origen.", " No se puede transferir, sin fondos.", 406);
        }
    }
}
