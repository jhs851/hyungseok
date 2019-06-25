<comment inline-template v-cloak :data="{{ $comment }}">
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
                    <div v-if="! editing" class="dropdown">
                        <a id="comment{{ $comment->id }}Dropdown" class="dropdown-toggle-split text-black-50" href="#"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-list-ul"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="comment{{ $comment->id }}Dropdown">
                            <a class="dropdown-item py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="edit">
                                @lang('developments.edit')
                                <i class="fas fa-pen"></i>
                            </a>

                            <a class="dropdown-item text-danger py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="destroy">
                                @lang('developments.delete')
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                @endcan
            </h6>

            <div v-if="editing">
                <div class="form-group mb-2">
                    <textarea v-model="form.body" :class="{ 'is-invalid': form.errors.has('body') }" class="form-control rounded-0 p-3" @keydown="form.errors.clear('body')" placeholder="@lang('comments.placehoder')"></textarea>

                    <span v-if="form.errors.has('body')" class="invalid-feedback text-left" role="alert">
                        <strong v-text="form.errors.get('body')"></strong>
                    </span>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mr-1" @click="submit">@lang('developments.edit')</button>
                    <button type="button" class="btn btn-outline-primary" @click="cancel">@lang('developments.cancel')</button>
                </div>
            </div>

            <div v-else class="small" v-html="form.body.replace(/(?:\r\n|\r|\n)/g, '<br>')"></div>
        </div>
    </div>
</comment>