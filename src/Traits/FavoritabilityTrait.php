<?php

namespace Grechanyuk\Favorite\Traits;

use Grechanyuk\Favorite\Models\Favorite;

trait FavoritabilityTrait
{
    private $list = 'favorite';
    /**
     * @return mixed
     */
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id')->list($this->list);
    }

    /**
     * @param $class
     * @return mixed
     */
    public function favorite($class)
    {
        return $this->favorites()->where('favoriteable_type', $class)->with('favoriteable')->get()->mapWithKeys(function ($item) {
            return [$item['favoriteable']->id=>$item['favoriteable']];
        });
    }

    /**
     * @param $object
     */
    public function addFavorite($object)
    {
        $object->setList($this->list)->addFavorite($this->id);
    }

    /**
     * @param $object
     */
    public function removeFavorite($object)
    {
        $object->setList($this->list)->removeFavorite($this->id);
    }

    /**
     * @param $object
     */
    public function toggleFavorite($object)
    {
        $object->setList($this->list)->toggleFavorite($this->id);
    }

    /**
     * @param $object
     * @return mixed
     */
    public function isFavorited($object)
    {
        return $object->setList($this->list)->isFavorited($this->id);
    }

    /**
     * @param $object
     * @return mixed
     */
    public function hasFavorited($object)
    {
        return $object->setList($this->list)->isFavorited($this->id);
    }

    /**
     * @param string $list
     * @return FavoritabilityTrait
     */
    public function setList(string $list)
    {
        $this->list = $list;
        return $this;
    }
}