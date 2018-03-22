<template>
    <nav class="panel-navbar navbar ">
        <div class="navbar-brand">
            <div class="navbar-burger burger" @click="toggle" :class="{'is-active':isOpen}">
                <span></span><span></span><span></span>
            </div>
            <router-link to="/" exact class="navbar-item has-logo">
                <figure class="navbar-image">
                    <img :src="logo" :alt="name" />
                </figure>
                <span class="navbar-title" v-text="name"></span>
                <!-- <span class="navbar-title is-hidden-touch" v-text="name"></span> -->
            </router-link>
        </div>
        
        <div class="navbar-menu">
            <div class="navbar-end">
                <a v-for="(link, index) in links" class="navbar-item" :key="index" :href="link.url" target="_blank">
                    <panel-icon :type="link.type" :icon="link.icon" />
                </a>
            </div>
        </div>
    </nav>
</template>
<script>
import { mapState } from 'vuex'
export default {
    computed: mapState({
        name: state => state.general.panel.name,
        logo: state => state.general.panel.logo,
        links: state => state.general.panel.links,
        isOpen: state => state.sidebar.isOpen
    }),
    methods: {
        toggle () {
            this.$store.dispatch('sidebar/toggle')
        }
    }
}
</script>

<style lang="scss">
</style>