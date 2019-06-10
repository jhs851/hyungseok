<template>
    <div class="card">
        <div class="card-header" id="abbreviations">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#abbreviationsCollapse" aria-expanded="true" aria-controls="abbreviationsCollapse">
                    {{ trans('markdown.abbreviations.title') }}
                </button>
            </h2>
        </div>

        <div id="abbreviationsCollapse" class="collapse" aria-labelledby="abbreviations" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <pre v-text="trans('markdown.abbreviations.example')"></pre>

                <vue-markdown :source="trans('markdown.abbreviations.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
