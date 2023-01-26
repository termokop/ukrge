<template>
  <vLoader :loader="loader"></vLoader>
  <h2>{{dictionary.title[language]}}</h2>
  <div class="form">
    <form >
    <table>
      <tr>
        <td  class="tooltip">
          <label for="name">{{dictionary.name[language]}}:*</label>
          <span class="tooltiptext">{{dictionary.nameTip[language]}}</span>
        </td>
        <td>
          <input 
            type="text" 
            id="name" 
            placeholder="Piter Parker"
            maxlength="20" 
            required minlength="4"
            v-model="name" />
        </td>
      </tr>
      <tr>
        <td class="tooltip">
          <label for="nickname">{{dictionary.nickname[language]}}:*</label>
          <span class="tooltiptext">{{dictionary.nicknameTip[language]}}</span>
        </td>
        <td>
          <input 
            type="text" 
            id="nickname" 
            placeholder="Spiderman" 
            maxlength="15" 
            required
            v-model="nickname">
        </td>
      </tr>

        <tr>
          <td>
            <label for="about_yourself">{{dictionary.aboutYourself[language]}}:</label>
          </td>
          <td>
            <textarea id="about_yourself" cols="20" rows="5" placeholder="your hobby, credo, lifestyle...." maxlength="100" v-model="about_yourself"></textarea>
          </td>
        </tr>
      </table>
      <input class="button" type="submit" :value="dictionary.submit[language]" @click.prevent="saveUserInfo" >
      
    </form>
    </div>
    
</template>

<script>
import dictionary from './dictionary/inputUserInfo';
import vLoader from "./vLoader.vue"
import dictionaryModal from './dictionary/modals';
export default {
  name: 'vInputUserInfo',
    components: {
        vLoader
    },
  emits: ['canGoStudy'],
  props: {
    //userInfo: Object,
    language: String
  },
  data() {
      return {
        dictionaryModal,
        userInfo: localStorage.getItem('userInfo'),
        loader: false,
        dictionary,
        newInfo: this.userInfo,
        name: this.userInfo.name,
        nickname: this.userInfo.nickname,
        about_yourself: this.userInfo.about_yourself
      }
  },
  methods: {
    saveUserInfo() {
      let userNewInfo = {
        email: this.newInfo.email,
        name: this.name,
        nickname: this.nickname,
        about_yourself: this.about_yourself,
        id: this.newInfo.id,
        icon: this.newInfo.icon,
        jwt: undefined
      }
      this.newInfo = userNewInfo
      this.updateUserInfo()
    },
    async updateUserInfo() {
      this.loader = true
      this.newInfo.jwt = localStorage.getItem('jwt')
      const url = 'https://www.ukrge.site/api/update_user.php'
      const json = JSON.stringify(this.newInfo)
      console.log(json)
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
          this.$emit('canGoStudy', result.userInfo.nickname)
          const person = JSON.stringify(result.userInfo)
          localStorage.setItem('userInfo', person)
          alert(dictionaryModal.successUpdate[this.language])
      } catch (error) {
          console.log(dictionaryModal.failUpdate[this.language])
      } finally {
        this.loader = false
      }   
      },
  },
  mounted() {
  },
  beforeCreate() {
    this.userInfo = JSON.parse(localStorage.getItem('userInfo'))
  }
        
  
}
</script>

<style scoped>

* {
  font-size: 16px;
}

h2 {
  display: block;
  text-shadow: 1px 1px 2px rgb(159, 159, 159), 0 0 1em rgb(0, 0, 0), 0 0 0.5em rgb(0, 0, 0);
  color: #fff;
  width: fit-content;
  margin: auto;
  margin-bottom: 20px;
}


.form {
  width: fit-content;
  margin: auto;
  align-items: center;
  color: #FFF;
  background: transparent;
  border-radius: 10px;
}

table {
  align-items: center;
}

input, textarea, select {
  width: 100%;
  background: #ddd;
  color: #000;
  box-shadow: none;
  border-radius: 10px;
}

td{
  align-self: flex-end;
  margin: 10px;
  padding: 4px;
}

.button {
  display: block;
  margin: auto;
  color: #000;
  padding: 10px;
  width: 50%;
}

textarea { 
  resize: none; 
}

label {
  display: block;
  text-align: right;
  margin-right: 0px;

}

.radio {
  display: flex;
}


.radio label,
.radio input {
  display: inline;
  margin: 0;
  padding: 0;
  justify-content: center;
  align-content: center;

}

.tooltip .tooltiptext {
    visibility: hidden;
    width: fit-content;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
    opacity: 80%;
    position: absolute;
    z-index: 1;
    font-size: 12px;
}

.tooltip:hover .tooltiptext {
    visibility: visible;
}
.tooltip .tooltiptext::after {
    content: " ";
    position: absolute;
    bottom: 100%; 
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: transparent transparent black transparent;
}


</style>