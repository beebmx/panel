<template>
    <button type="button"
            class="button"
            :class="[size, design, {'is-loading':loading}, {'is-selected':selected}]"
            :disabled="disabled" @click="click">
        <span class="panel-button-text"><slot /></span>
    </button>
</template>
<script>
export default {
    props: {
        link: [String, Object],
        upload: Boolean,
        disabled: {
            type: Boolean,
            default: false
        },
        size: {
            type: [String, Boolean],
            default: false
        },
        design: {
            type: [String, Boolean],
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        loading: {
            type: Boolean,
            defalt: false
        },
        selected: {
            type: Boolean,
            defalt: false
        },
        control: {
            default: false
        }

    },
    methods: {
        click: function () {
            if (this.link) {
                this.$router.push(this.link)
            }
            this.$emit('click')
        },
    }
}
</script>

<style lang="scss">
</style>