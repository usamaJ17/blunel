<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ProcessOptimization implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $batch;

    /**
     * Create a new job instance.
     */
    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("asdsad1");
        $threshold = Carbon::now()->subHours(23)->subMinutes(57);
        foreach ($this->batch as $imagePath) {
            if (filemtime($imagePath) > $threshold->timestamp) {
                $image = Image::make($imagePath);
                $image->resize($image->width() * 0.70, $image->height() * 0.70);
                $image->save($imagePath, 45,$image->mime());
            }
        }
    }
}
