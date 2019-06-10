<template>
    <div class="card">
        <div class="card-header" id="taskLists">
            <h2 class="mb-0">
                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#taskListsCollapse" aria-expanded="true" aria-controls="taskListsCollapse">
                    {{ trans('markdown.task_lists.title') }}
                </button>
            </h2>
        </div>

        <div id="taskListsCollapse" class="collapse" aria-labelledby="taskLists" data-parent="#markdownHelperAccordion">
            <div class="card-body markdown-body">
                <p v-html="trans('markdown.task_lists.description1')"></p>

                <pre v-text="trans('markdown.task_lists.example1')"></pre>

                <vue-markdown :task-lists="false" :source="trans('markdown.task_lists.example1')"></vue-markdown>

                <hr>

                <p v-html="trans('markdown.task_lists.description2')"></p>

                <pre v-text="trans('markdown.task_lists.example2')"></pre>

                <vue-markdown :task-lists="false" :source="trans('markdown.task_lists.example2')"></vue-markdown>

                <hr>

                <p v-html="trans('markdown.task_lists.description3')"></p>
            </div>
        </div>
    </div>
</template>
