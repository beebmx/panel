<template>
    <panel-layout>
        <router-view></router-view>
    </panel-layout>
</template>
<script>
import { mapState } from 'vuex'

export default {
    props: {
    },
    data () {
        return {
        }
    },
    methods: {
        getModel(blueprint) {
            this.$store.dispatch('model/setModel', blueprint);
        }
    },
    mounted() {
        this.getModel(this.$route.params.blueprint)
    },
    beforeRouteUpdate (to, from, next) {
        this.getModel(to.params.blueprint)
        next()
    }
}
</script>
