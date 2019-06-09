<template>
    <div class="card">
        <div class="card-header" id="typographicReplacements">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#typographicReplacementsCollapse" aria-expanded="true" aria-controls="typographicReplacementsCollapse">
                    {{ trans('markdown.typographic_replacements.title') }}
                </button>
            </h2>
        </div>

        <div id="typographicReplacementsCollapse" class="collapse" aria-labelledby="typographicReplacements" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.typographic_replacements.description')"></p>

                <pre v-text="trans('markdown.typographic_replacements.example')"></pre>

                <vue-markdown :source="trans('markdown.typographic_replacements.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
