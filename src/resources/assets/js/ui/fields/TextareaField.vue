<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id">
            <span v-text="label"></span>
            <abbr v-if="required" title="Required">*</abbr>
        </label>
        <div class="control">
            <panel-textarea-input v-bind="$props" v-model="data" />
        </div>
        <p v-if="error" class="help is-danger" v-text="error"></p>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>
    
<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        rows: {
            type: [Number, Boolean],
            default: false
        }
    },
    data () {
        return {
            data: this.value
        }
    },
    methods: {
    },
    watch: {
        value(value) {
            this.data = value
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data})
        }
    }
}
</script>
