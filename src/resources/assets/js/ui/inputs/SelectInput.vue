<template>
    <div>
    <select
        :id="id"
        :name="id"
        :value="value"
        @change="update">
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
            // data: this.value,
        }
    },
    methods: {
        update(event) {
            this.$emit('input', event.target.value)
        }
    }
}
</script>
