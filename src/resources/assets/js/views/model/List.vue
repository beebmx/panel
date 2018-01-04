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
        <panel-dataset-view />
        <div slot="footer">
            <panel-pagination size="is-small" @update="refresh" />
        </div>
    </panel-content>
</template>
<script>
export default {
    computed: {
        permission() {
            return this.$store.getters['model/getPermissions']
        },
        blueprint() {
            return this.$route.params.blueprint;
        }
    },
    created() {
        this.getData(this.blueprint)
    },
    methods: {
        getData(blueprint, paginate = false) {
            this.$store.dispatch('model/getDataRows', {blueprint, paginate})
        },
        refresh(page) {
            this.getData(this.blueprint, page)
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.getData(to.params.blueprint)
        next()
    }
}
</script>
