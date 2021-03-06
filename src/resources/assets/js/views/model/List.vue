<template>
    <panel-content>
        <div slot="header" class="columns is-multiline">
            <div class="column">
                <div class="field has-addons">
                    <div class="control is-expanded">
                        <input class="input" type="text" v-model="text" @keyup.enter="find" placeholder="Buscar registro(s)" />
                    </div>
                    <div class="control">
                        <panel-button design="is-primary" @click="find">Buscar</panel-button>
                    </div>
                </div>
            </div>
            <div v-if="permission.create" class="column is-3">
                <panel-button v-if="parent" design="is-primary is-fullwidth" :link="{name:'model.create', params: { parent: parent }}">Nuevo</panel-button>
                <panel-button v-else design="is-primary is-fullwidth" :link="{name:'model.create'}">Nuevo</panel-button>
            </div>
        </div>
        <panel-dataset-view />
        <div slot="footer">
            <panel-pagination size="is-small" @update="refresh" />
        </div>
        <panel-modal-card v-model="dialog">
            <div slot="header">¡Atención!</div>
            ¿Realmente quieres eliminar el registro?
            <div slot="footer">
                <panel-button design="is-white" @click="closeAsk">Cancelar</panel-button>
                <panel-button design="is-danger" @click="remove">Eliminar</panel-button>
            </div>
        </panel-modal-card>
    </panel-content>
</template>
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    computed: {
        ...mapGetters({
            pages: 'model/getPagination'
        }),
        permission() {
            return this.$store.getters['model/getPermissions']
        },
        blueprint() {
            return this.$route.params.blueprint;
        },
        parent() {
            return this.$route.params.parent ? this.$route.params.parent : false;
        },
        lastpage() {
            return this.pages.last_page
        }
    },
    data () {
        return {
            dialog: false,
            delete: false,
            page: false,
            text: '',
            search: '',
            searching: false
        }
    },
    created() {
        this.getData(this.blueprint, this.parent)
    },
    methods: {
        ...mapActions({
            deleteData: 'model/deleteData',
            getDataRows: 'model/getDataRows'
        }),
        getData(blueprint, parent, paginate = false, search = '') {
            this.getDataRows({blueprint, parent, paginate, search}).catch(({response}) => {
                if (response.status === 401) {
                    window.location = panel.baseURL;
                }
            });
            // this.$store.dispatch('model/getDataRows', {blueprint, parent, paginate, search})
        },
        refresh(page) {
            this.page = page
            this.getData(this.blueprint, this.parent, this.page, this.search)
        },
        ask(id) {
            this.delete = id;
            this.dialog = true;
        },
        closeAsk() {
            this.dialog = false;
            this.delete = false;
        },
        remove() {
            this.deleteData({type:this.type, id:this.delete}).then(() => {
                this.dialog = false;
                this.delete = false;
                this.getData(this.blueprint, this.parent, this.page, this.search)
            })
            .catch(response => {
                this.dialog = false;
                this.delete = false;
                console.log(response)
            })
        },
        find() {
            this.page = 1;
            this.search = this.text;
            this.getData(this.blueprint, this.parent, this.page, this.search)
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.text = '';
        this.search = '';
        this.getData(to.params.blueprint, to.params.parent)
        next()
    },
    watch: {
        lastpage() {
            if (this.page !== false && this.page > this.lastpage && this.lastpage !== 0) {
                this.page = this.lastpage;
                this.getData(this.blueprint, this.parent, this.page, this.search)
            }
        }
    }
}
</script>
