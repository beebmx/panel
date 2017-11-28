<template>
    <tbody>
        <panel-table-row v-for="(row, id) in rows" :key="id" :headers="headers" :row="row" :permission="permission" />
        <!-- <tr v-for="row in rows">
            <td v-for="(field, id) in row" :class="{'is-hidden-mobile' : !headers[id]['mobile']}">
                <component :is="headers[id]['cell']" :mobile="headers[id]['mobile']" :value="field"></component>
            </td>
            <td v-if="permission.update || permission.delete">
                    <p class="field">
                        <a v-if="permission.update" class="button is-link is-small">
                            <panel-icon icon="edit" />
                        </a>
                        <a v-if="permission.delete" class="button is-link is-small">
                            <panel-icon icon="trash" />
                        </a>
                    </p>
            </td>
        </tr> -->
    </tbody>
</template>
<script>
export default {
    components: {

    },
    props: {
        headers: {
            type: Object
        },
        rows: {
            type: [Array, Object]
        },
        permission: {
            type: Object
        }
    },
    computed: {
        
    },
    data () {
        return {
        }
    },
    methods: {
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