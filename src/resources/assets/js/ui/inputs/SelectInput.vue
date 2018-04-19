<template>
    <div>
    <select
        :id="id"
        :name="id"
        :value="value"
        :disabled="disabled"
        @change="update">
        <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            :selected="selected(option.value)"
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
    methods: {
        selected(value) {
            return (this.value === value || (this.value === null && value === ''))
        },
        update(event) {
            this.$emit('input', event.target.value)
        }
    }
}
</script>
