<template>
    <div class="card">
        <div class="card-header" id="headings">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#headingsCollapse" aria-expanded="true" aria-controls="headingsCollapse">
                    {{ trans('markdown.headings.title') }}
                </button>
            </h2>
        </div>

        <div id="headingsCollapse" class="collapse" aria-labelledby="headings" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.headings.description')"></p>

                <pre v-text="trans('markdown.headings.example')"></pre>

                <vue-markdown :source="trans('markdown.headings.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
