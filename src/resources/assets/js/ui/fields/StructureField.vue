<template>
    <panel-field class="is-structure-field" v-bind="$props">
        <div class="columns is-mobile is-multiline">
            <div class="column">
                <label class="label" v-text="label"></label>
            </div>
            <div v-if="canAdd" class="column is-4-mobile is-3-tablet is-2-desktop has-text-right">
                <panel-button size="is-small" @click="open">
                    <panel-icon-layer>
                        <panel-icon-element icon="circle" size="is-small" />
                        <panel-icon-element icon="plus" size="is-small" transform="shrink-6" />
                    </panel-icon-layer>
                    <span>Agregar</span>
                </panel-button>
            </div>
            <div class="column is-full">
                <div class="has-table">
                    <table class="table is-fullwidth is-hoverable is-narrow">
                        <thead>
                            <tr>
                                <th v-for="(r, i) in header()" :key="i" v-text="r"></th>
                                <th class="is-last"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in data" :key="index">
                                <td v-for="(r, i) in show(row)" :key="i" v-text="r"></td>
                                <td>
                                    <panel-button-group>
                                        <panel-button design="is-light" size="is-small" @click="open(index)">
                                            <panel-icon-element icon="edit" size="is-small" />
                                        </panel-button>
                                        <panel-button design="is-light" size="is-small" @click="ask(index)">
                                            <panel-icon-element icon="times" size="is-small" />
                                        </panel-button>
                                    </panel-button-group>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <p v-if="error" class="help is-danger" v-text="error"></p>
        <p v-if="help" class="help" v-text="help"></p>
        <panel-modal-card v-model="visible">
            <div slot="header" v-text="label"></div>
            <div class="columns is-multiline">
                <component v-for="(field, index) in fields"
                        v-bind="field"
                        :key="index"
                        :id="`structure-${id}-${index}`"
                        :is="`panel-${field.type}-field`"
                        :value="row[index]"
                        @input="update"></component>
            </div>
            <div slot="footer">
                <panel-button design="is-white" @click="close()">Cancelar</panel-button>
                <panel-button design="is-primary" @click="save()">Guardar</panel-button>
            </div>
        </panel-modal-card>
        <panel-modal-card v-model="dialog">
            <div slot="header" v-text="label"></div>
            ¿Realmente quieres eliminar el registro?
            <div slot="footer">
                <panel-button design="is-white" @click="closeAsk()">Cancelar</panel-button>
                <panel-button design="is-danger" @click="remove">Eliminar</panel-button>
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
        },
        limit: {
            type: Number,
            default: null
        }
    },
    computed: {
        display() {
            return _.reduce(this.fields, (obj, e, key) => {
                if (typeof e.list === 'undefined' || e.list) {
                    obj.push(key)
                }
                return obj
            }, [])
        },
        total() {
            return this.data.length
        },
        canAdd() {
            return this.limit === null || this.data.length < this.limit ? true : false
        },
    },
    data () {
        return {
            data: [],
            row: {},
            current: false,
            visible: false,
            dialog: false,
            deleted: false
        }
    },
    mounted() {
        this.parseData(this.value)
    },
    methods: {
        open(current = false) {
            if (current === false) {
                this.current = this.data.length
                this.row = _.mapValues(this.fields, () => {
                    return ''
                });
            } else {
                this.current = current
                this.row = _.clone(this.data[current])
            }
            this.visible = true
        },
        update(data) {
            this.row[this.getField(data.id)] = data.value
        },
        save() {
            if (this.current >= this.data.length) {
                this.data.push(this.row)
            } else {
                this.data[this.current] = this.row
            }
            this.$emit('input', {id:this.id, value:JSON.stringify(this.data)})
            this.visible = false
        },
        close() {
            this.visible = false;
        },
        getField(field) {
            return field.substr((this.id.length + 11))
        },
        show(row) {
            return this.display.map(key => {
                return row[key]
            })
        },
        header() {
            return this.display.map(key => {
                return this.fields[key].label
            })
        },
        ask(index) {
            this.dialog = true
            this.deleted = index
        },
        closeAsk() {
            this.dialog = false
        },
        remove() {
            this.data.splice(this.deleted, 1)
            this.$emit('input', {id:this.id, value:JSON.stringify(this.data)})
            this.dialog = false
        },
        parseData(value) {
            if (value === '' || value ===null) {
                this.data = []
            } else {
                this.data = JSON.parse(value)
            }
        }
    },
    watch: {
        value(val) {
            this.parseData(val)
        }
    }
}
</script>
