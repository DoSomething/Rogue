<?php

namespace Rogue\Observers;

use Rogue\Models\Post;
use Rogue\Models\Group;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param  \Rogue\Models\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        // If the post's signup has a group_id, save it on the post as well
        if (! $post->group_id && $post->signup->group_id) {
            $post->group_id = $post->signup->group_id;
        }

        // If we have a group_id but no school_id, save the group's school_id if exists.
        if ($post->group_id && (! $post->school_id) && $group = $post->group) {
            $post->school_id = $group->school_id;
        }
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \Rogue\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        $post->updateOrCreateActionStats();
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \Rogue\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        $post->updateOrCreateActionStats();
    }
}