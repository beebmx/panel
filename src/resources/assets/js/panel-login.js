import Vue from 'vue'

new Vue({
    el: '#login',
    data: {
        form: null
    },
    methods: {
        send() {
            this.form.submit();
        }
    },
    mounted() {
        this.form = this.$refs.form;
    },
    beforeDestroy() {
    }
})
