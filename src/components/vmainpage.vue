<template>
    <div class="main">
      <div class="buttons" v-if="!openQuiz">
        <button  @click.prevent="choose('course')">{{dictionary.study[language]}}</button>
        <button  @click.prevent="choose('practice')">{{'Практикуватися'}}</button> 
        <button  @click.prevent="choose('temp')">{{'Вчити слова'}}</button>
        <button  @click.prevent="choose('temp')">{{'Знайти друзів'}}</button> 
        <button  @click.prevent="choose('settings')">{{dictionary.editProfile[language]}}</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="choose('about')">{{'Про проєкт'}}</button> 
        <button  @click.prevent="choose('help')">{{'Допомогти проєкту'}}</button> 
        <button  @click.prevent="this.$emit('logout')">{{dictionary.logout[language]}}</button> <!--реалізація кнопки виходу-->
    </div>

    <div class="content">
              <!--анкета користувача, яка автоматично з'являється при першому вході-->
        <vInputUserInfo
            v-if="whatIsContent === 'settings'"
            @canGoStudy="canStudyEmit"
            :language="language"
            >
        </vInputUserInfo> 

        <vCourse
            :language="language"
            v-if="whatIsContent === 'course'"
            >
        </vCourse>

        <vPractice
            :language="language"
            v-if="whatIsContent === 'practice'">
        </vPractice>

        <div class="about" v-if="whatIsContent==='about'">
            <h1>{{ dictionaryModal.history.title[language] }}</h1>
            <span v-html=" dictionaryModal.history.description[language]"></span>
        </div>

        <div class="help" v-if="whatIsContent==='help'">
            <h1>{{ dictionaryModal.help.title[language] }}</h1>
            <span v-html=" dictionaryModal.help.description[language]"></span>
        </div>

        <div class="templateComponent" v-if="whatIsContent==='temp'">
            <h1 class="center">
                Даний розділ ще в розробці...
            </h1>
            <p class="center">
                Ви можете пришвидшити розробку даного розділу вашими зусиллями, або фінансово :)
            </p>
            <div>
                <img src="../assets/tools.svg" alt="">
            </div>
        </div>
        </div>

    <div class="right-bar">
        <div>
            <p>Цікаві факти про Сакартвело:</p>
            <p><i>Гості – це божий дар, каже картвельське прислів'я. Тому іноземців тут завжди вітають горами їжі й питва.</i></p>
            <hr>
        </div>
        <div>
            <p class="center">{{dictionaryModal.contacts.title[language]}}:</p>
            <a href="https://www.instagram.com/hruba.yurii/"  target="_blank"><img class="contacts" src="../assets/inst.svg" alt=""></a>
            <a href="https://t.me/termokop"  target="_blank"><img class="contacts" src="../assets/tl.svg" alt=""></a>
            <a href="https://www.facebook.com/termokop"  target="_blank"><img class="contacts" src="../assets/fb.svg" alt=""></a>
            <p>Пишіть мені з приводу проблем, пропозицій та ідей. Залюбки вислухаю кожного.</p>
        </div>
    </div>
</div>


</template>

<script>
import vInputUserInfo from './vInputUserInfo.vue'
import dictionary from './dictionary/main.js'
import vCourse from './vCourse.vue'
import vPractice from './vPractice.vue'
import dictionaryModal from './dictionary/modals'

export default {
    name: "vMainPage",
    components: {
    vInputUserInfo,
    vCourse,
    vPractice,

  },
    props: {
        language: String
    },
    emits: ['logout','openQuiz'],
    data() {
        return {
            dictionary,
            dictionaryModal,
            userInfo: undefined,
            whatIsContent: 'course',
            canStudy: undefined,
            openQuiz: false,
        }
        
    },
    methods: {
        canStudyEmit(nickname) {
            this.canStudy = !nickname
        },
        choose(str) {
            this.whatIsContent = str
      },

    },
    created() {
        this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
    },
    computed: {
    }

}
 </script>

 <style scoped>

.main {
    display: flex;
}


.right-bar, .buttons {
    width: 15vw;
    padding: 10px;
    min-width: 150px;
}


.buttons button {
    width: 100%;
    margin-bottom: 5px;
}
.buttons button:hover{
    background-color: aqua;
}

.content {
    width: 65vw;
    margin: auto;
    height: 85vh;
    overflow-y: scroll;
    padding: 10px;
    color: #fff;
}

.content::-webkit-scrollbar {
  width: 0;
}

.right-bar {
    right: 0;
    border-left: 3px rgb(255, 255, 255) solid;
    color: white;
    display: flex;
    flex-wrap: wrap;
    align-content: space-around;
}
.buttons {
    border-right: 3px rgb(255, 255, 255) solid;
}
.templateComponent {
    height: 100%;
    display: flex;
    flex-wrap: wrap;
    align-content: space-around;
    color:#fff;
}
img {
    width: 35%;
}

.templateComponent div{
 width: 100%;
 display: flex;
 justify-content: center;
}

.contacts {
    width: 33%;
}
#threeot {
    display: none;
}

@media screen and (max-width: 1000px) {
    .right-bar {
        display: none;
    }
    .content {
        flex-grow: 1;
        padding: 0;
    }
}

@media screen and (max-width: 650px) {

    .content {
        position: relative;
        padding-bottom: 70px;
    }
    .buttons {
        position: fixed;
        bottom: 0;
        left: 0;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 50px;
        display: flex;
        flex-wrap: nowrap;
        justify-items: center;
        z-index: 3;
        overflow-x: scroll;
        border: 4px solid lightblue;
        background-color: lightblue;
        
    }

    .buttons button {
        bottom: 0;
        flex: 0 0 25%;;
        height: 100%;
        border: 2px solid lightblue;
        margin: 0;
        border-radius: 10px;
    }

}

</style>