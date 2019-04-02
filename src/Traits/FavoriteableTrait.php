<?php

namespace Grechanyuk\Favorite\Traits;

use Grechanyuk\Favorite\Models\Favorite;
use Illuminate\Support\Facades\Auth;

trait FavoriteableTrait
{
    private $list = 'favorite';

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable')->list($this->list);
    }

    public function addFavorite(int $user_id = null)
    {
        $this->favorites()->create([
            'user_id' => $user_id ? $user_id : Auth::id(),
            'list' => $this->list
        ]);
    }

    public function removeFavorite(int $user_id = null)
    {
        $this->favorites()->where('user_id', ($user_id) ? $user_id : Auth::id())->delete();
    }

    public function toggleFavorite($user_id = null)
    {
        $this->isFavorited($user_id) ? $this->removeFavorite($user_id) : $this->addFavorite($user_id);
    }

    public function isFavorited($user_id = null)
    {
        return $this->favorites()->where('user_id', ($user_id) ? $user_id : Auth::id())->exists();
    }

    public function favoritedBy()
    {
        return $this->favorites()->with('user')->get()->mapWithKeys(function ($item) {
            return [$item['user']->id => $item['user']];
        });
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function favoritesCount()
    {
        return $this->favoritesCount;
    }

    /**
     * @param string $list
     * @return FavoriteableTrait
     */
    public function setList(string $list)
    {
        $this->list = $list;
        return $this;
    }
}