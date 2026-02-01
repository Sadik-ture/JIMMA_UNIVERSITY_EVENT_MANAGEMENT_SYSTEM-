<?php

namespace App\Policies;

use App\Models\Announcement;
use App\Models\User;

class AnnouncementPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyPermission(['manage_announcements', 'view_announcements']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Announcement $announcement): bool
    {
        // Admin can view all
        if ($user->hasPermission('manage_announcements')) {
            return true;
        }
        
        // User can view if they have permission and announcement is published
        if ($announcement->is_published && $user->hasPermission('view_announcements')) {
            // Check audience restrictions
            return $this->checkAudienceAccess($user, $announcement);
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_announcements');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Announcement $announcement): bool
    {
        // Can edit if they have permission AND (created it OR have manage permission)
        return $user->hasPermission('edit_announcements') && 
               ($announcement->created_by === $user->id || $user->hasPermission('manage_announcements'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Announcement $announcement): bool
    {
        return $user->hasPermission('delete_announcements');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Announcement $announcement): bool
    {
        return $user->hasPermission('manage_announcements');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Announcement $announcement): bool
    {
        return $user->hasPermission('manage_announcements');
    }

    /**
     * Check if user can access based on audience
     */
    private function checkAudienceAccess(User $user, Announcement $announcement): bool
    {
        if ($announcement->audience === 'all') {
            return true;
        }
        
        if ($announcement->audience === ($user->role->slug ?? 'guest')) {
            return true;
        }
        
        if ($announcement->audience === 'specific' && $announcement->target_ids) {
            return in_array($user->id, $announcement->target_ids);
        }
        
        return false;
    }
}