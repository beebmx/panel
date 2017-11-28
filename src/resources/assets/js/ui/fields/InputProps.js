export default {
    props: {
        'label': {
            type: String,
            default: ''
        }, 
        'icon': {
            default: false
        }, 
        'name': {
            type: String,
            default: ''
        },
        'value': {
            type: String,
            default: ''
        },
        'placeholder': {
            type: String,
            default: ''
        },
        'required': {
            type: Boolean,
            default: false
        }, 
        'readonly': {
            type: Boolean,
            default: false
        },
        'autofocus': {
            type: Boolean,
            default: false
        },
        'autocomplete': {
            type: [String, Boolean],
            default: 'off'
        },
        'help': {
            type: String,
            default: ''
        },
        'type': {
            type: String,
            default: 'text'
        }
    }
}
