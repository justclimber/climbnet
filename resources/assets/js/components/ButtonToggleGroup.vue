<template>
    <div class="input-group input-group--text-field input-group--dirty">
        <label><slot>Select</slot>{{ selectedValue }}</label>
        <v-btn-toggle
            class="buttons-grouped"
            :value="value"
            @change="$emit('input', $event)"
        >
            <v-btn v-for="item in items" :key="item.value" :value="item.value">
                <span v-if="useShortLabels">{{ shortLabel(item.text) }}</span>
                <span v-else="useShortLabels">{{ item.text }}</span>
            </v-btn>
        </v-btn-toggle>
    </div>
</template>
<script>
    export default {
        props: ['items', 'value', 'useShortLabels'],
        computed: {
            selectedValue() {
                if (this.value) {
                    for (let i = 0; i < this.items.length; i ++) {
                        if (this.value === this.items[i].value) {
                            return ': ' + this.items[i].text;
                        }
                    }
                }
                return '';
            }
        },
        data() {
            return {
            }
        },
        methods: {
            select(event) {
                this.$emit('update', event);
            },
            shortLabel(text) {
                let firstLetter = text.match(/\b(\w)/g).join('');
                if (firstLetter.length > 1) {
                    return firstLetter;
                }

                if (/[aeiou]$/.test(text.substr(0, 3))) {
                    return text.substr(0, 2);
                }

                return text.substr(0, 3);
            },
        },
    }
</script>
<style lang="scss">
    div.buttons-grouped.btn-toggle {
        margin: 5px 0 10px 0;
        width: 100%;
        display: flex;
        justify-content: space-around;
        button.btn {
            min-width: 4rem;
            opacity: 1;
            span {
                color: #000000;
            }
        }
    }
</style>