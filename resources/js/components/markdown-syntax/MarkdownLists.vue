<template>
    <div class="card">
        <div class="card-header" id="lists">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#listsCollapse" aria-expanded="true" aria-controls="listsCollapse">
                    {{ trans('markdown.lists.title') }}
                </button>
            </h2>
        </div>

        <div id="listsCollapse" class="collapse" aria-labelledby="lists" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.lists.description1')"></p>

                <pre v-html="trans('markdown.lists.example1')"></pre>

                <vue-markdown :source="trans('markdown.lists.example1')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.lists.description2')"></p>

                <pre v-html="trans('markdown.lists.example2')"></pre>

                <vue-markdown :source="trans('markdown.lists.example2')"></vue-markdown>

                <hr>

                <p v-text="trans('markdown.lists.description3')"></p>

                <pre v-text="trans('markdown.lists.example3')"></pre>

                <vue-markdown :source="trans('markdown.lists.example3')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
