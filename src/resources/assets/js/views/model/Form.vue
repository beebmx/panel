<template>
    <panel-content>
        <div slot="header" class="columns is-multiline">
            <div class="column">
                <div class="title is-4" v-text="name"></div>
            </div>
            <div class="column is-1 has-text-right">
                <panel-icon v-if="processing" icon="spinner-third" :spin="true" />
            </div>
        </div>
        <div class="columns is-multiline">
            <component v-for="field in fields"
                       v-if="field.field"
                       v-bind="field"
                       :key="field.id"
                       :is="field.field"
                       :value="data[field.id]"
                       :error="error(field.id)"
                       @input="update"></component>
        </div>
        <panel-files-manager ref="files" v-if="allowFiles" :url="upload" :search="!!id" />
        <div slot="footer" class="columns">
            <div class="column has-text-right">
                <panel-button v-if="parent" design="is-white" :link="{name:'model.index', params: { parent: parent }}">Cancelar</panel-button>
                <panel-button v-else design="is-white" :link="{name:'model.index'}">Cancelar</panel-button>
                <panel-button design="is-primary" :loading="processing" @click="save">Guardar</panel-button>
            </div>
        </div>
    </panel-content>
</template>
<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {
    props: [
        'type'
    ],
    computed: {
        ...mapGetters({
            fields: 'model/getFields',
            data: 'model/getDataFields',
            allowFiles: 'model/allowFiles',
            name: 'model/getName'
        }),
        blueprint() {
            return this.$route.params.blueprint;
        },
        parent() {
            return this.$route.params.parent ? this.$route.params.parent : false;
        },
        id() {
            return this.$route.params.id || false
        },
        upload() {
            return this.id ? `api/files/${this.blueprint}/${this.id}` : `api/files/${this.blueprint}`
        }
    },
    data () {
        return {
            processing: false,
            errors:false
        }
    },
    mounted() {
        this.getData({ blueprint: this.blueprint, id:this.id })
    },
    methods: {
        ...mapMutations({
            updateField: 'model/MODEL_UPDATE_FIELD'
        }),
        ...mapActions({
            getData: 'model/getData',
            saveData: 'model/saveData'
        }),
        update(data) {
            this.updateField({ id:data.id, value:data.value })
        },
        save() {
            this.processing = true;
            this.saveData({type:this.type, id:this.id, parent: this.parent}).then(data => {
                this.processing = false;
                this.errors = false;
                if (this.id === false) {
                    if (this.allowFiles) {
                        this.$refs.files.manage(`${this.upload}/${data.id}`)
                    }
                    if (this.parent) {
                        this.$router.push({name:'model.edit', params:{id:data.id, parent:this.parent}})
                    } else {
                        this.$router.push({name:'model.edit', params:{id:data.id}})
                    }
                } else {
                    if (this.allowFiles) {
                        this.$refs.files.manage(this.upload)
                    }
                }
            })
            .catch(response => {
                this.processing = false;
                this.errors = response.errors;
            })
        },
        error(id) {
            if (_.has(this.errors, id)) {
                return this.errors[id][0];
            }
            return false;
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.getData({ blueprint: to.params.blueprint, id:to.params.id })
        next()
    },
    beforeRouteLeave (to, from, next) {
        if (to.name === 'model.edit') {
            this.getData({ blueprint: to.params.blueprint, id:to.params.id })
        }
        next()
    }
}
</script>
