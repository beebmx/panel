<template>
    <div class="panel-dropzone">
        <div v-show="dragging" class="overlay">{{ label }}</div>
    </div>
</template>
<script>
export default {
    props: {
        label: {
            type: String,
            default: 'Arrastra los archivos aquí'
        },
        accept: {
            type: String,
            default: '*'
        },
    },
    data () {
        return {
            error: false,
            dragging: false,
            files: []
        }
    },
    mounted() {
        window.addEventListener('dragover', this.start, false);
        window.addEventListener('dragleave', this.stop, false);
        window.addEventListener('drop', this.drop, false);
    },
    destroy() {
        window.removeEventListener('dragover', this.start, false);
        window.removeEventListener('dragleave', this.stop, false);
        window.removeEventListener('drop', this.drop, false);
    },
    methods: {
        start (e) {
            this.prevent(e);
            this.error = '';
            this.dragging = true;
            document.documentElement.classList.add('is-clipped')
        },
        stop (e) {
            this.prevent(e);
            this.dragging = false;
            document.documentElement.classList.remove('is-clipped')
        },
        drop (e) {
            this.prevent(e);
            this.dragging = false;
            let files = e.target.files || e.dataTransfer.files;
            document.documentElement.classList.remove('is-clipped')
            if(this.validate(files)) {
                this.files = files;
                this.$root.$emit('dropfile', files)
            }
        },
        validate(files) {
            if (this.accept !== '*') {
                for (var i = 0; i < files.length; i++) {
                    if (files[i].type !== this.accept) {
                        this.error = 'File type not allowed';
                        return false;
                    }
                }
            }
            return true
        },
        prevent (e) {
            e.stopPropagation();
            e.preventDefault();
        },
    }
}
</script>
