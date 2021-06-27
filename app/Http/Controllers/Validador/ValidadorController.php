<?php

namespace App\Http\Controllers\Validador;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\App\ValidadorJob;
use App\Models\Validador;
use App\Repository\ValidadorRepository;

class ValidadorController extends Controller
{
    protected $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ValidadorRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('app.validador.index');
    }

    public function list()
    {
        $userId = \Auth::user()->id;
        if ($userId == 1) {
            $validadors = Validador::orderBy('id', 'desc')->get();
        } else {
            $validadors = Validador::whereUserId($userId)->orderBy('id', 'desc')->get();
        }
        return view('app.validador.list', compact('validadors'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('arquivo')) {
            $validador = Validador::create(['user_id' => \Auth::user()->id , 'layout_entrada' => $request->layout_entrada]);
            $path = $request->arquivo->storeAs('validador/'.$validador->id .'/', $request->arquivo->getClientOriginalName());
            $validador->update(['arquivo_entrada' => $request->arquivo->getClientOriginalName() ]) ;
            ValidadorJob::dispatch($validador)->onQueue('processing');
            return redirect()->route('validador.list');
        } else {
            return redirect()->back();
        }
    }

    public function downloadSuccess($id)
    {
        $pathToFile =  $this->repository->downloadSuccess($id);
        return response()->download($pathToFile);
    }
    public function downloadError($id)
    {
        $pathToFile =  $this->repository->downloadError($id);
        return response()->download($pathToFile);
    }
    public function downloadLog($id)
    {
        $pathToFile =  $this->repository->downloadLog($id);
        return response()->download($pathToFile);
    }

}
