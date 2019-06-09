<template>
    <div class="card">
        <div class="card-header" id="horizontalRules">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#horizontalRulesCollapse" aria-expanded="true" aria-controls="horizontalRulesCollapse">
                    {{ trans('markdown.horizontal_rules.title') }}
                </button>
            </h2>
        </div>

        <div id="horizontalRulesCollapse" class="collapse" aria-labelledby="horizontalRules" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-text="trans('markdown.horizontal_rules.description')"></p>

                <pre v-text="trans('markdown.horizontal_rules.example')"></pre>

                <vue-markdown :source="trans('markdown.horizontal_rules.example')"></vue-markdown>
            </div>
        </div>
    </div>
</template>
