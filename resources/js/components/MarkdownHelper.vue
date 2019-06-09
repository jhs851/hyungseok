<template>
    <div>
        <modal name="markdownHelperModal" :full-height="true" position="right">
            <h5 class="mb-0" slot="header" v-text="trans('markdown.header')"></h5>

            <div slot="body">
                <div class="accordion" id="markdownHelperAccordion">
                    <markdown-headings></markdown-headings>

                    <markdown-horizontal-rules></markdown-horizontal-rules>

                    <markdown-typographic-replacements></markdown-typographic-replacements>

                    <markdown-styling-text></markdown-styling-text>

                    <markdown-quoting-text></markdown-quoting-text>

                    <markdown-quoting-code></markdown-quoting-code>

                    <markdown-links></markdown-links>

                    <markdown-lists></markdown-lists>

                    <markdown-code></markdown-code>
                </div>
            </div>
        </modal>

        <button type="button" class="btn btn-primary btn-sm btn-floating position-fixed"
                data-toggle="modal" data-target="#markdownHelperModal" style="right: 30px; bottom: 30px;">
            <i class="fas fa-question"></i>
        </button>
    </div>
</template>

<style scoped lang="scss">
    a {
        cursor: pointer;
    }
</style>
