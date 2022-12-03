<template>
  <vHeader 
    :language="language" 
    @change-lang="updateLang" 
    ></vHeader>
  
  <vAuth v-if="!isUserLoggined" :language="language"  @user-loginned-success="login"></vAuth>
  

  <vMainPage v-if="isUserLoggined" @logout="logout" :language="language"></vMainPage>

  
  <vFooter :language="language"></vFooter>

  <vLoader :loader="loader"></vLoader>
  

</template>

<script>

import vHeader from './components/vheader.vue'
import vAuth from './components/vauth.vue'
import vMainPage from './components/vmainpage.vue'
import vFooter from './components/vfooter.vue'
import vLoader from './components/vLoader.vue'

export default {
  name: 'App',
  components: {
    vHeader,
    vAuth,
    vMainPage,
    vFooter,
    vLoader,

  },
  data() {
        return {
            isUserLoggined: true,
            language: 'ua',
            loader: false
                       
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
        this.setCookies('userInfo', null, 0)
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
      //перевірка на наявність токена в куках #245e06
      // якщо токена там немає, то показувати головну сторінку
      this.isUserLoggined = this.getCookies('jwt')

      //якщо юзер авторизований, то показувати мову інтерфейсу залежно від обраного курсу
      // якщо курс ще не обрано -- показувати укр мову
      let user = this.getCookies('userInfo')/// 
      if (user) {
        this.language = JSON.parse(user)?.lang
      } else this.language = 'ua'

    },
    computed: {

    }
}
// 053f03 correct ans color
// 6e0000 uncor -//-
// 290145
// #000057
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  
}
body {
  background: #1d1d1d;
  
  position: relative;
}


</style>
