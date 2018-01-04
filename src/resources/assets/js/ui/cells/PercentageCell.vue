<template>
    <span v-text="percent" />
</template>
    
<script>
export default {
    props: {
        value: {
            type: String
        }
    },
    computed: {
        percent() {
            const value = this.value*100
            return String(value).concat('% ');
        }
    }
}
</script>
