<template>
    <panel-field v-bind="$props">
        <panel-checkbox-input v-bind="$props" v-model="data" />    
        <label class="label" :for="id" v-text="label"></label>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>
    
<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        type: {
            default: 'text'
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
