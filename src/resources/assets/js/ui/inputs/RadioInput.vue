<template>
        <input class="is-checkradio"
            :class="[size, design]"
            type="radio"
            :name="id"
            :id="id+'-'+value"
            :value="value"
            :required="required"
            :readonly="readonly"
            :disabled="disabled"
            :checked="ischecked"
            @change="update"/>
</template>

<script>
import props from '../props/input'

export default {
    mixins: [props],
    model: {
        prop: 'data',
        event: 'change'
    },
    computed:{
        ischecked(){
            return this.$parent.$parent.data == this.value
        }    
    },
    methods: {
        update(event) {
            this.$emit('change', this.value )
        }
    }
}
</script>