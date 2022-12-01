<template>
  <vHeader 
    :language="language" 
    @change-lang="updateLang" 
    ></vHeader>
  
  <vAuth v-if="!isUserLoggined" :language="language"  @user-loginned-success="login"></vAuth>
  

  <vMainPage v-if="isUserLoggined" @logout="logout" :language="language"></vMainPage>

  <vFooter :language="language"></vFooter>

</template>

<script>

import vHeader from './components/vheader.vue'
import vAuth from './components/vauth.vue'
import vMainPage from './components/vmainpage.vue'
import vFooter from './components/vfooter.vue'

export default {
  name: 'App',
  components: {
    vHeader,
    vAuth,
    vMainPage,
    vFooter

  },
  data() {
        return {
            isUserLoggined: true,
            language: 'ua',
                       
        }
    },
    methods: {
      //перемикач мови
      updateLang(index) {
        this.language = index
      },
      login(result) {
        //метод щоб залогіниться
        this.setCookies('jwt', result.jwt, 1)
        let res_str = JSON.stringify( result.userInfo)
        this.setCookies('userInfo',res_str,1)
      },
      setCookies(cname, cvalue, exdays) {
        //збереження нового JWT ключа в куках
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            const expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            this.isUserLoggined = cvalue
      },
      logout() {
        // метод щоб розлогіниться
        this.setCookies('jwt', '', 1)
        this.setCookies('userInfo', null, 1)
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
      }
    },
    created() {
      //перевірка на наявність токена в куках
      // якщо токена там немає, то показувати головну сторінку
      this.isUserLoggined = this.getCookies('jwt')
    },
    computed: {

    }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  
}
body {
  background: #1d1d1d;
}
</style>
