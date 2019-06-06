<template>
    <div>
        <div v-if="status" class="alert alert-success" role="alert" v-text="status"></div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right" v-text="trans('validation.attributes.email')"></label>

            <div class="col-md-6">
                <input id="email" type="email" :class="emailInputClasses" @keydown="form.errors.clear('email')" v-model="form.email" autocomplete="email" autofocus>

                <span v-if="form.errors.has('email')" class="invalid-feedback" role="alert">
                    <strong v-text="form.errors.get('email')"></strong>
                </span>
            </div>
        </div>

        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="button" :class="submitButtonClasses" @click="submit" v-html="submitButtonContent"></button>
            </div>
        </div>
    </div>
</template>

<script>
    import Form from '../core/Form';

    export default {
        name: "PasswordEmail",

        data() {
            return {
                status: '',
                form: new Form({ email: '' }),
                sending: false
            };
        },

        methods: {
            submit() {
                if (this.sending) {
                    return;
                }

                this.sending = true;
                this.status = '';

                this.form.post('/password/email')
                    .then(data => this.status = data.status)
                    .finally(() => this.sending = false);
            }
        },

        computed: {
            emailInputClasses() {
                return ['form-control', this.form.errors.has('email') ? 'is-invalid' : ''];
            },

            submitButtonClasses() {
                return ['btn', 'btn-primary', this.sending ? 'disabled' : ''];
            },

            submitButtonContent() {
                return this.sending
                    ? `<i class="fas fa-spinner fa-pulse mr-2"></i> ${this.trans('auth.sending')}`
                    : this.trans('auth.passwords.send');
            }
        }
    }
</script>
