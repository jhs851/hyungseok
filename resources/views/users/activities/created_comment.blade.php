<div class="card rounded-0 my-2">
    <div class="card-body">
        <h5 class="card-title">
            <a href="{{ route('developments.show', $activity->subject->development->id) }}">
                {{ $activity->subject->development->title }}
            </a>
        </h5>

        <p class="card-text text-black-50">{!! $activity->subject->body  !!}</p>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <small>
            <i class="far fa-clock mr-1"></i>
            {{ $activity->subject->created_at->format('Y. m. d') }}
        </small>
    </div>
</div>
