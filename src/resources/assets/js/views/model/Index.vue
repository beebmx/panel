<template>
    <panel-layout :loading="loading">
        <router-view></router-view>
    </panel-layout>
</template>
<script>
import { mapState, mapMutations } from 'vuex'

export default {
    computed: {
        ...mapState({
            loading: state => state.model.loading,
        })
    },
    methods: {
        ...mapMutations({
            updateRelationships: 'model/MODEL_RELATIONSHIPS',
            updateData: 'model/MODEL_RECORD'
        }),
        getModel(blueprint) {
            this.updateData({});
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
