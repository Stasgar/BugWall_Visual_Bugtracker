<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable,
        HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'id', 'updated_at', 'created_at'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Set account activation status by flag value (or true).
     *
     * @param bool $flag
     * @return bool
     */
    public function activateAccount($flag = true): bool
    {
        $this->activated = $flag;
        return $this->update();
    }

    /**
     * Return projects user has access to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_access');
    }

    /**
     * Return all issues this user is assigned to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function assignedIssues()
    {
        return $this->belongsToMany(Issue::class, 'issue_assignees');
    }

    /**
     * Returns user avatar image link.
     *
     * @return string User profile image link.
     */
    public function imageLink(): string
    {
        $imagePath = config('images.user_avatar_dir') . '/' . $this->profile_image;
        return Storage::url($imagePath);
    }

}
