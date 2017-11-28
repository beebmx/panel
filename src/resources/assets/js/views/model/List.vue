<template>
    <panel-content>
        <div slot="header" class="columns is-multiline">
            <div class="column">
                SEARCH
            </div>
            <div v-if="permission.create" class="column is-3">
                <panel-button design="is-primary is-fullwidth" :link="{name:'model.create'}">Nuevo</panel-button>
            </div>
        </div>
        <panel-table-view />
        <div slot="footer">
            <panel-pagination size="is-small" @update="refresh" />
        </div>
    </panel-content>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    computed: {
        permission() {
            return this.$store.getters['model/getPermissions']
        },
    },
    mounted() {
        this.getData()
        this.getData(this.$route.params.blueprint)
    },
    methods: {
        getData(blueprint, paginate = false) {
            this.$store.dispatch('model/getDataRows', {blueprint, paginate})
        },
        refresh(page) {
            this.getData(this.$route.params.blueprint, page)
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.getData(to.params.blueprint)
        next()
    }
}
</script>
