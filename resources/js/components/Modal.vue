<template>
    <div class="modal fade" :id="name" tabindex="-1" role="dialog" :aria-labelledby="name" aria-hidden="true" v-cloak :class="modalClasses" :style="modalStyles">
        <div class="modal-dialog" :class="getDialogClasses" :style="dialogStyles" role="document">
            <div class="modal-content" :class="contentClasses" :style="contentStyles">
                <div v-if="hasHeader" class="modal-header" :class="headerClasses">
                    <slot class="modal-title" :id="`${name}Label`" name="header"></slot>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" :class="bodyClasses">
                    <slot name="body"></slot>
                </div>

                <div v-if="hasFooter" class="modal-footer">
                    <slot name="footer"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Modal",

        props: {
            name: {
                type: String,
                required: true
            },
            verticalCenter: {
                type: Boolean,
                default: false
            },
            size: {
                type: String,
                default: ''
            },
            fullHeight: {
                type: String,
                default: ''
            },
            modalClasses: {
                type: String,
                default: ''
            },
            dialogClasses: {
                type: String,
                default: ''
            },
            contentClasses: {
                type: String,
                default: ''
            },
            headerClasses: {
                type: String,
                default: ''
            },
            bodyClasses: {
                type: String,
                default: ''
            },
            modalStyles: {
                type: String,
                default: ''
            },
            dialogStyles: {
                type: String,
                default: ''
            },
            contentStyles: {
                type: String,
                default: ''
            }
        },

        mounted() {
            this.$el.parentNode.removeChild(this.$el);

            document.body.appendChild(this.$el);
        },

        methods: {
            close() {
                $(this.$el).modal('hide');
            }
        },

        computed: {
            hasHeader() {
                return this.$slots.hasOwnProperty('header');
            },

            hasFooter() {
                return this.$slots.hasOwnProperty('footer');
            },

            getDialogClasses() {
                return [
                    this.verticalCenter ? 'modal-dialog-centered' : '',
                    this.size ? `modal-${this.size}` : '',
                    this.fullHeight ? `modal-full-height modal-${this.fullHeight}` : ''
                ].concat(this.dialogClasses);
            }
        }
    }
</script>
