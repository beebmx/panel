<template>
    <panel-field v-bind="$props">
        <div class="control" :class="{'has-icons-right':icon}">
            <panel-text-input v-bind="$props" v-model="data" />
            <span v-if="icon" class="icon is-small is-right">
                <panel-icon :icon="icon" />
            </span>
        </div>
    </panel-field>
</template>
    
<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        icon: {
            default: 'key'
        },
        type: {
            default: 'password'
        }
    },
    data () {
        return {
            data: this.value
        }
    },
    methods: {
    },
    watch: {
        value(value) {
            this.data = value
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data})
        }
    }
}
</script>
