<?php

namespace App\Jobs;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DeletePosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    
    public function __construct()
    {
        //
    }

        
    public function handle()
    {
        $posts = Post::where('deleted_at', '<=', Carbon::now()->subMonth())->onlyTrashed()->get();
        foreach ($posts as $post) {
            $post->delete();
        }
        Log::info("Job done successfully");
    }
}
