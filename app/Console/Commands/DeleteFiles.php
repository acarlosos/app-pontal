<?php

namespace App\Console\Commands;

use App\Models\Corte;
use App\Models\Email;
use App\Models\Remessa;
use App\Models\Segmentacao;
use App\Models\Validador;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deleteFiles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete old files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $corte = storage_path('app/corte/' );
        $email = storage_path('app/email/' );
        $remessa = storage_path('app/remessa/' );
        $validador = storage_path('app/validador/' );
        $segmentacao = storage_path('app/segmentacao/' );
        $data = Carbon::now()->subDay(2);

        $objetos = Corte::where('created_at' , '<' , $data)->get();
        foreach($objetos as $m ) {
            $this->delete($corte . $m->id);
        }
        unset($objetos);
        $objetos = Email::where('created_at' , '<' , $data)->get();
        foreach($objetos as $m ) {
            $this->delete($email . $m->id);
        }
        unset($objetos);

        $objetos = Remessa::where('created_at' , '<' , $data)->get();
        foreach($objetos as $m ) {
            $this->delete($remessa . $m->id);
        }
        unset($objetos);

        $objetos = Validador::where('created_at' , '<' , $data)->get();
        foreach($objetos as $m ) {
            $this->delete($validador . $m->id);
        }
        unset($objetos);

        $objetos = Segmentacao::where('created_at' , '<' , $data)->get();
        foreach($objetos as $m ) {
            $this->delete($segmentacao . $m->id);
        }
        unset($objetos);


    }

    public function delete($folder){
        if (\File::exists($folder))
            \File::deleteDirectory($folder);
    }
}
