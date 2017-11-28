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
