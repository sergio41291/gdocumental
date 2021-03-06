<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use App\Models\Carpeta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class CarpetaController extends Controller
{

    public function index()
    {
        abort_if(Gate::denies('carpeta_index'), 403);
        //$carpetas = Carpeta::paginate(5);
        $carpetas = DB::table('carpetas')
        ->join('users', 'users.id', '=', 'creado_por_id')
        ->select('carpetas.*',
                'users.name as usuario',
                )
        ->orderBy('id')
        ->paginate(5);
        return view('carpetas.index', compact('carpetas'));
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('carpeta_create'), 403);

        $creado_por_id = Auth::id();
        return view('carpetas.create', compact('creado_por_id'))->with('success', 'Carpeta creada correctamente');
        
    }


    public function store(Request $request)
    {
        $creado_por_id= Auth::id();
        $request->merge(['creado_por_id'=>$creado_por_id]);
        Carpeta::create($request->all());

        $mensaje = $request; 
        $ip = request()->server();
        $datauser =auth()->user();
        Log::info( 'IP DEL CLIENTE:'. $ip['REMOTE_ADDR'] . ' CLIENTE: '. $datauser->name . ' DESDE NAVEGADOR:'.$ip['HTTP_USER_AGENT'] . ' DESCRIPCIÓN: Carpeta creada: con nombre ' . $mensaje->nombre );
        
        return redirect()->route('carpetas.index');
    }


    public function show(Carpeta $carpeta)
    {
        abort_if(Gate::denies('carpeta_show'), 403);

        return view('carpetas.show', compact('carpeta'));
    }

    public function edit(Carpeta $carpeta)
    {
        abort_if(Gate::denies('carpeta_edit'), 403);

        return view('carpetas.edit', compact('carpeta'));
    }


    public function update(Request $request, Carpeta $carpeta)
    {
        $carpeta->update($request->all());

        $mensaje = $carpeta; 
        $ip = request()->server();
        $datauser =auth()->user();
        Log::info( 'IP DEL CLIENTE:'. $ip['REMOTE_ADDR'] . ' CLIENTE: '. $datauser->name . ' DESDE NAVEGADOR:'.$ip['HTTP_USER_AGENT'] . ' DESCRIPCIÓN: Carpeta actulizada: con id ' .$mensaje->id . ' ' . $mensaje->nombre );
        
        return redirect()->route('carpetas.index')->with('success', 'Carpeta actualizada correctamente');
    }


    public function destroy(Carpeta $carpeta)
    {
        abort_if(Gate::denies('carpeta_destroy'), 403);

        $mensaje = $carpeta;
        $ip = request()->server();
        $datauser =auth()->user();
        Log::info( 'IP DEL CLIENTE:'. $ip['REMOTE_ADDR'] . ' CLIENTE: '. $datauser->name . ' DESDE NAVEGADOR:'.$ip['HTTP_USER_AGENT'] . ' DESCRIPCIÓN: Carpeta eliminada con id ' .$mensaje->id . ' ' . $mensaje->nombre );
        
        $carpeta->delete();
        return redirect()->route('carpetas.index');
    }
}
