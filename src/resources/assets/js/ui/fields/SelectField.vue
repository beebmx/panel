<template>
    <panel-field v-bind="$props">
        <label class="label" :for="id" v-text="label"></label>
        <div class="control" :class="[size, design, {'has-icons-left':icon}]">
            <div class="select is-fullwidth">
                <panel-select-input
                    v-bind="$props"
                    v-model="data"
                    :options="rows">
                </panel-select-input>
            </div>
            <span v-if="icon" class="icon is-small is-left">
                <panel-icon :icon="icon" />
            </span>
        </div>
        <p v-if="help" class="help" v-text="help"></p>
    </panel-field>
</template>

<script>
import field from '../props/field'
import props from '../props/input'
import { mapGetters, mapActions } from 'vuex'

export default {
    mixins: [field, props],
    props: {
        options: {
            type: [Object, String]
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
    computed: {
        ...mapGetters({
            files: 'files/visible',
            filesByType: 'files/getByType'
        }),
        isParent() {
            return typeof this.options === 'string' && this.options === 'parent'
        },
        isObject() {
            return typeof this.options === 'object'
        }
    },
    data () {
        return {
            data: this.value,
            rows: []
        }
    },
    created() {
        this.resource()
    },
    methods: {
        ...mapActions({
            getParent: 'model/getParent',
        }),
        resource() {
            if (this.isParent) {
                const fields = this.query.text.split(this.query.separator || '|')
                this.getParent({model:this.parent.model, relationship:this.parent.relation}).then(resource => {
                    this.rows = [{
                        value: '',
                        text: 'Seleccione una opción',
                        disabled: true
                    }, ...resource.map((e) => {
                        const value = e.id, text = fields.map((f) => {
                            return e[f]
                        }).join(' ');
                        return {value, text}
                    })]
                })
            } else if (this.isObject) {
                this.rows = [{
                    value: '',
                    text: 'Seleccione una opción',
                    disabled: true
                }, ..._.map(this.options, (e, i) => {
                    return {value:i, text:e}
                })]
            }
        },
        input (data) {
            this.data = data
        }
    },
    watch: {
        value(value) {
            this.data = value
        },
        data () {
            if (this.isParent) {
                this.$emit('input', {id:this.id, value:parseInt(this.data, 10)})
            } else {
                this.$emit('input', {id:this.id, value:this.data})
            }
        },
        files () {
            if (!this.isParent && !this.isObject) {
                this.rows = [{
                    value: '',
                    text: 'Seleccione una opción',
                    disabled: true
                }, ..._.map(this.filesByType(this.options), e => {
                    return {value:e.filename, text:e.filename}
                })]
                if (!_.find(this.rows, ['value', this.data])) {
                    // console.log('data set null')
                    this.data = null
                    // console.log(this.data, !!_.find(this.rows, ['value', this.data]), _.find(this.rows, ['value', this.data]))
                }
            }
        }
    }
}
</script>
