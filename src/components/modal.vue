<template>
    <div class="bg" @click="$emit('closeModal')"></div>
    <div class="modal">
        <h1>{{objForModal?.title}}</h1>
        <div class='description'>
            <span v-html="objForModal?.description"> </span>
        </div>
        <button @click="$emit('closeModal')">{{dictionaryModal.btn[language]}}</button>
    </div>


</template>

<script>
import dictionaryModal from './dictionary/modals';

export default {
    name: 'vModal',
    props: {
        objForModal: Object,
        language: String,
    },
    emits: ['closeModal'],
    data() {
        return {
            dictionaryModal
        }
    },
    methods: {
        copy(info) {
            alert(info)
        }
    }
}

</script>

<style scoped>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-size: 16px;
}

.bg{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 200%;
  opacity: 50%;
  background-color: black;
  z-index: 2;
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    width: 600px;
    border: 1px solid white;
    background-color: aliceblue;
    z-index: 3;
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    border-radius: 30px;
    padding: 10px;
}

h1, .description {
    width: 90%;
}

h1 {
    font-size: 18px;
}
h2 {
    font-size: 16px;
}

button {
    width: 300px;
    color: white;
    background-color: #1d1d1d;
}

@media screen and (max-width: 600px) {
    .modal {
        width: 95vw;
        font-size: 14px;
    }
}

</style>