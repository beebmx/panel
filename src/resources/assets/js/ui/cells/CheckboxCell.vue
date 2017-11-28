<template>
    <span class="panel-checkbox-cell">
        <i v-if="drawable" class="fal" :class="checkbox" />
    </span>
</template>
    
<script>
export default {
    props: {
        value : {
            type: Boolean
        }
    },
    computed: {
        checkbox() {
            return this.value ? 'fa-check' : 'fa-times'
        },
        drawable() {
            return typeof this.value !== 'undefined' ? true : false;
        }
    }
}
</script>
