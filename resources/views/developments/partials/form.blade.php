@if (Str::contains(request()->path(), 'admin'))
    @section('style')
        @parent

        <style>
            .editor-toolbar {
                top: 0;
            }
        </style>
    @stop
@endif

<div class="form-group">
    <input type="text" class="border-0 h2 w-100" v-model="form.title" name="title"
           placeholder="@lang('validation.attributes.title')" required autocomplete="title"
           autofocus>
</div>

<hr class="mb-5">

<div class="form-group">
    <markdown-editor v-model="form.body" name="body" @uploaded="addPath"></markdown-editor>
</div>

<div class="form-group">
    <tags-select :old="{{ json_encode(old('tags', $development->tags->pluck('id'))) }}"></tags-select>
</div>

<div v-if="uploadedImagesPath.length" class="form-group border px-3 py-2 mb-0">
    <p class="text-black-50 mb-2">@lang('developments.uploaded_images')</p>

    <ul class="list-unstyled mb-0">
        <li v-for="path in uploadedImagesPath">
            <div class="input-group my-1">
                <input type="text" :value="path" class="form-control" readonly>

                <div class="input-group-append">
                    <clipboard class="input-group-text" :data="path">
                        <i class="far fa-copy"></i>
                    </clipboard>
                </div>
            </div>
        </li>
    </ul>
</div>
