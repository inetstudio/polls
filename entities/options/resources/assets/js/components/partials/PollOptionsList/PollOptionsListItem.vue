<template>
    <li>
        <div class="row">
            <div class="col-10">
                <span class="m-l-xs">{{ option.model.answer }}</span>
            </div>
            <div class="col-2">
                <div class="float-right">
                    <a href="#" class="btn btn-xs btn-default edit-option m-r-xs" v-on:click.prevent.stop="editOption"><i class="fa fa-pencil-alt"></i></a>
                    <a href="#" class="btn btn-xs btn-danger delete-option" v-on:click.prevent.stop="removeOption"><i class="fa fa-times"></i></a>
                </div>
                <input :name="'options[' + option.model.id + '][id]'" type="hidden" :value="option.model.id">
                <input :name="'options[' + option.model.id + '][answer]'" type="hidden" :value="option.model.answer">
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        name: 'PollOptionsListItem',
        props: {
            option: {
                type: Object,
                required: true
            }
        },
        methods: {
            editOption() {
                window.Admin.vue.stores['pollOptions'].commit('setMode', 'edit_list_item');

                let option = JSON.parse(JSON.stringify(this.option));
                option.isModified = false;

                window.Admin.vue.stores['pollOptions'].commit('setOption', option);

                $('#options_list_item_form_modal').modal();
            },
            removeOption() {
                this.$emit('remove', {
                    id: this.option.model.id,
                });
            }
        }
    }
</script>

<style scoped>
</style>
