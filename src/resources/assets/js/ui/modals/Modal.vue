<template>
    <div class="modal" :class="{'is-active':active}">
        <div class="modal-background" @click.stop="hide"></div>
        <div class="modal-content">
            <slot />
        </div>
        <button v-if="close" class="modal-close is-large" @click.stop="hide" aria-label="close"></button>
    </div>
</template>
    
<script>
export default {
    props: {
        value: {
            type: Boolean,
            default: false
        },
        close: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            active: this.value,
            w: document.documentElement
        }
    },
    methods: {
        hide() {
            this.active = false
            this.$emit('input', this.active)
        },
        closeOnEsc (event) {
            if (event.keyCode === 27) {
                this.hide()
            }
        }
    },
    watch: {
        value(value) {
            this.active = value
            if (this.active) {
                document.addEventListener('keyup', this.closeOnEsc);
            } else {
                document.removeEventListener('keyup', this.closeOnEsc);
            }
        },
        active(value) {
            if (value) {
                this.w.classList.add('is-clipped')
            } else {
                this.w.classList.remove('is-clipped')
            }
        }
    }
}
</script>
