<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessOptimization;

class OptimizeImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $storagePath = storage_path('app/public');
        $storagePath = str_replace('\\', '/', $storagePath); // Convert backslashes to forward slashes
    
        $files = glob($storagePath . '/**/*.{jpg,jpeg,png}', GLOB_BRACE); // Use GLOB_BRACE
        $chunks = array_chunk($files, 25);

        foreach ($chunks as $imageBatch) {
            ProcessOptimization::dispatch($imageBatch);
        }
    }
}
