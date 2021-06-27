<?php

namespace App\Jobs\App;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Segmentacao;
use App\Repository\CorteRepository;
use App\Repository\SegmentacaoRepository;

class SegmentacaoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $segmentacao;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Segmentacao $segmentacao)
    {
        $this->segmentacao = $segmentacao;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repository = new SegmentacaoRepository();
        $repository->processar($this->segmentacao);
    }
}
