<?php

namespace App\Jobs\App;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Remessa;
use App\Repository\RemessaRepository;

class RemessaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $remessa;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Remessa $remessa)
    {
        $this->remessa = $remessa;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $repository = new RemessaRepository();
        $repository->processar($this->remessa);
    }
}
