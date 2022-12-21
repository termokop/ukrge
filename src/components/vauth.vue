<template>
    
    <vLoader :loader="loader"></vLoader>
    <div class="forms-section">
        <h1 class="section-title"><span v-html="dictionary.title[language]"></span></h1>
        
            
        <div class="buttons">
          <div 
            class="form-wrapper" 
            :class="{ isActive: isLogin }" >
            <button type="button" class="switcher switcher-login" @click="chooseLoginIn">
                {{dictionary.logIn[language]}}
            </button>
          </div>
        </div>
          <div 
          class="form-wrapper"
          :class="{ isActive: !isLogin }">
            <button type="button" class="switcher switcher-signup" @click="chooseSingUp">
              {{dictionary.signUp[language]}}
              <span class="underline"></span>
            </button>
          </div>
          <!-- форма логін -->
            <div class="forms">
            <form class="form form-login" v-if="isLogin">
                <div class="fieldset">
                    <div class="input-block">
                    <label for="login-email">E-mail</label>
                    <input v-model="inputLogin"
                    @input="emailValidation"
                        id="login-email" 
                        type="email" 
                        :disabled="!isLogin"
                        >
                        <p v-if="inputErrors.email.length>0" class="inputErrors"> {{inputErrors.email[0]}} </p>
                    </div>
                    <div class="input-block">
                    <label for="login-password">{{ dictionary.password[language] }}</label>
                    <input v-model="inputPassword"
                    @input="passwordValidation"
                        id="login-password" 
                        type="password" 
                        :disabled="!isLogin"
                        >
                        <p v-if="(inputErrors.password.length>0)" class="inputErrors"> {{inputErrors.password[0]}} </p>
                    </div>
                    <button 
                        type="submit" 
                        :class="{ disabledButton: isLoginBtnDisabled }"
                        class="btn-login"  
                        @click.prevent="login" 
                        :disabled="isLoginBtnDisabled" 
                        >
                        {{dictionary.logIn[language]}}
                    </button>
                </div>
            </form>
          <!-- форма реєстрації -->
          
            <form class="form form-signup" v-if="!isLogin">
                <div class="fieldset">
                    <div class="input-block">
                    <label for="signup-email">E-mail</label>
                    <input v-model="inputLogin"
                        @input="emailValidation"
                        id="signup-email" 
                        type="email" 
                        :disabled="isLogin">
                        <p v-if="inputErrors.email.length>0" class="inputErrors"> {{inputErrors.email[0]}} </p>
                    </div>
                    <div class="input-block">
                    <label for="signup-password">{{ dictionary.password[language] }}</label>
                    <input v-model="inputPassword"
                    @input="passwordValidation"
                        id="signup-password" 
                        type="password" 
                        :disabled="isLogin">
                        <p v-if="(inputErrors.password.length>0)" class="inputErrors"> {{inputErrors.password[0]}} </p>
                    </div>
                    <div class="input-block">
                    <label for="signup-password-confirm">{{ dictionary.repeatPassword[language] }}</label>
                    <input v-model="inputRepeatPassword"
                    @input="passwordRepeatValidation"
                        id="signup-password-confirm" 
                        type="password" 
                        :disabled="isLogin"
                        >
                        <p v-if="inputErrors.repeatPassword.length>0" class="inputErrors">{{inputErrors.repeatPassword[0]}}</p>
                    </div>
                    <button 
                        type="submit" 
                        :class="{ disabledButton: isSignupBtnDisabled }"
                        class="btn-signup" 
                        :disabled="isSignupBtnDisabled"
                        @click.prevent="signup"
                        >
                        {{dictionary.signUp[language]}}
                    </button>
                </div>
            </form>
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
        }
      }
    },
    methods: {
        // вибір форми логін
        chooseLoginIn() {
            this.isLogin = true
        },
        chooseSingUp() {
            // вибір форми реєстрації
            this.isLogin = false
        },
        async login() { // що відбувається, коли користувач натискає кнопку ЛОГІН
            this.loader = true
            const url = 'https://www.ukrge.site/api/login.php'
            let data = {
                email: this.inputLogin,
                password: this.inputPassword
            }
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
                fetch('https://www.ukrge.site/api/get_task_list.php') // taking topic list
                .then((response) => response.json())
                .then((data_list) => {
                    localStorage.topics = JSON.stringify(data_list.task)
                    this.$emit('user-loginned-success', result)
                });//----

            } catch (error) {
                alert(dictionaryModal.failAuth[this.language])
            } finally {
                this.loader = false
            }
            

        },
        async signup() { // метод книпки реєстрації
            this.loader = true
            const url = 'https://www.ukrge.site/api/create_user.php'
            let data = {
                email: this.inputLogin,
                password: this.inputPassword
            }
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
                await response.json() //let result = 
                //очищиємо поля для введення даних
                this.inputLogin = ''
                this.inputPassword = ''
                this.inputRepeatPassword = ''
                this.isLogin = true

                alert(dictionaryModal.successRegistr[this.language])
            } catch (error) {
                console.log(error)
                alert(dictionaryModal.failRegistr[this.language])
            } finally {
                this.loader = false
            }
            
        },
        emailValidation() {
            if(this.inputLogin.length>5 && ~this.inputLogin.indexOf('@') && ~this.inputLogin.indexOf('.')) this.inputErrors.email = []
            else this.inputErrors.email[0] = (dictionary.uncorrectEmail[this.language])
        },
        passwordValidation() {
            // ------------------------- зробити нормальну валідацію пароля
           if(this.inputPassword.length>7) this.inputErrors.password = []
            else this.inputErrors.password[0] = (dictionary.uncorrectPassword[this.language])
        },
        passwordRepeatValidation() {
            if(this.inputRepeatPassword === this.inputPassword) this.inputErrors.repeatPassword = []
            else this.inputErrors.repeatPassword[0] = (dictionary.uncorrectRepeatPassword[this.language])
        }
        

    },
    computed: {
        isLoginBtnDisabled() {
            if(this.inputErrors.email.length>0 || this.inputErrors.password.length>0 || this.inputLogin === "" || this.inputPassword === '') return true
            return false
        },
        isSignupBtnDisabled() {
            if(this.inputErrors.email.length>0 || this.inputErrors.password.length>0 || this.inputLogin === "" || this.inputPassword === '' || this.inputRepeatPassword === "" || this.inputErrors.repeatPassword.length>0) return true
            return false
        },
    }
 }
  
  </script>
  
  <style scoped>
  .forms-section {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    width: 100%;
    
}
    .section-title {
    font-size: 15px;
    letter-spacing: 1px;
    color: #fff;
    margin-bottom: 2vh;
}

  .buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-content: flex-start;
  }
  .form-wrapper.isActive {
    display: none;
}
.switcher {
    cursor: pointer;
    display: flex;
    font-size: 15px;
    color: #fff;
    border: 1px solid #fff;
    outline: none;
    margin-bottom: 15px;
    background-color: #000;
    border-radius: 5px;
    padding: 5px;
    
}
.form {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    margin: 0;
    height: 360px;
    width: 400px;
    background-color: transparent;
    border-radius: 20px;
    color: #fff;
}
.form-login {
    height: 275px;
}
    .fieldset {
        width: 350px;
    }
    .input-block {
        display: flex;
        justify-content: space-between;
        align-content: flex-start;
        flex-wrap: wrap;
        padding: 15px;
        height: 60px;

    }
    input {
        height: 35px;
        align-self: flex-end;
        width: 100%;
    }
    .inputErrors {
        font-size: small;
        color: red;
        padding: 0;
        margin: 0;
  } 

  .btn-login, .btn-signup {
    position: relative;
    width: 90%;
    height: 50px;
    border-radius: 20px;
    margin: 20px 15px;
    padding: 15px;
    color: #fff;
    background-color: #000;
    border: 2px solid grey;
  }

.disabledButton {
    background: grey;
 }

 a:link, a:visited {
    color: transparent;
 }
 a {
    cursor: pointer;
 }

  </style>
  