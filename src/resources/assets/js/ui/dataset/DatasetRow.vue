<template>
    <tr>
        <td v-for="(field, id) in headers" v-if="id !== 'panel_row_id'" :key="id" :class="{'is-hidden-mobile' : !field['mobile']}">
            <component
                v-bind="field"
                :is="field['cell']"
                :value="row[id]"
                :maxChars="field['maxCellChars']"></component>    
        </td>
        <td v-if="permission.update || permission.delete">
                <p class="field">
                    <panel-button v-if="permission.update && parent" design="is-link is-small" :link="{name:'model.edit', params: { id: row.panel_row_id, parent: parent }}">
                        <panel-icon icon="edit" />
                    </panel-button>
                    <panel-button v-if="permission.update && !parent" design="is-link is-small" :link="{name:'model.edit', params: { id: row.panel_row_id }}">
                        <panel-icon icon="edit" />
                    </panel-button>
                    <panel-button v-if="permission.delete" design="is-link is-small" @click="deleteRow(row.panel_row_id)">
                        <panel-icon icon="trash" />
                    </panel-button>
                </p>
        </td>
    </tr>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    props: {
        row: {
            type: [Array, Object]
        },
        maxCellChars: {
            type: String
        }
    },
    computed: {
        ...mapGetters({
            headers: 'model/getHeaders',
            permission: 'model/getPermissions',
        }),
        parent() {
            return this.$route.params.parent ? this.$route.params.parent : false;
        }
    },
    methods: {
        deleteRow(id) {
            this.$parent.$parent.$parent.$parent.ask(id);
        }
    },
    i18n: {
        messages: {
            es: {
                message: ''
            },
            en: {
                message: ''
            }
        }
    }
}
</script>

<style lang="scss">
</style>