<template>
    <input class="input"
            :class="[size, design, {'is-danger':error}]"
            :type="type"
            :id="id"
            :name="id"
            :value="value"
            :placeholder="placeholder"
            :required="required"
            :readonly="readonly"
            :disabled="disabled"
            :autofocus="autofocus"
            :autocomplete="autocomplete"
            @input="update"
    />
</template>
    
<script>
import props from '../props/input'

export default {
    mixins: [props],
    props: {
        type: {
            type: String,
            default: 'text'
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
