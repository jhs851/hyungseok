<?php

namespace App\Core;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\{Model, Relations\MorphMany};

trait Favoritable
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootFavoritable() : void
    {
        static::deleting(function (Model $model) {
            $model->favorites->each->delete();
        });
    }

    /**
     * 현재 트레이트를 포함한 모델에서 자동으로 불러집니다.
     */
    public function initializeFavoritable() : void
    {
        $this->append(['favoritesCount', 'isFavorited']);
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
     * 개발 포스트에 '좋아요'를 취소합니다.
     *
     * @return static
     */
    public function unfavorite()
    {
        $this->favorites()->where(['user_id' => auth()->id()])->get()->each->delete();

        return $this;
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
     * 현재 사용자가 좋아요를 했는지 확인합니다.
     *
     * @return bool
     */
    public function getIsFavoritedAttribute() : bool
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
