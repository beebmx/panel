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
        error: {
            type: String,
            default: ''
        },
        width: {
            type: [String, Number]
        }
    }
}
