<template>
    <div>
        <v-select
            :label="label"
            @click.native="categoryDialog = true"
            v-bind:items="settings.dicts.categories"
            v-model="gradeSelected"
            readonly
        ></v-select>
        <v-dialog v-model="categoryDialog">
            <v-card>
                <v-container class="pb-0">
                    <h2 class="text-xs-center">Grade {{ grade }}</h2>
                    <div class="text-xs-center">
                        <v-btn-toggle v-model="gradeDigit" class="category-buttons">
                            <v-btn>4</v-btn>
                            <v-btn>5</v-btn>
                            <v-btn>6</v-btn>
                            <v-btn>7</v-btn>
                            <v-btn>8</v-btn>
                            <v-btn>9</v-btn>
                        </v-btn-toggle>
                    </div>
                    <div class="text-xs-center">
                        <v-btn-toggle v-model="gradeLetter" class="category-buttons">
                            <v-btn>a</v-btn>
                            <v-btn>b</v-btn>
                            <v-btn>c</v-btn>
                        </v-btn-toggle>
                        <v-btn-toggle
                            v-model="gradePlus"
                            class="category-buttons ml-3"
                        >
                            <v-btn>+</v-btn>
                        </v-btn-toggle>
                    </div>
                    <div class="text-xs-center">
                        <v-btn
                            color="primary"
                            flat="flat"
                            @click="submit"
                            large
                            :disabled="gradeDigit === null || gradeLetter === null"
                        >Ok</v-btn>
                    </div>
                </v-container>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
    import { mapState } from 'vuex';
    export default {
        props: ['label', 'value'],
        computed: {
            ...mapState(['settings']),
            grade() {
                if (this.gradeDigit == null) {
                    return '';
                }
                return this.gradeDigit + 4
                    + (this.gradeLetter !== null ? String.fromCharCode(65 + this.gradeLetter) : '')
                    + (this.gradePlus !== null ? '+' : '');
            }
        },
        data() {
            return {
                gradeDigit: null,
                gradeLetter: null,
                gradePlus: null,
                categoryDialog: false,
                gradeSelected: null,
            }
        },
        methods: {
            submit() {
                this.categoryDialog = false;
                let categories = this.settings.dicts.categories;
                for (let i = 0; i < categories.length; i++) {
                    if (categories[i].text === this.grade.toLowerCase()) {
                        this.gradeSelected = categories[i];
                        this.$emit('input', categories[i].value);
                        break;
                    }
                }
            }
        }
    }
</script>
<style lang="scss">
    .category-buttons {
        margin-bottom: 1rem;
        button.btn {
            width: 3.2rem;
        }
    }
</style>