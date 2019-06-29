<?php

namespace App\Core;

use App\Models\Activity;
use Illuminate\Database\Eloquent\{Model, Relations\MorphMany};
use ReflectionClass;
use ReflectionException;

trait RecordsActivity
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function (Model $model) use ($event) {
                $model->recordsActivity($event);
            });
        }

        static::deleting(function (Model $model) {
            $model->activities()->delete();
        });
    }

    /**
     * 활동들을 저장할 메서드들을 반환합니다.
     * 
     * @return array
     */
    protected static function getActivitiesToRecord() : array
    {
        return ['created'];
    }

    /**
     * 활동을 저장합니다.
     *
     * @param  string  $event
     * @return Activity
     * @throws ReflectionException
     */
    protected function recordsActivity(string $event) : Activity
    {
        return $this->activities()->create([
            'type' => $this->getActivityType($event),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * 현재 활동의 타입을 반환합니다.
     * 
     * @param  string  $event
     * @return string
     * @throws ReflectionException
     */
    protected function getActivityType(string $event) : string 
    {
        $type = strtolower((new ReflectionClass($this))->getShortName());
        
        return "{$event}_{$type}";
    }

    /**
     * Activity 모델에 대한 MorphMany 인스턴스를 반환합니다.
     *
     * @return MorphMany
     */
    public function activities() : MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
