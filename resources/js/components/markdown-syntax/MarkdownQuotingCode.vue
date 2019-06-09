<template>
    <div class="card">
        <div class="card-header" id="quotingCode">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#quotingCodeCollapse" aria-expanded="true" aria-controls="quotingCodeCollapse">
                    {{ trans('markdown.quoting_code.title') }}
                </button>
            </h2>
        </div>

        <div id="quotingCodeCollapse" class="collapse" aria-labelledby="quotingCode" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-html="trans('markdown.quoting_code.description1')"></p>

                <pre v-text="trans('markdown.quoting_code.example1')"></pre>

                <vue-markdown :source="trans('markdown.quoting_code.example1')"></vue-markdown>

                <hr>

                <p v-html="trans('markdown.quoting_code.description2')"></p>

                <pre v-text="trans('markdown.quoting_code.example2')"></pre>

                <vue-markdown :source="trans('markdown.quoting_code.example2')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
