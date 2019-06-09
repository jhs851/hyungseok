<template>
    <div class="card">
        <div class="card-header" id="stylingText">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#stylingTextCollapse" aria-expanded="true" aria-controls="stylingTextCollapse">
                    {{ trans('markdown.styling_text.title') }}
                </button>
            </h2>
        </div>

        <div id="stylingTextCollapse" class="collapse" aria-labelledby="stylingText" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.styling_text.description')"></p>

                <vue-markdown :source="trans('markdown.styling_text.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
