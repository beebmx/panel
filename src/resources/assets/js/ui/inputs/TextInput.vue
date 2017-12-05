<template>
    <input class="input"
            :type="type"
            :id="id"
            :name="id"
            :value="value"
            :placeholder="placeholder"
            :required="required"
            :readonly="readonly"
            :autofocus="autofocus"
            :autocomplete="autocomplete"
            @input="update"
    />
</template>
    
<script>
import props from '../props/input'

export default {
    mixins: [props],
    data () {
        return {
            // data: this.value,
        }
    },
    methods: {
        update(event) {
            // this.data = event.target.value
            this.$emit('input', event.target.value)
        }
    },
    // watch: {
    //     value(value) {
    //         this.data = value
    //     }
    // }
}
</script>
