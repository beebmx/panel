<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id">
            <span v-text="label"></span>
            <abbr v-if="required" title="Required">*</abbr>
        </label>
        <div class="control" :class="{'has-icons-right':icon}">
            <panel-text-input v-bind="$props" v-model="data" />
            <span v-if="icon" class="icon is-small is-right">
                <panel-icon :icon="icon" />
            </span>
        </div>
        <p v-if="error" class="help is-danger" v-text="error"></p>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>
    
<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        icon: {
            default: 'percent'
        },
        type: {
            default: 'number'
        }
    },
    data () {
        return {
            data: this.value
        }
    },
    watch: {
        value(value) {
            this.data = value*100
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data/100 })
        }
    }
}
</script>
