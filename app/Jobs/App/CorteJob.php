<?php

namespace App\Jobs\App;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Corte;
use App\Repository\CorteRepository;

class CorteJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $corte;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Corte $corte)
    {
        $this->corte = $corte;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repository = new CorteRepository();
        $repository->processar($this->corte);
    }
}
