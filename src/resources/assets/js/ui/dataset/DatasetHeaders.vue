<template>
    <thead>
        <tr>
            <th v-for="(header, index) in headers" :key="index" :class="{'is-hidden-mobile' : !header.mobile}" v-text="header.label"></th>
        </tr>
    </thead>
</template>
    
<script>
import { mapGetters, mapActions } from 'vuex'
export default {
    computed: {
        ...mapGetters({
            headers: 'model/getHeaders',
        })
    },
    // props: {
    //     headers: {
    //         type: Object
    //     }
    // }
}
</script>

<style lang="scss">
</style>