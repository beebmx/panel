export default {
    props: {
        id: {
            type: String,
            default: ''
        },
        label: {
            type: String,
            default: ''
        },
        icon: {
            type: [Boolean, String],
            default: false
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
        autofocus: {
            type: Boolean,
            default: false
        },
        autocomplete: {
            type: [String, Boolean],
            default: 'off'
        },
        help: {
            type: String,
            default: ''
        },
        type: {
            type: String,
            default: 'text'
        },
        width: {
            type: [String, Number]
        }
    }
}
