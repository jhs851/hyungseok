<template>
    <div class="card">
        <div class="card-header" id="code">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#codeCollapse" aria-expanded="true" aria-controls="codeCollapse">
                    {{ trans('markdown.code.title') }}
                </button>
            </h2>
        </div>

        <div id="codeCollapse" class="collapse" aria-labelledby="code" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <pre v-text="trans('markdown.code.example1')"></pre>

                <vue-markdown :source="trans('markdown.code.example1')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.code.description2')"></p>

                <pre v-text="trans('markdown.code.example2')"></pre>

                <vue-markdown :source="trans('markdown.code.example2')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.code.description3')"></p>

                <pre v-text="trans('markdown.code.example3')"></pre>

                <vue-markdown :source="trans('markdown.code.example3')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.code.description4')"></p>

                <pre v-text="trans('markdown.code.example4')"></pre>

                <vue-markdown :source="trans('markdown.code.example4')" @rendered="enablePrism"></vue-markdown>
            </div>
        </div>
    </div>
</template>
