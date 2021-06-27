<?php

namespace App\Http\Controllers\Remessa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Remessa;
use App\Jobs\App\RemessaJob;
use App\Traits\LayoutTrait;
use App\Repository\RemessaRepository;

class RemessaController extends Controller
{
    use LayoutTrait;

    protected $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RemessaRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('app.remessa.index');
    }

    public function list()
    {
        if (\Auth::user()->id == 1) {
            $remessas = Remessa::orderBy('id', 'desc')->get();
        } else {
            $remessas = Remessa::whereUserId(\Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        return view('app.remessa.list', compact('remessas'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('arquivo')) {
            $remessa = Remessa::create(['user_id' => \Auth::user()->id , 'layout_entrada' => $request->layout_entrada]);

            $path = $request->arquivo->storeAs('remessa/'.$remessa->id .'/', $request->arquivo->getClientOriginalName());
            $remessa->update(['arquivo_entrada' => $request->arquivo->getClientOriginalName() ]) ;
            RemessaJob::dispatch($remessa)->onQueue('processing');
            return redirect()->route('remessa.list');
        } else {
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $pathToFile =  $this->repository->downloadRemessa($id);
        return response()->download($pathToFile);
    }
}
