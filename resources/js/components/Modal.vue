<template>
    <div class="modal fade" :id="name" tabindex="-1" role="dialog" :aria-labelledby="name" aria-hidden="true">
        <div class="modal-dialog" :class="dialogClasses" role="document">
            <div class="modal-content">
                <div v-if="hasHeader" class="modal-header">
                    <slot class="modal-title" :id="`${name}Label`" name="header"></slot>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
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
                type: Boolean,
                default: false
            },
            position: {
                type: String
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

            dialogClasses() {
                return [
                    this.verticalCenter ? 'modal-dialog-centered' : '',
                    this.size ? `modal-${this.size}` : '',
                    this.fullHeight ? 'modal-full-height' : '',
                    this.position ? `modal-${this.position}` : ''
                ];
            }
        }
    }
</script>