<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Board extends Model
{
    protected $fillable = ['name', 'project_id', 'image', 'user_id'];

    /**
     * Returns the board creator.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Returns the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }

    /**
     * Returns all the paths, created on the board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function paths()
    {
        return $this->hasMany(Path::class, 'board_id', 'id');
    }

    /**
     * Return comment points, left on the board.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function commentPoints()
    {
        return $this->hasMany(CommentPoint::class, 'board_id', 'id');
    }

    /**
     * Returns actual board image (for the editor).
     *
     * @return string Board main image for editor
     */
    public function sourceImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . $this->image;
        return Storage::url($imagePath);
    }

    /**
     * Returns a thumbnail version of full sized board image.
     *
     * @return string Board main image for editor
     */
    public function thumbnailImageUrl(): string
    {
        $imagePath = config('images.boards_images_dir') . '/' . config('images.thumbnail_prefix') . $this->image;
        return Storage::url($imagePath);
    }

}
