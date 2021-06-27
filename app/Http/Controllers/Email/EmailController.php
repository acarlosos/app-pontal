<?php

namespace App\Http\Controllers\Email;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\App\RemessaJob;
use App\Traits\LayoutTrait;
use App\Repository\RemessaRepository;
use App\Repository\EmailRepository;
use App\Models\Email;
use App\Jobs\App\EmailJob;

class EmailController extends Controller
{
    protected $repository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EmailRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
    }

    public function index()
    {
        return view('app.email.index');
    }

    public function list()
    {
        if (\Auth::user()->id == 1) {
            $emails = Email::orderBy('id', 'desc')->get();
        } else {
            $emails = Email::whereUserId(\Auth::user()->id)->orderBy('id', 'desc')->get();
        }
        return view('app.email.list', compact('emails'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('csv_mala') && $request->hasFile('arquivo_complementar')) {
            $email = new Email();
            $email->user_id = \Auth::user()->id;
            $email->csv_mala = '';
            $email->arquivo_complementar = '';
            $email->save();
            $path = $request->csv_mala->storeAs('email/'.$email->id .'/', $request->csv_mala->getClientOriginalName());
            $path = $request->arquivo_complementar->storeAs('email/'.$email->id .'/', $request->arquivo_complementar->getClientOriginalName());
            $email->update(['csv_mala' => $request->csv_mala->getClientOriginalName(), 'arquivo_complementar' => $request->arquivo_complementar->getClientOriginalName() ]) ;
            EmailJob::dispatch($email)->onQueue('processing');
            return redirect()->route('email.list');
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
