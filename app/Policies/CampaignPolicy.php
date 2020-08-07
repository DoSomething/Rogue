<?php

namespace Rogue\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Rogue\Models\Campaign;

class CampaignPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  Illuminate\Contracts\Auth\Authenticatable $user
     * @param  Rogue\Models\Campaign $campaign
     * @return bool
     */
    public function update($user, Campaign $campaign)
    {
        return is_staff_user();
    }
}
