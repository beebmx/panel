<template>
    <div class="panel-content">
        <div v-if="$slots.header" class="panel-content-header">
            <slot name="header" />
        </div>
        <div class="panel-content-data">
            <slot />
        </div>
        <div v-if="$slots.footer" class="panel-content-footer">
            <slot name="footer" />
        </div>
    </div>
</template>
<script>
export default {
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