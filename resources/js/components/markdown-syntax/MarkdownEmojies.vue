<template>
    <div class="card">
        <div class="card-header" id="emojies">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#emojiesCollapse" aria-expanded="true" aria-controls="emojiesCollapse">
                    {{ trans('markdown.emojies.title') }}
                </button>
            </h2>
        </div>

        <div id="emojiesCollapse" class="collapse" aria-labelledby="emojies" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-html="trans('markdown.emojies.description')"></p>

                <pre v-text="trans('markdown.emojies.example')"></pre>

                <vue-markdown :source="trans('markdown.emojies.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
