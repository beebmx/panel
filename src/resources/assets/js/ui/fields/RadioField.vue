<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id" v-text="label"></label>
            <div class="control">
                <label class="radio" v-for="option in options" :key="option">
                    <panel-radio-input v-bind="$props" :value="option" v-model="data"/> {{option}} 
                </label>
            </div>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>

<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        options: {
            type: [Object]
        },
    },
    data () {
        return {
            data: this.value
        }
    },
    watch: {
        value(value) {
            this.data = value
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data })
        }
    }
}
</script>
