<template>
    <div>
    <select
        :id="id"
        :name="id"
        v-model="data">
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            :selected="value === option.value"
            :disabled="option.disabled"
            v-text="option.text"></option>
    </select>
    </div>
</template>
    
<script>
import props from '../props/input'

export default {
    mixins: [props],
    props: {
        options: {
            default: []
        },
    },
    data () {
        return {
            data: this.value,
        }
    },
    watch: {
        // data () {
        //     this.$emit('input', this.data)
        // },
        // value(value) {
        //     this.data = value
        // }
    }
}
</script>
