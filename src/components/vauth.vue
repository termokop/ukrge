<template>
    <vLoader :loader="loader"></vLoader>
    


    <div class="center">
        <h1 class="section-title">Вивчайте <a href='https://civil.ge/archives/185960' style='color:#aaa; cursor:pointer'><strike>грузинську</strike></a> картвельську безкоштовно</h1>
        <div class="info">
            <p>Вам не потрібен пароль. Авторизація через Google аккаунт:</p>
            <div id="g_id_onload"
                data-client_id="365605108602-ec3mt20ef081ggcdre1nti2tldjjen6u.apps.googleusercontent.com"
                data-context="use"
                data-ux_mode="popup"
                data-callback="handleCredentialResponse"
                data-auto_prompt="false">
            </div>
    
            <div class="g_id_signin"
                data-type="icon"
                data-shape="circle"
                data-theme="filled_blue"
                data-text="continue_with"
                data-size="large">
            </div>
        </div>

    </div>



  </template>
  
  <script>
  import dictionary from "./dictionary/auth.js"
  import vLoader from "./vLoader.vue"
  import dictionaryModal from "./dictionary/modals"
  export default {
    name: 'vAuth',
    components: {
        vLoader
    },
    props: {
        language: String
    },
    emits: ['user-loginned-success'],
    data() {
      return {
        dictionaryModal,
        loader: false,
        dictionary,
        isLogin: true,
        inputLogin: '',
        inputPassword: '',
        inputRepeatPassword: '',
        inputErrors: {
            email: [],
            password: [],
            repeatPassword: []
        },
        responsePayload: [],
      }
    },
    methods: {
        async login(goo) { // що відбувається, коли користувач натискає кнопку ЛОГІН
            this.loader = true
            const url = 'https://www.ukrge.site/api/login.php'
            let data = goo
            console.log(JSON.stringify(data))
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*' 
                    },
                    body: JSON.stringify(data)
                    });
                let result = await response.json()
                this.$emit('user-loginned-success', result)
            } catch (error) {
                alert(dictionaryModal.failAuth[this.language])
            } finally {
                this.loader = false
            }
        },

        decodeJwtResponse(token) {
            let base64Url = token.split('.')[1]
            let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
            let jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
                return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
            }).join(''));
            return JSON.parse(jsonPayload)
        },
        handleCredentialResponse(response) {
            this.responsePayload = this.decodeJwtResponse(response.credential);
            console.log(this.responsePayload)
            let objGooLogin = {
                email: this.responsePayload.email,
                password: this.responsePayload.sub,
                given_name: this.responsePayload.given_name,
                family_name: this.responsePayload.family_name,
                picture: this.responsePayload.picture
            }
            this.login(objGooLogin)
        }
    },

    mounted() {
        window.handleCredentialResponse = this.handleCredentialResponse;
    }
 }
  
  </script>

<style scoped>

  * {
    color: #FFFFFF;
  }
  .info {
    position: absolute;
    top: 50%;
    width: fit-content;
    margin: auto;
  }

  .g_id_signin {
    margin: auto;
    width: fit-content;
  }
  

</style>
