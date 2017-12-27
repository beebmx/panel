<template>
    <input class="is-checkradio"
        :class="[size, design]"
        type="checkbox"
        :id="id"
        :name="id"
        :checked="value"
        :disabled="disabled"
        @change="update"
    />
</template>

<script>
import props from '../props/input'

export default {
    mixins: [props],
    methods: {
        update(event) {
            this.$emit('input', event.target.checked)
        }
    }
}
</script>
