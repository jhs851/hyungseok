<template>
    <div class="card">
        <div class="card-header" id="subscriptSuperscript">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#subscriptSuperscriptCollapse" aria-expanded="true" aria-controls="subscriptSuperscriptCollapse">
                    {{ trans('markdown.subscript_superscript.title') }}
                </button>
            </h2>
        </div>

        <div id="subscriptSuperscriptCollapse" class="collapse" aria-labelledby="subscriptSuperscript" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <pre v-text="trans('markdown.subscript_superscript.example')"></pre>

                <vue-markdown :source="trans('markdown.subscript_superscript.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
