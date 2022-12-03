<template>
      <h1>{{dictionary.title[language]}}, {{this.userInfo.name}}!</h1>
      <div class="buttons">
        <button  @click.prevent="showEditeProfile" v-if="!showEdit" >{{dictionary.editProfile[language]}}</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="showEditeProfile" v-if="showEdit" :disabled="canStudy" >{{dictionary.study[language]}}</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="this.$emit('logout')">{{dictionary.logout[language]}}</button> <!--реалізація кнопки виходу-->
        
    </div>
      
      <!--анкета користувача, яка автоматично з'являється при першому вході-->
      <vInputUserInfo  
        :userInfo="userInfo"
        v-if="showEdit" 
        @canGoStudy="canStudyEmit"
        :language="language"
        >
    </vInputUserInfo> 

    <studyMenu
        :language="language"
        v-if="!showEdit">
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
    emits: ['logout'],
    data() {
        return {
            dictionary,
            userInfo: undefined,
            showEdit: !this.userInfo?.nickname,
            canStudy: undefined
        }
        
    },
    methods: {
        canStudyEmit(nickname) {
            this.canStudy = !nickname
        },
        getCookies(cname) {
        //зччитування JWT ключа для перевірки валідації токена
        let name = cname + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(";");
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == " ") {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
      },
      showEditeProfile() {
        this.showEdit = !this.showEdit
      },

    },
    created() {
        this.userInfo = JSON.parse(this.getCookies('userInfo'))
        //console.log("U r this person:", JSON.parse(this.getCookies('userInfo')))
        this.showEdit = !this.userInfo?.nickname
        this.canStudy = !this.userInfo.nickname
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
}
button {
    width: 250px;
    height: 50px;
    margin: 10px;
    font-size: 1.2rem;
    border-radius: 10px;
}

.buttons {
    width: fit-content;
    margin: auto;
}

</style>