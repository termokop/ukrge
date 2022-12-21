<template>
    <vModal  
        v-if="showModal" 
        :objForModal="objForModal"
        @closeModal="showModal = !showModal"
        :language="language"
        ></vModal>
     <div class="footer">
        <ul class="list">
            <li class="list-item">
                <button @click.prevent="showInfo([this.dictionaryModal.history.title[this.language], this.dictionaryModal.history.description[this.language]])">{{dictionary.about[language]}}</button>
            </li>
            <li class="list-item">
                <button @click.prevent="showInfo([this.dictionaryModal.contacts.title[this.language], this.dictionaryModal.contacts.description[this.language]])">{{dictionary.cooper[language]}}</button>
            </li>
            <li class="list-item">
                <button @click.prevent="showInfo([this.dictionaryModal.help.title[this.language], this.dictionaryModal.help.description[this.language]])" >{{dictionary.something[language]}}</button>
            </li>
        </ul>
      </div>
</template>

<script>
import dictionary from './dictionary/footer';
import vModal from './modal.vue';
import dictionaryModal from './dictionary/modals'

export default {
    name: 'vFooter',
    components: {
        vModal
    },
    props: {
        language: String
    },
    data() {
        return {
            dictionaryModal,
            showModal: false,
            objForModal: {},
            dictionary,
        }
    },
    methods: {
        showInfo(info) {
            this.objForModal.title = info[0]
            this.objForModal.description = info[1]
            this.showModal = !this.showModal
        }
    }
}


</script>


<style scoped> 
    .footer {
        width: fit-content;
        margin: auto;
        height: 45px;
    }
    .list {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-wrap: wrap-reverse;
        margin: 5px;
        padding: 0;
        
    }
    .list-item {
        display: inline;
        margin: 10px;
        justify-content: center;
        align-content: center;
        font-size: 13px;
        background-color: rgba(0, 0, 200, 0.4);
        border-radius: 5px;
        padding: 5px;
    }
    a{
        color: rgb(255, 255, 255);
        text-decoration: none;
    }
    button {
        background-color: transparent;
        border: none;
        color: #fff;
    }
</style>