<template>
    <span v-text="plain" />
</template>
    
<script>
export default {
    props: {
        value: {
            type: String
        },
        maxChars: {
            type: Number,
            default: 20
        }
    },
    computed: {
        plain() {
            const plain = String(this.value || ''),
                  value = plain.substr(0, this.maxChars);
            return value.length < plain.length ? value.concat('...') :  value;
        }
    }
}
</script>
