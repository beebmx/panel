<template>
    <tr>
        <td v-for="(field, id) in headers" v-if="id !== 'panel_row_id'" :key="id" :class="{'is-hidden-mobile' : !field['mobile']}">
            <component :is="field['cell']" :value="row[id]" :maxChars="field['maxCellChars']"></component>    
        </td>
        <td v-if="permission.update || permission.delete">
                <p class="field">
                    <panel-button v-if="permission.update" design="is-link is-small" :link="{name:'model.edit', params: { id: row.panel_row_id }}">
                        <panel-icon icon="edit" />
                    </panel-button>
                    <a v-if="permission.delete" class="button is-link is-small" @click.prevent="deleteRow(row.panel_row_id)">
                        <panel-icon icon="trash" />
                    </a>
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
        })
    },
    methods: {
        deleteRow(id) {
            console.log(`Delete ${id}`);
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