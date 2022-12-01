<template>
      <h1>You are insade, {{this.userInfo.name}}!</h1>
      <button value="Exit" @click.prevent="this.$emit('logout')">Exit</button> <!--реалізація кнопки виходу-->
      <!--анкета користувача, яка автоматично з'являється при першому вході-->
      <vInputUserInfo  
        :userInfo="userInfo" 
        ></vInputUserInfo> <!--v-if="userInfo.nickname"-->
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
            userInfo: undefined
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

    },
    created() {
        //this.userInfo = JSON.parse(this.getCookies('userInfo'))
        this.userInfo = JSON.parse(this.getCookies('userInfo'))
        console.log(JSON.parse(this.getCookies('userInfo')))
    },
    computed: {
        
    }

}
 </script>

 <style scoped>

h1 {
    text-shadow: 1px 1px 2px rgb(159, 159, 159), 0 0 1em rgb(0, 0, 0), 0 0 0.5em rgb(0, 0, 0);
    color: #fff;
    background-color: aqua;
}
button {
    width: 50px;
    height: 30px;
}

</style>