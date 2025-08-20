<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;

class MediaPolicy
{
    public function delete(User $u, Media $m): bool
    {
        if ($u->hasRole('admin') || $u->can('media.manage')) return true;
        return $m->user_id && $m->user_id === $u->id;
    }
}
