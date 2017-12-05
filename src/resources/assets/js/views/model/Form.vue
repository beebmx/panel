<template>
    <panel-content>
        <div slot="header" class="columns is-multiline">
            <div class="column">
                FORMULARIO
            </div>
            <div class="column is-1">
                <panel-icon icon="spinner-third" :spin="true" />
            </div>
        </div>
        <div class="columns is-multiline">
            <component v-for="(field, index) in fields"
                       v-if="field.field"
                       v-bind="field"
                       :key="field.id"
                       :is="field.field"
                       :value="data[field.id]"
                       @input="update"></component>
        </div>
        <div slot="footer" class="columns">
            <div class="column has-text-right">
                <panel-button design="is-white" :link="{name:'model.index'}">Cancelar</panel-button>
                <panel-button design="is-primary" :link="{name:'model.create'}">Guardar</panel-button>
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
        blueprint() {
                return this.$route.params.blueprint;
        },
        ...mapGetters({
            fields: 'model/getFields',
            data: 'model/getDataFields'
        })
    },
    data () {
        return {
            id: false
        }
    },
    mounted() {
        if (this.$route.params.id) {
            this.id = this.$route.params.id;
        }
        this.getData({ blueprint: this.blueprint, id:this.id })
    },
    methods: {
        ...mapActions({
            getData: 'model/getData'
        }),
        ...mapMutations({
            updateField: 'model/MODEL_UPDATE_FIELD'
        }),
        update(data) {
            this.updateField({ id:data.id, value:data.value })
        }
    },
    beforeRouteUpdate (to, from, next) {
        this.id = to.params.id;
        this.getData(to.params.blueprint, this.id)
        next()
    }
}
</script>
