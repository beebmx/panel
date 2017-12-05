<template>
    <div>
        <panel-navbar />
        <div class="section">
            <div class="container panel-top-container">
                <div class="columns">
                <panel-sidebar class='column is-2-desktop' />
                <div class="column panel-pusher">
                    <slot />
                </div>
                </div>
            </div>
        </div>
        <vue-progress-bar></vue-progress-bar>
    </div>
</template>
    
<script>
export default {
    props: {
        loading: {
            type: Boolean,
            default: false
        },
    },
    data () {
        return {
        }
    },
    methods: {
    },
    watch: {
        loading(ld) {
            if (ld) {
                this.$Progress.start()
            } else {
                this.$Progress.finish()
            }
        }
    }
}
</script>
