<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewPostNotification;
use App\Notifications\TestNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class sendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;
    protected $owner;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post=$post;
        $this->owner=$user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {


        $data=[
            'message' => 'bài viết mới vừa được tạo',
            'title' => $this->post->title,
            'author' => $this->post->author,
            'post_id' => $this->post->id,
            'owner_id' => $this->owner->id,
            'avatar'=>$this->owner->avatar,
            'type' => 'new_post',
        ];

        $categories=array_column($this->post->categories->toArray(),'id');
        $user_id = \Illuminate\Support\Facades\DB::table('category_user')->select('user_id')->whereIn('category_id',$categories)->distinct()->get();
        $user_id = array_column($user_id->toArray(),'user_id');
        $users =User::query()->whereIn('id',$user_id)->where('id','<>',$this->owner->id)->get();
        foreach ($users as $user){
            $user->notify(new NewPostNotification($data));
        }
    }
}
