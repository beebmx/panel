<template>
    <tr>
        <!-- <td v-for="(field, id) in row" v-if="id !== 'model_row_id'" :class="{'is-hidden-mobile' : !headers[id]['mobile']}">
            <component :is="headers[id]['cell']" :mobile="headers[id]['mobile']" :value="field"></component>
        </td> -->
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
export default {
    props: {
        headers: {
            type: Object
        },
        row: {
            type: [Array, Object]
        },
        permission: {
            type: Object
        }
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