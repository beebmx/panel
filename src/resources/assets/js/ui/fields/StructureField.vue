<template>
    <panel-field v-bind="$props">
        <div class="columns is-mobile">
            <div class="column">
                <label class="label" v-text="label"></label>
            </div>
            <div class="column is-4-mobile is-3-tablet is-2-desktop has-text-right">
                <panel-button size="is-small" @click="add">
                    <panel-icon-layer>
                        <panel-icon-element icon="circle" size="is-small" />
                        <panel-icon-element icon="plus" size="is-small" transform="shrink-6" />
                    </panel-icon-layer>
                    <span>Agregar</span>
                </panel-button>
            </div>
        </div>
        <div class="control-field">
            
        </div>
        <p v-if="help" class="help" v-text="help"></p>
        <panel-modal-card v-model="visible">
            <div slot="header" v-text="label"></div>

            <component v-for="(field, index) in fields"
                       v-bind="field"
                       :key="index"
                       :id="`structure-${id}-${index}`"
                       :is="`panel-${field.type}-field`"
                       :value="row[index]"
                       @input="update"></component>
            <div slot="footer">
                <panel-button design="is-white" @click="close()">Cancelar</panel-button>
                <panel-button design="is-primary" @click="save()">Guardar</panel-button>
            </div>
        </panel-modal-card>
    </panel-field>
</template>
    
<script>
import field from '../props/field'
import input from '../props/input'

export default {
    mixins: [field, input],
    props: {
        fields: {
            type: [Object, Array],
            default: null
        }
    },
    computed: {
        empty() {
            return _.mapValues(this.fields, () => {
                return ''
            });
        }
    },
    data () {
        return {
            data: this.value,
            current: 0,
            row: {},
            visible: false
        }
    },
    mounted() {
        if (this.data === '') {
            this.data = []
        }
    },
    methods: {
        add() {
            this.visible = true
            this.current = this.data.length
            this.row = _.mapValues(this.fields, () => {
                return ''
            });
            console.log(this.row)
        },
        update(data) {
            this.row[this.getField(data.id)] = data.value
        },
        save() {
            // this.$emit('input', {id:this.id, value:this.data})
            this.visible = false
        },
        close() {
            this.visible = false;
        },
        getField(field) {
            return field.substr((this.id.length + 11))
        }
    },
    watch: {
        value(value) {
            this.data = value
        },
        // data() {
        //     this.$emit('input', {id:this.id, value:this.data})
        // }
    }
}
</script>
