<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id">
            <span v-text="label"></span>
            <abbr v-if="required" title="Required">*</abbr>
        </label>
        <div class="control" :class="haveColumns('columns')">
            <div class="field" :class="haveColumns('column')" v-for="(option, i) in resource()" :key="option">
                <input class="is-checkradio " :id="id+'-'+option" :value="i" type="checkbox" v-model="data">
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
import { mapGetters } from 'vuex'

export default {
    mixins: [field, input],
    props: {
        options: {
            type: [Array, String, Object]
        },
        parent: {
            type: [Array, Object, Boolean]
        },
        query: {
            type: Object,
            default: () => {
                return {
                    separator: '|',
                    text: 'name'
                }
            }
        }
    },
    data () {
        return {
            data: []
        }
    },
    computed: {
        isHorizontal(){
            return this.align === 'horizontal'
        },
        ...mapGetters({
            relationship: 'model/getRelationship',
        })
    },
    methods :{
        haveColumns (type){
            if (type==="columns"){
                return this.isHorizontal ? 'columns is-multiline' : ''
            }else{
                return this.isHorizontal ? 'column is-narrow' : ''
            }
        },
        resource() {
            if (this.options === 'parent' && this.relationship(this.parent.relation)) {
                const fields = this.query.text.split(this.query.separator || '|')
                const list = this.relationship(this.parent.relation).map((e) => {
                    const value = e.id, text = fields.map((f) => {
                        return e[f]
                    });
                    return {[value] : text.toString() }
                })
                let obj = {}
                list.forEach (function (item){
                    Object.keys(item).forEach(function(key) {
                        obj[key] = item[key]
                    });
                })
                return obj
            } else if (typeof this.options === 'object') {
                return this.options
            } else {
                return []
            }
        }
    },
    watch: {
        value(value) {
            this.data = value.split(',')
        },
        data() {
            this.$emit('input', {id:this.id, value:((this.data).filter(Boolean)).toString() })
        }
    }
}
</script>