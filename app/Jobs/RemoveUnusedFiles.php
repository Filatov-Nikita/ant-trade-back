<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class RemoveUnusedFiles implements ShouldQueue
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
        $files = File::where(function($query) {
            $query->whereNull('domain_id')->orWhereNull('domain_type');
        })
        ->whereDate('created_at', '<=', now()->subDays(30)->toDateTimeString())
        ->get();

        $files->each(function($file) {
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        });
    }
}
