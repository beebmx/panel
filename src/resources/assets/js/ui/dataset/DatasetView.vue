<template>
    <table class="table table-data is-fullwidth">
        <panel-dataset-header />
        <panel-dataset-body />
    </table>
</template>
    
<script>
import { mapGetters } from 'vuex'
export default {
    computed: {
        ...mapGetters({
            headers: 'model/getHeaders',
        })
    },
}
</script>
