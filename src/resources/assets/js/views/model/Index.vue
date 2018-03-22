<template>
    <panel-layout :loading="loading" :files="allowFiles">
        <router-view></router-view>
    </panel-layout>
</template>
<script>
import { mapState, mapGetters, mapMutations } from 'vuex'

export default {
    computed: {
        ...mapState({
            loading: state => state.model.loading,
        }),
        ...mapGetters({
            allowFiles: 'model/allowFiles'
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
