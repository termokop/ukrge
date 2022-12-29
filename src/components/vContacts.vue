<template>
    <div class="content">
        <p class="center">{{dictionaryModal.contacts.title[language]}}:</p>
        <div :class="{logoBox:widthLogoBox}" class="center">
            <a href="https://www.instagram.com/hruba.yurii/"  target="_blank"><img class="contacts" src="../assets/inst.svg" alt=""></a>
            <a href="https://t.me/termokop"  target="_blank"><img class="contacts" src="../assets/tl.svg" alt=""></a>
            <a href="https://www.facebook.com/termokop"  target="_blank"><img class="contacts" src="../assets/fb.svg" alt=""></a>
        </div>
        <p>
            Пишіть мені з приводу проблем, пропозицій та ідей. Залюбки вислухаю кожного.
        </p>
    </div>
</template>

<script>
import dictionaryModal from './dictionary/modals';
export default {
    name: 'vContacts',
    props: {
        language: String,
        widthLogoBox:String,
    },
    data() {
        return {
            dictionaryModal,
        }
    }
}

</script>

<style scoped>
.content {
    padding-left: 20px;
}

.contacts {
    width: 33%;
}
.logoBox {
    width: 200px;
}

</style>