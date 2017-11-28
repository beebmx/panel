<template>
    <div>
        <p class="menu-label" v-text="title"></p>
        <ul class="menu-list">
            <li v-for="link in links">
                <router-link v-if="link.type === 'model'" :to="{name:'model.index', params: { blueprint: link.blueprint }}">
                    <panel-icon :icon="link.icon" /> {{ link.name }}
                </router-link>
            </li>
        </ul>
    </div>
</template>
    
<script>
export default {
    props: {
        title: {
            type: String,
            default: ''
        },
        links: {
            type: Array,
            default: {}
        },
        base: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
        }
    },
    methods: {
        getUrl(o) {
            return `/${ this.base }/${ o.type }/${ o.blueprint }`
        }
    }
}
</script>

<style lang="scss">
</style>