<template>
    <panel-content>
        FORMULARIO
    </panel-content>
</template>
<script>
import { mapGetters } from 'vuex'
export default {
    props: {
    },
    computed: {
    },
    data () {
        return {
            data: {}
        }
    },
    mounted() {
        //this.getData(this.$route.params.blueprint)
    },
    methods: {
        getData(blueprint) {
            // this.$http.get(`api/model/${ blueprint }/data`)
            //     .then(response => {
            //         this.data = response.data.data;
            //     });
        }
    },
    beforeRouteUpdate (to, from, next) {
        //this.getData(to.params.blueprint)
        next()
    }
}
</script>
