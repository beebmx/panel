<template>
    <tbody>
        <panel-dataset-row v-for="(row, id) in rows" :key="id" :row="row" />
    </tbody>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    computed: {
        ...mapGetters({
            rows: 'model/getRows'
        })
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