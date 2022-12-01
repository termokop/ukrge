<template>
      <h1>Let`s study, {{this.userInfo.name}}!</h1>
      <div class="buttons">
        <button  @click.prevent="this.$emit('logout')">Exit</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="showEditeProfile" v-if="!showEdit" >Edit Info</button> <!--реалізація кнопки виходу-->
        <button  @click.prevent="showEditeProfile" v-if="showEdit" >Go study!</button> <!--реалізація кнопки виходу-->
      </div>
      
      <!--анкета користувача, яка автоматично з'являється при першому вході-->
      <vInputUserInfo  
        :userInfo="userInfo"
        v-if="showEdit" 
        ></vInputUserInfo> 
</template>

<script>
import vInputUserInfo from './vInputUserInfo.vue'

export default {
    name: "vMainPage",
    components: {
    vInputUserInfo

  },
    props: {
        
    },
    emits: ['logout'],
    data() {
        return {
            userInfo: undefined,
            showEdit: !this.userInfo?.nickname
        }
        
    },
    methods: {
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
        console.log('show edit compotent')
        console.log(this.showEdit)
      },

    },
    created() {
        this.userInfo = JSON.parse(this.getCookies('userInfo'))
        console.log("U r this person:", JSON.parse(this.getCookies('userInfo')))
        this.showEdit = !this.userInfo?.nickname
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
    width: 100px;
    height: fit-content;
    margin: 10px;
}

.buttons {
    width: fit-content;
    margin: auto;
}

</style>