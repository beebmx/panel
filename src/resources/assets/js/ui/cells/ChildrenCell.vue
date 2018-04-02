<template>
    <panel-button design="is-link is-small" :link="{name:'model.index', params: { parent: value, blueprint: blueprint }}">
        <panel-icon v-if="icon" :icon="icon" />
    </panel-button>
</template>
<script>
import { mapGetters, mapActions } from 'vuex';
export default {
    props: {
        id: {
            type: String
        },
        value: {
            type: Number
        }
    },
    computed: {
        ...mapGetters({
            current: 'model/getCurrentBlueprint'
        })
    },
    data () {
        return {
            icon: false,
            blueprint: false
        }
    },
    mounted() {
        this.getIcon(this.id).then(icon => {
            this.icon = icon;
        });
        this.getBlueprint(this.id).then(blueprint => {
            this.blueprint = blueprint;
        });
    },
    methods: {
        ...mapActions({
            getIcon: 'model/getFieldIcon',
            getBlueprint: 'model/getChildrenBlueprint'
        })
    }
}
</script>
