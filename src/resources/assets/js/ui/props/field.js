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
        value: {
            default: ''
        },
        name: {
            type: String,
            default: ''
        },
        help: {
            type: String,
            default: ''
        },
        required: {
            type: Boolean,
            default: false
        },
        error: {
            type: [Boolean, String],
            default: false
        },
        width: {
            type: [String, Number],
            default: 'full'
        }
    }
}
