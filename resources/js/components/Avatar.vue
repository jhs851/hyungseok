<template>
    <div>
        <modal name="avatar-modal" :vertical-center="true">
            <div slot="header" v-text="trans('auth.avatars.title')"></div>

            <div slot="body">
                <img id="cropper" class="img-fluid" :src="data.src" alt="">
            </div>

            <template slot="footer">
                <div class="btn-group mb-2" role="group" aria-label="Cropper1">
                    <button type="button" class="btn btn-primary btn-sm" @click="mode('move')" data-toggle="tooltip" :title="trans('utilities.cropper.mode.move')">
                        <i class="fas fa-arrows-alt"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="mode('crop')" data-toggle="tooltip" :title="trans('utilities.cropper.mode.crop')">
                        <i class="fas fa-crop-alt"></i>
                    </button>
                </div>

                <div class="btn-group mb-2" role="group" aria-label="Cropper2">
                    <button type="button" class="btn btn-primary btn-sm" @click="zoom(0.1)" data-toggle="tooltip" :title="trans('utilities.cropper.zoom.in')">
                        <i class="fas fa-search-plus"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="zoom(-0.1)" data-toggle="tooltip" :title="trans('utilities.cropper.zoom.out')">
                        <i class="fas fa-search-minus"></i>
                    </button>
                </div>

                <div class="btn-group mb-2" role="group" aria-label="Cropper3">
                    <button type="button" class="btn btn-primary btn-sm" @click="move(-10, 0)" data-toggle="tooltip" :title="trans('utilities.cropper.move.left')">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="move(10, 0)" data-toggle="tooltip" :title="trans('utilities.cropper.move.right')">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="move(0, -10)" data-toggle="tooltip" :title="trans('utilities.cropper.move.up')">
                        <i class="fas fa-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="move(0, 10)" data-toggle="tooltip" :title="trans('utilities.cropper.move.down')">
                        <i class="fas fa-arrow-down"></i>
                    </button>
                </div>

                <div class="btn-group mb-2" role="group" aria-label="Cropper4">
                    <button type="button" class="btn btn-primary btn-sm" @click="rotate(-45)" data-toggle="tooltip" :title="trans('utilities.cropper.rotate.left')">
                        <i class="fas fa-undo"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="rotate(45)" data-toggle="tooltip" :title="trans('utilities.cropper.rotate.right')">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>

                <div class="btn-group mb-2" role="group" aria-label="Cropper5">
                    <button type="button" class="btn btn-primary btn-sm" @click="reset" data-toggle="tooltip" :title="trans('utilities.cropper.etc.reset')">
                        <i class="fas fa-sync"></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm" @click="replace" data-toggle="tooltip" :title="trans('utilities.cropper.etc.replace')">
                        <i class="fas fa-upload"></i>
                    </button>
                    <input id="replace" type="file" accept="image/*" class="d-none" @change="onChange">
                </div>

                <div class="btn-group mb-2" role="group" aria-label="Cropper6">
                    <button type="button" class="btn btn-primary btn-sm" @click="submit" v-text="trans('auth.avatars.submit')"></button>
                </div>
            </template>
        </modal>


        <div class="dropdown" v-if="authorize(model)">
            <a id="avatarDropdown" class="dropdown-toggle-split p-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <slot :avatar="avatar"></slot>
            </a>

            <div class="dropdown-menu" aria-labelledby="avatarDropdown">
                <label class="dropdown-item py-3 m-0" style="cursor: pointer;">
                    {{ trans('auth.avatars.edit') }}

                    <input name="avatar" type="file" class="d-none" accept="image/*" @change="onChange">
                </label>

                <a class="dropdown-item py-3" href="#" @click.prevent="destroy" v-text="trans('auth.avatars.destroy')"></a>
            </div>
        </div>

        <a v-else :href="avatar" target="_blank">
            <slot :avatar="avatar"></slot>
        </a>
    </div>
</template>

<script>
    import 'cropper';

    export default {
        props: {
            model: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                reader: new FileReader,
                cropper: '',
                avatar: this.model.avatar,
                data: { src: '' }
            };
        },

        mounted() {
            $('#avatar-modal').on({
                'shown.bs.modal': this.enable,
                'hide.bs.modal': this.disable
            });
        },

        methods: {
            onChange(e) {
                this.reader.onload = this.load;

                this.reader.readAsDataURL(e.target.files[0]);
            },

            load(e) {
                let result = e.target.result;

                if (! result.replace('data:', '')) {
                    return toastr.error(this.trans('auth.avatars.failToCreateImage'));
                }

                if (this.data.src) {
                    this.disable();

                    this.data.src = result;

                    setTimeout(this.enable, 1000);
                } else {
                    this.data.src = result;

                    $(`#avatar-modal`).modal('show');
                }
            },

            enable() {
                this.cropper = $('#cropper').cropper({
                    viewMode: 1,
                    aspectRatio: 1,
                    highlight: false,
                    autoCropArea: 0.5,
                    scalable: false,
                    zoomOnTouch: false,
                    zoomOnWheel: false,
                });
            },

            disable() {
                this.cropper.cropper('destroy');
                this.data.src = '';
            },

            submit() {
                axios.post(`/users/${this.model.id}/avatar`, $.extend(this.data, this.cropper.cropper('getData')))
                    .then(({data}) => {
                        $(`#avatar-modal`).modal('hide');

                        toastr.success(data.message);

                        this.avatar = data.avatar;
                    });
            },

            destroy() {
                if (! confirm(this.trans('developments.confirm_destroy'))) {
                    return;
                }

                axios.delete(`/users/${this.model.id}/avatar`)
                    .then(({data}) => {
                        toastr.success(data.message);

                        this.avatar = '/avatars/default.png';
                    })
            },

            replace() {
                $('#replace').click();
            },

            reset() {
                this.cropper.cropper('reset');
            },

            rotate(reg) {
                this.cropper.cropper('rotate', reg);
            },

            move(x, y) {
                this.cropper.cropper('move', x, y);
            },

            zoom(zoom) {
                this.cropper.cropper('zoom', zoom);
            },

            mode(mode) {
                this.cropper.cropper('setDragMode', mode);
            }
        }
    }
</script>
