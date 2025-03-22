<?php

namespace App\Listeners;

use App\Events\OperationRemoved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Storage;

class RemoveOperationFiles
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OperationRemoved $event): void
    {
        $files = $event->operation->files;

        $files->each(function($file) {
            Storage::disk($file->disk)->delete($file->path);
            $file->delete();
        });
    }
}
