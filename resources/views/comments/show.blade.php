<div class="media my-5 text-left">
    <img src="//via.placeholder.com/64x64" class="img-fluid mr-3 rounded-circle" alt="">
    <div class="media-body">
        <h6 class="mt-0 d-flex align-items-end">
            <div class="mr-auto">
                <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
                    {{ $comment->user->name }}
                </a>

                <small class="text-muted ml-2">
                    {{ $comment->created_at->diffForHumans() }}
                </small>
            </div>

            @can ('update', $comment)
                <div class="dropdown">
                    <a id="comment{{ $comment->id }}Dropdown" class="dropdown-toggle-split text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        <i class="fas fa-list-ul"></i>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment{{ $comment->id }}Dropdown">
                        <form method="POST" action="{{ route('comments.destroy', ['development' => $comment->development->id, 'comment' => $comment->id]) }}">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="dropdown-item text-danger py-3 d-flex justify-content-between align-items-center" @click="destroy">
                                @lang('developments.delete')
                                <i class="far fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endcan
        </h6>

        <div class="small">
            {{ $comment->body }}
        </div>
    </div>
</div>
