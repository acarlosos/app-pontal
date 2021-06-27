<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Remessa;
use App\Models\Corte;
use App\Models\Email;
use App\Models\Segmentacao;
use App\Models\Validador;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = \Auth::user()->id ;
        if ($userId == 1) {
            $remessaTotal = Remessa::whereStatus(Remessa::FINALIZADO)->count();
            $corteTotal = Corte::whereStatus(Corte::FINALIZADO)->count();
            $emailTotal = Email::whereStatus(Email::FINALIZADO)->count();
            $segmentacaoTotal = Segmentacao::whereStatus(Segmentacao::FINALIZADO)->count();
            $validadorTotal = Validador::whereStatus(Validador::FINALIZADO)->count();
        } else {
            $remessaTotal = Remessa::whereStatus(Remessa::FINALIZADO)->whereUserId($userId)->count();
            $corteTotal = Corte::whereStatus(Corte::FINALIZADO)->whereUserId($userId)->count();
            $emailTotal = Email::whereStatus(Corte::FINALIZADO)->whereUserId($userId)->count();
            $segmentacaoTotal = Segmentacao::whereStatus(Segmentacao::FINALIZADO)->whereUserId($userId)->count();
            $validadorTotal = Validador::whereStatus(Validador::FINALIZADO)->whereUserId($userId)->count();
        }
        return view('home', compact('remessaTotal', 'corteTotal', 'emailTotal', 'segmentacaoTotal', 'validadorTotal'));
    }
}
