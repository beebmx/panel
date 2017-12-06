export default {
    props: {
        id: {
            type: String,
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        value: {
            default: ''
        },
        placeholder: {
            type: [Boolean, String],
            default: false
        },
        required: {
            type: Boolean,
            default: false
        }, 
        readonly: {
            type: Boolean,
            default: false
        },
        disabled: {
            type: Boolean,
            default: false
        },
        autofocus: {
            type: Boolean,
            default: false
        },
        autocomplete: {
            type: [String, Boolean],
            default: 'off'
        },
        size: {
            type: [String, Boolean],
            default: false
        }
    }
}
