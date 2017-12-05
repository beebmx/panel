<template>
    <button type="button" class="button" :class="design" :disabled="disabled" @click="click">
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
        design: {
            type: String,
            default: ''
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