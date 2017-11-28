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
        <panel-table-view :headers="headers" :rows="data" :permission="permission" />
        <div slot="footer">
            <panel-pagination size="is-small" :pager="pager" @update="refresh" />
        </div>
    </panel-content>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    props: {
    },
    computed: {
        headers() {
            return this.$store.getters['model/getHeaders']
        },
        permission() {
            return this.$store.getters['model/getPermissions']
        },
    },
    data () {
        return {
            data: {},
            links: {},
            pager: {},
        }
    },
    mounted() {
        this.getData(this.$route.params.blueprint)
    },
    methods: {
        getData(blueprint, p = false) {
            const page = !p ? '' :`?page=${p}`
            this.$http.get(`api/model/${ blueprint }/data${page}`)
                .then(response => {
                    this.data = response.data.data;
                    this.links = response.data.links;
                    this.pager = response.data.meta;
                });
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
