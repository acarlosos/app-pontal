<?php

namespace App\Http\Controllers\Corte;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\App\RemessaJob;
use App\Traits\LayoutTrait;
use App\Repository\RemessaRepository;
use App\Repository\CorteRepository;
use App\Models\Corte;
use App\Jobs\App\CorteJob;

class CorteController extends Controller
{
    protected $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CorteRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('app.corte.index');
    }

    public function list()
    {
        if (\Auth::user()->id == 1) {
            $cortes = Corte::orderBy('id', 'desc')->get();
        } else {
            $cortes = Corte::whereUserId(\Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        return view('app.corte.list', compact('cortes'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('arquivo_csv') && $request->hasFile('arquivo_xls')) {
            $corte = new Corte();
            $corte->user_id = \Auth::user()->id;
            $corte->arquivo_csv = '';
            $corte->arquivo_xls = '';
            $corte->save();
            $path = $request->arquivo_csv->storeAs('corte/'.$corte->id .'/', $request->arquivo_csv->getClientOriginalName());
            $path = $request->arquivo_xls->storeAs('corte/'.$corte->id .'/', $request->arquivo_xls->getClientOriginalName());

            $corte->update(['arquivo_csv' => $request->arquivo_csv->getClientOriginalName(), 'arquivo_xls' => $request->arquivo_xls->getClientOriginalName() ]) ;
            CorteJob::dispatch($corte)->onQueue('processing');
            return redirect()->route('corte.list');
        } else {
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $pathToFile =  $this->repository->downloadCorte($id);
        return response()->download($pathToFile);
    }
}
