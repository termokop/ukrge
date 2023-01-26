<template>
<div class="content">
<div class="mistake">
    <button @click.prevent="showModalForMistake = true">Виявили помилку на цій сторінці? Натисніть тут</button>
</div>

<vModalErr v-if="showModalForMistake" @closeModal="showModalForMistake = false" :objInfo="objInfo"></vModalErr>

</div>
</template>

<script>
import vModalErr from './modalErr.vue';

export default {
    name: 'vDidUFindMistake',
    components: {
        vModalErr,
    },
    props: {
        objInfo: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {
            showModalForMistake: false,
        }
    },
    methods: {

    },
}
</script>

<style scoped>

.content {
    width: 100%;
}
.buttons, .mistake {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin: 3px;
    }

    .mistake button {
        width: fit-content;
        margin: auto;
        font-style: italic;
        text-decoration: underline;
        border: none;
        background-color: transparent;
        color: gray;
    }
    .mistake button:hover {
        color: grey;
    }

</style>