<template>
    <tr>
        <td v-text="data.id"></td>
        <td class="text-left">
            <input v-if="editing" type="text" class="form-control" v-model="form.name" @keypress.enter="update" :placeholder="trans('validation.attributes.name')" required autocomplete="name" autofocus>

            <span v-else v-text="form.name"></span>
        </td>
        <td v-text="data.mentions"></td>
        <td>{{ data.created_at | dateFormat('Y. M. D') }}</td>
        <td>
            <div v-if="editing">
                <a href="#" class="text-black-50 h4 mb-0" @click.prevent="update">
                    <i class="fas fa-upload"></i>
                </a>

                <a href="#" class="text-black-50 h4 ml-2 mb-0" @click.prevent="cancel">
                    <i class="far fa-window-close"></i>
                </a>
            </div>

            <div v-else>
                <a href="#" class="text-black-50 h4 mb-0" @click.prevent="edit">
                    <i class="far fa-edit"></i>
                </a>

                <a href="#" class="text-black-50 h4 ml-2 mb-0" @click.prevent="destroy">
                    <i class="far fa-trash-alt"></i>
                </a>
            </div>
        </td>
    </tr>
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
                editing: false,
                form: new Form({ name: this.data.name }),
                endpoint: `${location.pathname}/${this.data.id}`
            };
        },

        methods: {
            edit() {
                this.editing = true;
            },

            update() {
                this.form.put(this.endpoint)
                    .then(() => this.editing = false)
                    .catch(data => _.forEachRight(data.errors, error => error.forEach(message => toastr.error(message))));
            },

            cancel() {
                this.editing = false;
                this.form.revert();
            },

            destroy() {
                if (! confirm(this.trans('developments.confirm_destroy'))) {
                    return;
                }

                this.form.delete(this.endpoint)
                    .then(() => this.$emit('delete', this.data.id));
            }
        }
    }
</script>
