<template>
    <div class="media my-5 text-left">
        <img :src="data.user.avatar" class="img-fluid mr-3 rounded-circle" alt="">

        <div class="media-body">
            <h6 class="mt-0 d-flex align-items-end">
                <div class="mr-auto">
                    <a :href="`/users/${data.user.id}`" v-text="data.user.name"></a>

                    <small class="text-muted ml-2">
                        {{ data.created_at | diffForHumans }}
                    </small>
                </div>

                <template v-if="canUpdate">
                    <div v-if="! editing" class="dropdown">
                        <a :id="`comment${data.id}Dropdown`" class="dropdown-toggle-split text-black-50" href="#"
                           role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fas fa-list-ul"></i>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" :aria-labelledby="`comment${data.id}Dropdown`">
                            <a class="dropdown-item py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="edit">
                                {{ trans('developments.edit') }}
                                <i class="fas fa-pen"></i>
                            </a>

                            <a class="dropdown-item text-danger py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="destroy">
                                {{ trans('developments.delete') }}
                                <i class="far fa-trash-alt"></i>
                            </a>
                        </div>
                    </div>
                </template>
            </h6>

            <div v-if="editing">
                <div class="form-group mb-2">
                    <vue-tribute :options="tributeOptions">
                        <textarea v-model="form.body" :class="{ 'is-invalid': form.errors.has('body') }" class="form-control rounded-0 p-3" @keydown="form.errors.clear('body')" :placeholder="trans('comments.placehoder')"></textarea>
                    </vue-tribute>

                    <span v-if="form.errors.has('body')" class="invalid-feedback text-left" role="alert">
                        <strong v-text="form.errors.get('body')"></strong>
                    </span>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary mr-1" @click="submit" v-text="trans('developments.edit')"></button>
                    <button type="button" class="btn btn-outline-primary" @click="cancel" v-text="trans('developments.cancel')"></button>
                </div>
            </div>

            <div v-else class="small" v-html="form.body.replace(/(?:\r\n|\r|\n)/g, '<br>')"></div>
        </div>
    </div>
</template>

<script>
    import Form from '../core/Form';

    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },

        data() {
            return {
                form: new Form({ body: this.data.body }),
                editing: false
            };
        },

        mounted() {
            this.$el.addEventListener('animationend', () => this.$el.remove());
        },

        filters: {
            /**
             * 주어진 날짜를 기준으로 몇일 후인지 반환합니다.
             *
             * @param   {string} date
             * @returns {string}
             */
            diffForHumans(date) {
                return moment(date).fromNow();
            }
        },

        computed: {
            /**
             * 사용자가 변경할수 있는 권한이 있는지 확인합니다.
             *
             * @returns {boolean}
             */
            canUpdate() {
                return this.authorize(auth => auth == this.data.user_id);
            }
        },

        methods: {
            /**
             * 변경 모드로 전환합니다.
             */
            edit() {
                this.editing = true;
                this.form.body = this.form.body.replace(/<\/?[^>]+(>|$)/g, '');
            },

            /**
             * 변경 내용을 저장합니다.
             */
            submit() {
                this.form.put(`/comments/${this.data.id}`)
                    .then(data => {
                        this.editing = false;
                        this.form = new Form({ body: data.comment.body });
                    });
            },

            /**
             * 변경 모드를 취소합니다.
             */
            cancel() {
                this.editing = false;
                this.form.revert();
            },

            /**
             * 댓글을 삭제합니다.
             */
            destroy() {
                if (! confirm(this.trans('developments.confirm_destroy'))) {
                    return;
                }

                this.form.delete(`/comments/${this.data.id}`)
                    .then(() => this.$el.classList.add('animated', 'fadeOut'));
            }
        }
    }
</script>