<template>
  <div class="content">
    <vHeader :language="language" @change-lang="updateLang"></vHeader>
    
    <vAuth v-if="!isUserLoggined" :language="language"  @user-loginned-success="login"></vAuth>

    <vMainPage v-if="isUserLoggined" @logout="logout" :language="language"></vMainPage>

    <vLoader :loader="loader"></vLoader>

  </div>
</template>

<script>

import vHeader from './components/vheader.vue'
import vAuth from './components/vauth.vue'
import vMainPage from './components/vmainpage.vue'
import vLoader from './components/vLoader.vue'

export default {
  name: 'App',
  components: {
    vHeader,
    vAuth,
    vMainPage,
    vLoader,
  },
  data() {
        return {
            isUserLoggined: localStorage.getItem('jwt'),
            language: 'ua',
            loader: false,
                       
        }
    },
    methods: {
      //перемикач мови
      updateLang(index) {
        this.language = index
      },
      login(result) {
        //метод щоб залогіниться
        localStorage.setItem('jwt', result.jwt)
        let res_str = JSON.stringify( result.userInfo)
        localStorage.setItem('userInfo',res_str)
        this.isUserLoggined = true
      },
      logout() {
        // метод щоб розлогіниться
        localStorage.removeItem('jwt')
        localStorage.removeItem('userInfo')
        this.isUserLoggined = false
      },
    },
    created() {
      //перевірка на наявність токена в куках #245e06
      // якщо токена там немає, то показувати головну сторінку
      this.isUserLoggined = localStorage.jwt

      //якщо юзер авторизований, то показувати мову інтерфейсу залежно від обраного курсу
      // якщо курс ще не обрано -- показувати укр мову
      // let user = localStorage.getItem('userInfo')/// 
      // if (user) {
      //   this.language = JSON.parse(user)?.lang
      // } else this.language = 'ua'

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
*::-webkit-scrollbar {
    width: 0;
    height: 0;
    }

    * {
      box-sizing: border-box;
    }

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  height: 95vh;
  overflow: hidden;
  
}
body {
  background: #1d1d1d;
  position: relative;
  
}

.green {
  background-color: #0b6308;
  color: white;
}
.red {
  background-color: #8e0000;
  color: #fff;
}
.center {
  width: fit-content;
  margin: auto;
}
button {
    width: 40%;
    border-radius: 20px;
    height: 40px;
    border: none;
}
</style>
