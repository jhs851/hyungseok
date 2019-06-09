<template>
    <div class="card">
        <div class="card-header" id="links">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#linksCollapse" aria-expanded="true" aria-controls="linksCollapse">
                    {{ trans('markdown.links.title') }}
                </button>
            </h2>
        </div>

        <div id="linksCollapse" class="collapse" aria-labelledby="links" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-html="trans('markdown.links.description')"></p>

                <pre v-text="trans('markdown.links.example')"></pre>

                <vue-markdown :source="trans('markdown.links.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
