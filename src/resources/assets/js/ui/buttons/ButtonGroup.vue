<template>
    <div class="buttons has-addons" :class="[align]">
        <slot />
    </div>
</template>
<script>
export default {
    props: {
        align: {
            default: null
        }
    }
}
</script>
