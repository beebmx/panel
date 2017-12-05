<template>
    <panel-field v-bind="$props">
        <div class="control" :class="{'has-icons-left':icon}">
            <div class="select is-fullwidth">
                <panel-select-input
                    v-bind="$props"
                    v-model="data"
                    :options="resource()">
                </panel-select-input>
            </div>
            <span v-if="icon" class="icon is-small is-left">
                <panel-icon :icon="icon" />
            </span>
        </div>
    </panel-field>
</template>

<script>
import props from '../props/input'
import { mapGetters, mapActions } from 'vuex'

export default {
    mixins: [props],
    props: {
        options: {
            type: [Array, String]
        },
        parent: {
            type: [Array, Object]
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
            relationship: 'model/getRelationship',
        })
    },
    data () {
        return {
            data: this.value
        }
    },
    methods: {
        resource() {
            if (this.options === 'parent' && this.relationship(this.parent.relation)) {
                const fields = this.query.text.split(this.query.separator || '|')
                return [{
                    value: '',
                    text: 'Seleccione una opción',
                    disabled: true
                }, ...this.relationship(this.parent.relation).map((e) => {
                    const value = e.id, text = fields.map((f) => {
                        return e[f]
                    }).join(' ');
                    return {value, text}
                })]
            } else if (typeof this.options === 'array') {
                return this.options
            } else {
                return []
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
            this.$emit('input', {id:this.id, value:this.data})
        }
    }
}
</script>
