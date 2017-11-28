<template>
    <div class="panel-menu" :class="{'is-active':isOpen}">
        <aside class="menu">
            <ul class="menu-list">
                <li>
                    <router-link to="/" exact>
                        <panel-icon icon="tachometer" /> Dashboard
                    </router-link>
                </li>
            </ul>
            <panel-sidebar-list v-for="(links, index) in options" :base="base" :key="index" title="Catálogos" :links="links" />
        </aside>
        <div class="overlay"></div>
    </div>
</template>
    
<script>
import { mapState } from 'vuex'
import store from '../store'
import PanelSidebarList from './SidebarList.vue'

export default {
    store,
    components: { PanelSidebarList },
    computed: mapState({
        base: state    => state.general.panel.base,
        isOpen: state  => state.sidebar.isOpen,
        options: state => state.sidebar.list,
    }),
    data () {
        return {
        }
    },
    methods: {
        closeSideBarIfOpen (event) {
            const e = event.target,
                    hasPanelCurrent = e.classList.contains('panel-menu'),
                    hasPanelParent = e.parentNode.classList.contains('panel-menu');
            
            if (!hasPanelCurrent && !hasPanelParent) {
                store.dispatch('sidebar/close');
            }
        },
        closeSideBarOnEsc (event) {
            if (event.keyCode === 27) {
                store.dispatch('sidebar/close');
            }
        }
    },
    beforeDestroy() {
        document.removeEventListener('click', this.closeSideBarIfOpen);
        document.removeEventListener('keyup', this.closeSideBarOnEsc);
    },
    watch: {
        isOpen: function (val) {
            if (val) {
                document.addEventListener('click', this.closeSideBarIfOpen);
                document.addEventListener('keyup', this.closeSideBarOnEsc);
            } else {
                document.removeEventListener('click', this.closeSideBarIfOpen);
                document.removeEventListener('keyup', this.closeSideBarOnEsc);
            }
        }
    }
}
</script>

<style lang="scss">
</style>