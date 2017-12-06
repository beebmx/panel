<template>
    <div class="column" :class="getWidth">
        <div class="panel-field field">
            <slot />
        </div>
    </div>
</template>
    
<script>
import field from '../props/field'
export default {
    mixins: [field],
    data () {
        return {
            getWidth: `is-${this.width}`
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
</style>