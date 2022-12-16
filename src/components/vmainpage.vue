<template>
      <!-- <h1>{{dictionary.title[language]}}</h1> -->
      <div class="buttons" v-if="!openQuiz">
        <button  @click.prevent="showEditeProfile" v-if="!showEdit" >{{dictionary.editProfile[language]}}</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="showEditeProfile" v-if="showEdit" >{{dictionary.study[language]}}</button> <!--реалізація кнопки виходу ------:disabled="canStudy"-->
        <button  @click.prevent="this.$emit('logout')">{{dictionary.logout[language]}}</button> <!--реалізація кнопки виходу-->
        
    </div>
      
      <!--анкета користувача, яка автоматично з'являється при першому вході-->
      <vInputUserInfo  
        v-if="showEdit" 
        @canGoStudy="canStudyEmit"
        :language="language"
        >
    </vInputUserInfo> 

    <studyMenu
    @openQuiz="openQuizFn"
        :language="language"
        v-if="!showEdit"
        >
    </studyMenu>


</template>

<script>
import vInputUserInfo from './vInputUserInfo.vue'
import dictionary from './dictionary/main.js'
import studyMenu from './vStudyMenu.vue'

export default {
    name: "vMainPage",
    components: {
    vInputUserInfo,
    studyMenu

  },
    props: {
        language: String
    },
    emits: ['logout','openQuiz'],
    data() {
        return {
            dictionary,
            userInfo: undefined,
            showEdit: false,//!this.userInfo?.nickname,
            canStudy: undefined,
            openQuiz: false,
        }
        
    },
    methods: {
        openQuizFn(bool) {
            this.openQuiz = bool
        },
        canStudyEmit(nickname) {
            this.canStudy = !nickname
        },
      showEditeProfile() {
        this.showEdit = !this.showEdit
      },

    },
    created() {
        this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
        //this.showEdit = !this.userInfo?.nickname
        //this.canStudy = !this.userInfo.nickname
    },
    computed: {
    }

}
 </script>

 <style scoped>

h1 {
    text-shadow: 1px 1px 2px rgb(159, 159, 159), 0 0 1em rgb(0, 0, 0), 0 0 0.5em rgb(0, 0, 0);
    color: #fff;
    width: fit-content;
    margin: auto;
    font-size: 16px;
}
button {
    width: fit-content;
    height: fit-content;
    margin: 10px;
    font-size: 16px;
    border-radius: 25px;
    background-color: transparent;
    border: none;
    color: #fff;
    text-decoration: overline 1px  #fff;
    text-decoration-line: underline;
}

.buttons {
    width: fit-content;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
}

</style>