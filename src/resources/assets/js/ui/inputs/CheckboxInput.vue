<template>
    <input class="is-checkradio"
        :class="[design]"
        type="checkbox"
        :id="id"
        :name="id"
        :checked="value"
        @change="update"
    />
</template>

<script>
import props from '../props/input'

export default {
    mixins: [props],
    props: {
        design: {
            type: [String],
            default: ''
        }
    },
    methods: {
        update(event) {
            this.$emit('input', event.target.checked)
        }
    }
}
</script>
