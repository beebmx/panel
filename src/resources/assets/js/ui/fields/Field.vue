<template>
    <span>
        <slot />
    </span>
</template>
    
<script>
import props from './InputProps'

export default {
    mixins: [props],
    props: {
        
    },
    data () {
        return {
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
</style>