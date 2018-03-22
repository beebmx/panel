<template>
    <textarea
        class="textarea"
        :class="[size, design]"
        :id="id"
        :name="id"
        spellcheck="false"
        :placeholder="placeholder"
        :required="required"
        :readonly="readonly"
        :disabled="disabled"
        :rows="rows"
        :value="value"
        @input="update"></textarea>
</template>
    
<script>
import props from '../props/input'

export default {
    mixins: [props],
    props: {
        rows: {
            type: [Number, Boolean],
            default: false
        },
    },
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
