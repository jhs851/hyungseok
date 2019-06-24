<div class="card rounded-0 my-2">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ route('developments.show', $activity->subject->favorited->id) }}">
                {{ $activity->subject->favorited->title }}
            </a>
        </h5>

        <p class="card-text text-black-50">{{ str_limit($activity->subject->favorited->body) }}</p>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <small>
            <i class="far fa-clock mr-1"></i>
            {{ $activity->subject->created_at->format('Y. m. d') }}
        </small>

        <div>
            <small class="mr-3">
                <i class="far fa-eye mr-1"></i>
                0
            </small>

            <small>
                <i class="far fa-comment mr-1"></i>
                {{ $activity->subject->favorited->comments_count }}
            </small>
        </div>
    </div>
</div>
