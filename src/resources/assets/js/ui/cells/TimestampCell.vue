<template>
    <span v-text="date" />
</template>
    
<script>
import moment from 'moment'

export default {
    props: [
        'value'
    ],
    computed: {
        date() {
            if (typeof this.value === 'Object') {
                return moment(this.value.date).format('YYYY-MM-DD');
            } else {
                return this.value;
            }
        }
    }
}
</script>

<style lang="scss">
</style>