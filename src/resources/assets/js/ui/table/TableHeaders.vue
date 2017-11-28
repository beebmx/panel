<template>
    <thead>
        <tr>
            <th v-for="header in headers" :class="{'is-hidden-mobile' : !header.mobile}" v-text="header.label"></th>
        </tr>
    </thead>
</template>
    
<script>
export default {
    components: {

    },
    props: {
        headers: {
            type: Object
        }
    }
}
</script>

<style lang="scss">
</style>