<template>
    <div class="forms-section">
        <h1 class="section-title">{{ dictionary.title[language] }}</h1>
        <div class="forms">
            <!-- форма логін -->
          <div 
          class="form-wrapper" 
          :class="{ isActive: isLogin }" >
            <button type="button" class="switcher switcher-login" @click="chooseLoginIn">
            {{dictionary.logIn[language]}}
              <span class="underline"></span>
            </button>
            <form class="form form-login">
              <fieldset>
                <legend>{{ dictionary.fillLoginForm[language] }}</legend>
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
                    <p v-if="inputErrors.password.length>1" class="inputErrors"> {{inputErrors.password[0]}} </p>
                </div>
              </fieldset>
              <button 
                type="submit" 
                :class="{ disabledButton: isLoginBtnDisabled }"
                class="btn-login"  
                @click.prevent="login" 
                :disabled="isLoginBtnDisabled" 
                >
                {{dictionary.logIn[language]}}</button>
            </form>
          </div>
          <!-- форма реєстрації -->
          <div 
          class="form-wrapper"
          :class="{ isActive: !isLogin }">
            <button type="button" class="switcher switcher-signup" @click="chooseSingUp">
              {{dictionary.signUp[language]}}
              <span class="underline"></span>
            </button>
            <form class="form form-signup">
              <fieldset>
                <legend>{{ dictionary.fillSignupForm[language] }}</legend>
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
                    <p v-if="inputErrors.password.length>1" class="inputErrors"> {{inputErrors.password[0]}} </p>
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
              </fieldset>
              <button 
                type="submit" 
                :class="{ disabledButton: isSignupBtnDisabled }"
                class="btn-signup" 
                :disabled="isSignupBtnDisabled"
                @click.prevent="signup"
                >
                {{dictionary.signUp[language]}}</button>
            </form>
          </div>
        </div>
      </div>
  </template>
  
  <script>
  import dictionary from "./dictionary/auth.js"
  export default {
    name: 'vAuth',
    props: {
        language: String
    },
    emits: ['user-loginned-success'],
    data() {
      return {
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
            console.log('i cat tell u:' , dictionary)
        },
        chooseSingUp() {
            // вибір форми реєстрації
            this.isLogin = false
        },
        async login() { // що відбувається, коли користувач натискає кнопку ЛОГІН
            //-----------тут має бути перевірка валідності форми входу
            const url = 'http://ukrgeserver/api/login.php'
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

                alert('Success')
                this.$emit('user-loginned-success', result)
            } catch (error) {
                alert("Не вдалося ввійти")
            }
            

        },
        async signup() { // метод книпки реєстрації
            
            const url = 'http://ukrgeserver/api/create_user.php'
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
                //очищиємо поля для введення даних
                this.inputLogin = ''
                this.inputPassword = ''
                this.inputRepeatPassword = ''
                this.isLogin = true

                alert(result.message)
            } catch (error) {
                console.log(error)
                alert('Не вдалося створити користувача')
            }
            
        },
        emailValidation() {
            if(this.inputLogin.length>5 && ~this.inputLogin.indexOf('@') && ~this.inputLogin.indexOf('.')) this.inputErrors.email = []
            else this.inputErrors.email[0] = ("Некоректний email")
        },
        passwordValidation() {
            // ------------------------- зробити нормальну валідацію пароля
            


           if(this.inputPassword.length>7) this.inputErrors.password = []
            else this.inputErrors.password.push("Пароль має містити мінімум 8 символів")
        },
        passwordRepeatValidation() {
            if(this.inputRepeatPassword === this.inputPassword) this.inputErrors.repeatPassword = []
            else this.inputErrors.repeatPassword[0] = ("Паролі мають співпадати")
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
 

  .inputErrors {
    font-size: small;
    color: red;
    padding: 0;
    margin: 0;
  }

.forms-section {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    
}

.section-title {
    font-size: 20px;
    letter-spacing: 1px;
    color: rgb(255, 255, 255);
}

.forms {
    display: flex;
    align-items: flex-start;
    margin-top: 10px;
}

.form-wrapper {
    animation: hideLayer .3s ease-out forwards;
}

.form-wrapper.isActive {
    animation: showLayer .3s ease-in forwards;
}

@keyframes showLayer {
    50% {
        z-index: 1;
    }
    100% {
        z-index: 1;
    }
}

@keyframes hideLayer {
    0% {
        z-index: 1;
    }
    49.999% {
        z-index: 1;
    }
}

.switcher {
    position: relative;
    cursor: pointer;
    display: flex;
    margin-right: 85px;
    margin-left: 85px;
    font-size: 15px;
    color: #fff;
    background-color: transparent;
    border: none;
    outline: none;
}

.underline {
    position: absolute;
    bottom: -5px;
    left: 0;
    overflow: hidden;
    pointer-events: none;
    width: 100%;
    height: 2px;
}

.underline::before {
    content: '';
    position: absolute;
    top: 0;
    left: inherit;
    display: block;
    width: inherit;
    height: inherit;
    background-color: currentColor;
    transition: transform .2s ease-out;
}

.switcher-login .underline::before {
    transform: translateX(101%);
}

.switcher-signup .underline::before {
    transform: translateX(-101%);
}

.form-wrapper.isActive .underline::before {
    transform: translateX(0);
}

.form {
    transform-origin: top;
    overflow: hidden;
    min-width:  250px;
    margin-top: 90px;
    padding: 30px 40px;
    border-radius: 5px;
    box-shadow: 0 0 50px 10px rgba(0, 0, 0, 0.1);
}

.form-login {
    animation: hideLogin .3s ease-out forwards;
}

.form-wrapper.isActive .form-login {
    animation: showLogin .3s ease-in forwards;
}

@keyframes showLogin {
    0% {
        background: #d7e7f1;
        transform: translate(40%, 10px);
    }
    50% {
        transform: translate(0, 0);
    }
    100% {
        background-color: #fff;
        transform: translate(35%, -20px);
    }
}

@keyframes hideLogin {
    0% {
        background-color: #fff;
        transform: translate(40%, -20px);
    }
    50% {
        transform: translate(0, 0);
    }
    100% {
        background: #d7e7f1;
        transform: translate(35%, 25px);
    }
}

.form-signup {
    animation: hideSignup .3s ease-out forwards;
}

.form-wrapper.isActive .form-signup {
    animation: showSignup .3s ease-in forwards;
}

@keyframes showSignup {
    0% {
        background: #fff;
        transform: translate(-40%, 10px) scaleY(.8);
    }
    50% {
        transform: translate(0, 0) scaleY(.8);
    }
    100% {
        background-color: #fff;
        transform: translate(-42.5%, -50px) scaleY(.9);
    }
}

@keyframes hideSignup {
    0% {
        background-color: #fff;
        transform: translate(-35%, -20px) scaleY(1);
    }
    50% {
        transform: translate(0, 0) scaleY(.8);
    }
    100% {
        background: #d7e7f1;
        transform: translate(-42.5%, 0px) scaleY(.8);
    }
}

.form fieldset {
    position: relative;
    opacity: 0;
    margin: 0;
    padding: 0;
    border: 0;
    transition: all .3s ease-out;
}

.form-login fieldset {
    transform: translateX(-50%);
}

.form-signup fieldset {
    transform: translateX(50%);
}

.form-wrapper.isActive fieldset {
    opacity: 1;
    transform: translateX(0);
    transition: opacity .4s ease-in, transform .35s ease-in;
}

.form legend {
    position: absolute;
    overflow: hidden;
    width: 1px;
    height: 1px;
    clip: rect(0 0 0 0);
}

.input-block {
    margin-bottom: 20px;
}

.input-block label {
    font-size: 14px;
    color: rgba(0, 0, 0, 0.750);
}

.input-block input {
    display: block;
    width: 100%;
    margin-top: 8px;
    padding-right: 10px;
    padding-left: 10px;
    font-size: 15px;
    line-height: 40px;
    border: 2.5px solid #aaa;
    border-radius: 2px;
    color: rgba(0, 0, 0, 0.750);
}

.form [type='submit'] {
    opacity: 0;
    display: block;
    min-width: 120px;
    margin: 30px auto 10px;
    font-size: 18px;
    line-height: 40px;
    border-radius: 25px;
    border: none;
    transition: all .3s ease-out;
}

.form-wrapper.isActive .form [type='submit'] {
    opacity: 1;
    transform: translateX(0);
    transition: all .4s ease-in;
}

.btn-login {
    color: #fff;
    background-color: #3d3d3d;
    transform: translateX(-30%);
}

.btn-signup {
    color: #fff;
    background: #3d3d3d;
    transform: translateX(30%);
}

.disabledButton {
    background: grey;
 }

  </style>
  