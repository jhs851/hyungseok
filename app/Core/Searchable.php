<?php

namespace App\Core;

use Laravel\Scout\Searchable as BaseSearchable;

trait Searchable
{
    use BaseSearchable;

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray() : array
    {
        return $this->fresh()->toArray() + ['created_at_timestamp' => $this->created_at->timestamp];
    }
}
