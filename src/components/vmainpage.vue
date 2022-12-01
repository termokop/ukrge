<template>
      <h1>You are insade, {{this.userInfo.name}}!</h1>
      <button value="Exit" @click.prevent="this.$emit('logout')">Exit</button> <!--реалізація кнопки виходу-->
      <vInputUserInfo  
        :userInfo="userInfo" 
        @update-user-info="updateUserInfo"
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
            userInfo: JSON.parse(this.getCookies('userInfo'))
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
      async updateUserInfo(userNewInfo) {
        userNewInfo.jwt = this.getCookies('jwt')
        console.log(JSON.stringify( userNewInfo))
        const url = 'http://ukrgeserver/api/update_user.php'
        const json = JSON.stringify(userNewInfo)
        
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*' 
                    },
                    body: json
                    });
                let result = await response.json()
                console.log(result)

                alert('Success updated')
                //this.$emit('user-updated-success', result)
            } catch (error) {
                console.log(error)
            }
            
      }
    },
    created() {
        //this.userInfo = JSON.parse(this.getCookies('userInfo'))
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