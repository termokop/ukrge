<template>
    <div class="main">
      <div class="buttons">
        <button id="user"  @click.prevent="choose('settings')"><img class="prifilePicture" :src="picture" alt=""> <span class="userName">Привіт, {{userName}}</span></button>
        <button  @click.prevent="choose('course')"><img class="logoBtn" src="../assets/study.svg" alt=""> <span class="textBtn">{{dictionary.study[language]}}</span></button>
        <button  @click.prevent="choose('practice')"><img class="logoBtn" src="../assets/practice.svg" alt=""> <span class="textBtn">{{'Практикуватися'}}</span></button> 
        <button  @click.prevent="choose('temp')"><img class="logoBtn" src="../assets/st_words.svg" alt=""> <span class="textBtn">{{'Вчити слова'}}</span></button>
        <button  @click.prevent="choose('temp')"><img class="logoBtn" src="../assets/comun.svg" alt=""> <span class="textBtn">{{'Знайти друзів'}}</span></button> 
        <button  @click.prevent="choose('about')"><img class="logoBtn" src="../assets/about.svg" alt=""> <span class="textBtn">{{'Про проєкт'}}</span></button> 
        <button  @click.prevent="choose('help')"><img class="logoBtn" src="../assets/donate.svg" alt=""> <span class="textBtn">{{'Допомогти проєкту'}}</span></button> 
        <button  @click.prevent="this.$emit('logout')"><img class="logoBtn" src="../assets/logout.svg" alt=""> <span class="textBtn">{{dictionary.logout[language]}}</span></button> <!--реалізація кнопки виходу-->
    </div>

    <div class="content">
        <vInputUserInfo
            v-if="whatIsContent === 'settings'"
            :language="language"
            >
        </vInputUserInfo> 

        <vCourse
            :language="language"
            v-if="whatIsContent === 'course'"
            @start_quiz="start_quiz"
            >
        </vCourse>

        <vPractice
            @start_quiz="start_quiz"
            :language="language"
            v-if="whatIsContent === 'practice'">
        </vPractice>

        <div class="about" v-if="whatIsContent==='about'">
            <h1>{{ dictionaryModal.history.title[language] }}</h1>
            <span v-html=" dictionaryModal.history.description[language]"></span>
            <vContacts :language="language" :widthLogoBox="'60px'"></vContacts>
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
            <p><i>Гості — це божий дар, каже картвельське прислів'я. Тому іноземців тут завжди вітають горами їжі й питва.</i></p>
            <hr>
        </div>
        

        <vContacts :language="language"></vContacts>
    </div>
</div>


</template>

<script>
import vInputUserInfo from './vInputUserInfo.vue'
import dictionary from './dictionary/main.js'
import vCourse from './vCourse.vue'
import vPractice from './vPractice.vue'
import dictionaryModal from './dictionary/modals'
import vContacts from './vContacts.vue'

export default {
    name: "vMainPage",
    components: {
    vInputUserInfo,
    vCourse,
    vPractice,
    vContacts

  },
    props: {
        language: String
    },
    emits: ['logout','start_quiz'],
    data() {
        return {
            dictionary,
            dictionaryModal,
            userInfo: undefined,
            whatIsContent: 'course',
            picture: localStorage.getItem('picture'),
            userName: JSON.parse(localStorage.getItem('userInfo')).name,
        }
        
    },
    methods: {
        start_quiz(arr, show_hints, lesson) {
            this.$emit('start_quiz', arr, show_hints, lesson)
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
}


.buttons button {
    width: 100%;
    margin-bottom: 5px;
    display: flex;
    justify-content: start;
    flex-wrap: wrap;
    align-items: center;
    align-content: center;
}
.buttons button:hover{
    background-color: aqua;
}

.content {
    width: 65vw;
    height: 100vh;
    overflow-y: scroll;
    padding: 10px;
    padding-bottom: 100px;
    color: #fff;
    margin: auto;
    margin-top: 0;
}

.showBelowMenu {
    height: 100vh;
    overflow-y: scroll;
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
    min-width: 280px;
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

#user {
    display: flex;
    flex-wrap: wrap;
    height: 80px;
    width: fit-content;
    margin: auto;
    background-color: transparent;
}

.prifilePicture{
    border-radius: 50%;
    height: 40px;
    width: 40px;
    padding: 0;
    margin: 0;
    margin: auto;
}
.userName {
    width: 100%;
    margin: auto;
    color: #fff;
}

.logoBtn {
    height: 100%;
    padding: 0;
    margin: 0;
}
.textBtn {
    width: fit-content;
}

@media screen and (max-width: 1000px) {
    .right-bar {
        display: none;
    }
    .content {
        flex-grow: 1;
    }
}

@media screen and (max-width: 700px) {


    .showBelowMenu {
        height: 85vh;
    }

    .buttons {
        position: fixed;
        bottom: 0;
        left: 0;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 80px;
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
        /* border: 2px solid lightblue; */
        background-color: transparent;
        margin: 0;
        border-radius: 10px;
    }

    .textBtn {
        display: none;
    }
    .logoBtn {
        width: 50%;
        margin: auto;
    }

}

</style>