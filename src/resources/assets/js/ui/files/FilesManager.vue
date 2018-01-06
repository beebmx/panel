<template>
    <div class="panel-files-manager panel-field">
        <div class="columns is-mobile is-multiline">
            <div class="column">
                <label class="label">Archivos</label>
            </div>
            <div class="column is-4-mobile is-3-tablet is-2-desktop has-text-right">
                <panel-button size="is-small" @click="open">
                    <panel-icon-element icon="upload" size="is-small" />
                    <span>Subir archivo</span>
                </panel-button>
                <input ref="input" class="panel-input-upload" tabindex="-1" type="file" @change="select">
                <!-- <input class="panel-input-upload" tabindex="-1" type="file" @change="select" :accept="options.accept" :multiple="options.multiple"> -->
            </div>
            <div class="column is-full has-progress">
            <transition name="progress-fade">
                <progress v-if="progress > 0" class="progress is-primary is-small" :value="progress" max="100">30%</progress>
            </transition>
            </div>
            <div class="column is-full">
                <div class="has-table">
                    <table class="table is-fullwidth is-hoverable is-narrow">
                        <thead>
                            <tr>
                                <th>Archivo</th>
                                <th class="is-last"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="file in files" :key="file.filename" v-if="file.status !== 'deleted'">
                                <td v-text="file.filename"></td>
                                <td>
                                    <panel-button design="is-light" size="is-small" @click="ask(file.filename)">
                                        <panel-icon-element icon="times" size="is-small" />
                                    </panel-button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <panel-modal-card v-model="dialog">
            <div slot="header">¡Atención!</div>
            ¿Realmente quieres eliminar el archivo?
            <div slot="footer">
                <panel-button design="is-white" @click="closeAsk">Cancelar</panel-button>
                <panel-button design="is-danger" @click="remove">Eliminar</panel-button>
            </div>
        </panel-modal-card>
    </div>
</template>
    
<script>
import { mapGetters, mapActions, mapMutations } from 'vuex'
export default {
    props: {
        url: {
            type: String,
            required: true,
            default: null
        },
        search: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        ...mapGetters({
            files: 'files/all',
            progress: 'files/getProgress'
        })
    },
    data () {
        return {
            dialog: false,
            current: false,
            processing: false,
            path: null
        }
    },
    mounted() {
        this.$root.$on('dropfile', this.save)
        this.path = this.url
        if (this.search) {
            this.remote(this.url)
        } else {
            this.reset({})
        }
    },
    methods: {
        ...mapActions({
            upload: 'files/upload',
            remote: 'files/remote',
            process: 'files/process',
            reverse: 'files/reverse'
        }),
        ...mapMutations({
            reset: 'files/FILES_SET',
            delete: 'files/FILES_DELETE'
        }),
        open() {
            this.$refs.input.click()
        },
        select(e) {
            this.save(e.target.files);
        },
        save(files) {
            this.upload({url:this.url, files:files})
        },
        ask(file) {
            this.dialog = true;
            this.current = file;
        },
        closeAsk() {
            this.dialog = false;
            this.current = null;
        },
        remove() {
            this.delete(this.current)
            this.dialog = false;
            this.current = null;
        },
        manage(url = false) {
            const remote = !url ? this.url : url
            this.processing = true
            this.process(remote).then(() => {
                this.processing = false
            })
        }
    },
    beforeDestroy() {
        if (! this.processing) {
            if (_.size(this.files)) {
                const url = !this.search ? `${this.url}/0` : this.url
                this.reverse(url)
            }
        }
    }
}
</script>
