<template>
    <div class="card">
        <div class="card-header" id="table">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#tableCollapse" aria-expanded="true" aria-controls="tableCollapse">
                    {{ trans('markdown.table.title') }}
                </button>
            </h2>
        </div>

        <div id="tableCollapse" class="collapse" aria-labelledby="table" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.table.description1')"></p>

                <pre v-text="trans('markdown.table.example1')"></pre>

                <vue-markdown :source="trans('markdown.table.example1')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.table.description2')"></p>

                <pre v-text="trans('markdown.table.example2')"></pre>

                <vue-markdown :source="trans('markdown.table.example2')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
