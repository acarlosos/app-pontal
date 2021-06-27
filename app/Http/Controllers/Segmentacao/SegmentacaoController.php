<?php

namespace App\Http\Controllers\Segmentacao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\App\SegmentacaoJob;
use App\Models\Segmentacao;
use App\Repository\SegmentacaoRepository;

class SegmentacaoController extends Controller
{
    protected $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SegmentacaoRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('app.segmentacao.index');
    }

    public function list()
    {
        
        if (\Auth::user()->id == 1) {
            $segmentacoes = Segmentacao::orderBy('id', 'desc')->get();
        } else {
            $segmentacoes = Segmentacao::whereUserId(\Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        return view('app.segmentacao.list', compact('segmentacoes'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('arquivo_txt')) {
            
            $segmentacao = new Segmentacao();
            $segmentacao->user_id = \Auth::user()->id;
            $segmentacao->arquivo_txt = '';
            $segmentacao->data = $request['data'];
            $segmentacao->save();
            $path = $request->arquivo_txt->storeAs('segmentacao/'.$segmentacao->id .'/', $request->arquivo_txt->getClientOriginalName());

            $segmentacao->update(['arquivo_txt' => $request->arquivo_txt->getClientOriginalName() ]) ;
            SegmentacaoJob::dispatch($segmentacao)->onQueue('processing');
            return redirect()->route('segmentacao.list');
        } else {
            return redirect()->back();
        }
    }

    public function download($id)
    {
        $pathToFile =  $this->repository->download($id);
        return response()->download($pathToFile);
    }
}
