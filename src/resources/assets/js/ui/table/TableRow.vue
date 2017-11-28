<template>
    <tr>
        <td v-for="(field, id) in headers" v-if="id !== 'panel_row_id'" :key="id" :class="{'is-hidden-mobile' : !field['mobile']}">
            <component :is="field['cell']" :value="row[id]"></component>    
        </td>
        <td v-if="permission.update || permission.delete">
                <p class="field">
                    <a v-if="permission.update" class="button is-link is-small" :href="editRow(row.panel_row_id)">
                        <panel-icon icon="edit" />
                    </a>
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
    },
    computed: {
        ...mapGetters({
            headers: 'model/getHeaders',
            permission: 'model/getPermissions',
        })
    },
    methods: {
        editRow(id) {
            return `${this.permission.url}/${id}/edit`
        },
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