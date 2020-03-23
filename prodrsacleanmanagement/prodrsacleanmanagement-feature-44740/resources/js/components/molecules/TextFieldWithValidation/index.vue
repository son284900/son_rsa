<template>
    <div>
        <div class="form-group" :class="{ 'form-group--error': $v.editedItem.cleaningshiftcode.$error }">
            <v-text-field
                v-model="$v.editedItem.cleaningshiftcode.$model"
                :label="$tc('ShiftMaster.DialogField.CleaningShiftCode')"
                maxlength="3"
                :disabled="disableCode"
            />
        </div>
        <div class="error" v-if="!$v.editedItem.cleaningshiftcode.required">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'TextFieldWithValidation',
    data() {
        return {}
    },
    props: {
        name:{
            require: true,
            type: String,
            default: ''
        },
        model:{
            require: true,
            type: String,
            default: ''
        },
        input: {
            require: false,
            type: String,
            default: ''
        },
        hint: {
            require: false,
            type: String,
            default: ''
        },
        label: {
            require: true,
            type: String,
            default: ''
        },
        maxlength: {
            require: false,
            type: Number,
            default: null
        },
        errors: {
            type: Object,
            default: () => ({ if: "", message: "" }),
        },
    },
}
</script>
