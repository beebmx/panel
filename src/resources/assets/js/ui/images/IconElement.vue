<template>
    <i :class="[getType, getIcon, getSpin, getPulse, {'fa-inverse':inverse}]"
        :data-fa-transform="transform"
        :data-fa-mask="mask"
        v-text="text"></i>
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
        },
        pulse: {
            type: Boolean,
            default: false
        },
        transform: {
            type: [String, Object],
            default: null
        },
        mask: {
            type: [Object, Array, String],
            default: null
        },
        size: {
            type: String,
            default: null,
        },
        text: {
            type: String,
            default: null,
        },
        inverse: {
            type: Boolean,
            default: null
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
        },
        getPulse() {
            return this.spin ? 'fa-pulse' : false
        }
    },
    methods: {
    }
}
</script>

<style lang="scss">
</style>