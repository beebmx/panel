<template>
    <table class="table table-data is-fullwidth">
        <panel-table-header :headers="headers" />
        <panel-table-body :headers="headers" :rows="rows" :permission="permission" />
    </table>
</template>
    
<script>
export default {
    props: {
        headers: {
            type: Object,
            required: true
        },
        rows: {
            type: [Array, Object],
            required: true
        },
        permission: {
            type: Object,
            required: true
        }
    }
}
</script>
