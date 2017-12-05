<template>
    <div class="column" :class="getWidth">
        <div class="panel-field field">
            <label class="label" :for="id" v-text="label"></label>
            <slot />
            <p v-if="help" class="help" v-text="help"></p>
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