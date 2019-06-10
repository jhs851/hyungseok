<template>
    <div class="card">
        <div class="card-header" id="image">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#imageCollapse" aria-expanded="true" aria-controls="imageCollapse">
                    {{ trans('markdown.image.title') }}
                </button>
            </h2>
        </div>

        <div id="imageCollapse" class="collapse" aria-labelledby="image" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <pre v-text="trans('markdown.image.example')"></pre>

                <p v-text="trans('markdown.image.description')"></p>

                <vue-markdown :source="trans('markdown.image.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
