<template>
    <div class="card">
        <div class="card-header" id="quotingText">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#quotingTextCollapse" aria-expanded="true" aria-controls="quotingTextCollapse">
                    {{ trans('markdown.quoting_text.title') }}
                </button>
            </h2>
        </div>

        <div id="quotingTextCollapse" class="collapse" aria-labelledby="quotingText" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-html="trans('markdown.quoting_text.description')"></p>

                <pre v-text="trans('markdown.quoting_text.example')"></pre>

                <vue-markdown :source="trans('markdown.quoting_text.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
