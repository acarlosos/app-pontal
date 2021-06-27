<?php

namespace App\Jobs\App;

use App\Models\Validador;
use App\Repository\ValidadorRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ValidadorJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $validador;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Validador $validador)
    {
        $this->validador = $validador;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repository = new ValidadorRepository();
        $repository->processar($this->validador);
    }
}
