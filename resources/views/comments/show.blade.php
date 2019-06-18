<div class="media my-5 text-left">
    <img src="//via.placeholder.com/64x64" class="img-fluid mr-3 rounded-circle" alt="">
    <div class="media-body">
        <h6 class="mt-0 d-flex align-items-end">
            <a href="#">
                {{ $comment->user->name }}
            </a>

            <small class="text-muted ml-2">
                {{ $comment->created_at->diffForHumans() }}
            </small>
        </h6>

        <div class="small">
            {{ $comment->body }}
        </div>
    </div>
</div>
