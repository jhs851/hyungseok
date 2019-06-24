<?php

namespace App\Core;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\{Builder, Model, Relations\MorphMany};

trait Favoritable
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootFavoritable() : void
    {
        static::addGlobalScope('favorites', function (Builder $modal) {
            $modal->with('favorites');
        });

        static::deleting(function (Model $model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * 개발 포스트에 '좋아요'를 합니다.
     *
     * @return Favorite|null
     */
    public function favorite() : ?Favorite
    {
        $attributes = ['user_id' => auth()->id()];

        if ($this->favorites()->where($attributes)->exists()) {
            return null;
        }

        return $this->favorites()->create($attributes);
    }

    /**
     * Favorite에 대한 MorphMany 인스턴스를 반환합니다.
     *
     * @return MorphMany
     */
    public function favorites() : MorphMany
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * 현재 사용자가 좋아료를 했는지 확인합니다.
     *
     * @return bool
     */
    public function getisFavoritedAttribute() : bool
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    /**
     * 현재 모델의 좋아요 수를 반환합니다.
     *
     * @return int
     */
    public function getFavoritesCountAttribute() : int
    {
        return $this->favorites->count();
    }
}
