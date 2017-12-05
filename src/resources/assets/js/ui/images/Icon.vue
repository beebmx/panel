<template>
    <span class="icon">
        <i :class="[getType, getIcon, getSpin]"></i>
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
        },
        spin: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        getType() {
            return this.type
        },
        getIcon() {
            return `fa-${this.icon}`
        },
        getSpin() {
            return this.spin ? 'fa-spin' : false
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
</style>