<template>
    <quill-editor ref="richtext"
                  :content="value"
                  :options="richtextOption"
                  @change="update($event)">
    </quill-editor>
</template>
    
<script>
import { quillEditor } from 'vue-quill-editor'
import props from '../props/input'

export default {
    mixins: [props],
    components: {
        quillEditor
    },
    props: {
        toolbar: {
            default: () => {
                return [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{'header': 1}, {'header': 2}],
                    [{'list': 'ordered'}, {'list': 'bullet'}],
                    [{'align': [] }],
                    ['clean'],
                    ['link', 'image', 'video']
                ]
            }
        }
    },
    computed: {
        editor() {
            return this.$refs.richtext.quill
        }
    },
    data () {
        return {
            richtextOption: {
                placeholder: this.placeholder,
                modules: {
                    toolbar: this.toolbar
                },
            }
        }
    },
    methods: {
        update({ quill, html, text }) {
            this.$emit('input', html)
        }
        
    }
}
</script>
