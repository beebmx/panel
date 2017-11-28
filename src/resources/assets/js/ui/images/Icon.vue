<template>
    <span class="icon">
        <i :class="[getType, getIcon]"></i>
    </span>
</template>
<script>
export default {
    props: {
        icon: {
            type: String,
            required: true
        },
        type: {
            type: String,
            default: 'fal'
        }
    },
    computed: {
        getType() {
            return this.type
        },
        getIcon() {
            return `fa-${this.icon}`
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
</style>