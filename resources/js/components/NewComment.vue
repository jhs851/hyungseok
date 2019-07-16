<template>
    <div>
        <template v-if="user.hasVerifiedEmail">
            <div class="form-group mb-4">
                <vue-tribute :options="$parent.tributeOptions">
                    <textarea id="foobar" v-model="form.body" :class="{ 'is-invalid': form.errors.has('body') }" class="form-control rounded-0 p-3" @keydown="form.errors.clear('body')" :placeholder="trans('comments.placehoder')"></textarea>

                    <span v-if="form.errors.has('body')" class="invalid-feedback text-left" role="alert">
                        <strong v-text="form.errors.get('body')"></strong>
                    </span>
                </vue-tribute>
            </div>

            <div class="form-group">
                <button type="button" @click.prevent="store" class="btn btn-outline-primary rounded-0 px-4 font-weight-bold" v-text="trans('comments.create')"></button>
            </div>
        </template>

        <p v-else v-html="trans('comments.please_verified')"></p>
    </div>
</template>

<script>
    import Form from '../core/Form';

    export default {
        data() {
            return {
                form: new Form({ body: '' })
            };
        },

        methods: {
            /**
             * 새로운 리소스를 저장소에 저장합니다.
             */
            store() {
                this.form.post(`${location.pathname}/comments`)
                    .then((data) => {
                        this.form.reset();

                        this.$emit('store', data.comment);
                    });
            }
        }
    }
</script>
