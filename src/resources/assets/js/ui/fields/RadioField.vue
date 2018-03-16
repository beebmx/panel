<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id">
            <span v-text="label"></span>
            <abbr v-if="required" title="Required">*</abbr>
        </label>
        <div class="control" :class="haveColumns('columns')">
            <div class="field" :class="haveColumns('column')" v-for="option in options" :key="option">
                <panel-radio-input v-bind="$props" :value="option" v-model="data"/> 
                <label :for="id+'-'+option" v-text="option"></label>
            </div>
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
        options: {
            type: [Object]
        },
    },
    data () {
        return {
            data: this.value
        }
    },
    computed :{
        isHorizontal(){
            return this.align === 'horizontal'
        }
    },
    methods :{
        haveColumns (type){
            if (type==="columns"){
                return this.isHorizontal ? 'columns is-multiline' : ''
            }else{
                return this.isHorizontal ? 'column is-narrow' : ''
            }
        }
    },
    watch: {
        value(value) {
            this.data = value
        },
        data() {
            this.$emit('input', {id:this.id, value:this.data })
        }
    }
}
</script>
