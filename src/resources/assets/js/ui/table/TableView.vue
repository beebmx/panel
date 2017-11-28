<template>
    <table class="table table-data is-fullwidth">
        <panel-table-header />
        <panel-table-body />
    </table>
</template>
    
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    // props: {
    //     headers: {
    //         type: Object,
    //         required: true
    //     },
    //     rows: {
    //         type: [Array, Object],
    //         required: true
    //     },
    //     permission: {
    //         type: Object,
    //         required: true
    //     }
    // },
    computed: {
        ...mapGetters({
            headers: 'model/getHeaders',
        })
        // headers() {
        //     return this.$store.getters['model/getHeaders']
        // },
        // permission() {
        //     return this.$store.getters['model/getPermissions']
        // },
    },
}
</script>
