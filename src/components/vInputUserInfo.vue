<template>
  <vLoader :loader="loader"></vLoader>
  <h2>{{dictionary.title[language]}}</h2>
  <div class="form">
    <div class="group"> 
          <input 
            type="text" 
            id="name" 
            maxlength="20" 
            required minlength="4"
            v-model="name" />
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Ім'я</label>
    </div>
    <div class="group"> 
          <input 
            type="text" 
            id="nickname"
            maxlength="20" 
            required
            v-model="nickname">
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Нікнейм</label>
    </div>
    <div class="group"> 
          <input type="text" id="about_yourself" v-model="about_yourself" required/>
          <span class="highlight"></span>
          <span class="bar"></span>
          <label>Про Вас</label>
    </div>
           <input class="button" type="submit" :value="dictionary.submit[language]" @click.prevent="saveUserInfo" >
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

* { box-sizing:border-box; }

h2 		 { 
  text-align:center; 
  margin-bottom:50px; 
}
.form {
  width: fit-content;
  margin: auto;
}

.group 			  { 
  position:relative; 
  margin-bottom:45px; 
}
input 				{
  font-size:18px;
  padding:10px 10px 10px 5px;
  display:block;
  width:300px;
  border:none;
  border-radius: 5px;
  border-bottom:1px solid #757575;
}
input:focus 		{ outline:none; }

/* LABEL ======================================= */
label 				 {
  color:#999; 
  font-size:18px;
  font-weight:normal;
  position:absolute;
  pointer-events:none;
  left:5px;
  top:10px;
  transition:0.6s ease all; 
  -moz-transition:0.6s ease all; 
  -webkit-transition:0.6s ease all;
}

/* active state */
input:focus ~ label, input:valid ~ label 		{
  top:-20px;
  font-size:14px;
  color:#FFFFFF;
}

/* BOTTOM BARS ================================= */
.bar 	{ position:relative; display:block; width:300px; }
.bar:before, .bar:after 	{
  content:'';
  height:2px; 
  width:0;
  bottom:1px; 
  position:absolute;
  background: #000000; 
  transition:0.2s ease all; 
  -moz-transition:0.2s ease all; 
  -webkit-transition:0.2s ease all;
}
.bar:before {
  left:50%;
}
.bar:after {
  right:50%; 
}

/* active state */
input:focus ~ .bar:before, input:focus ~ .bar:after {
  width:50%;
}

/* HIGHLIGHTER ================================== */
.highlight {
  position:absolute;
  height:60%; 
  width:100px; 
  top:25%; 
  left:0;
  pointer-events:none;
  opacity:0.5;
}

/* active state */
input:focus ~ .highlight {
  -webkit-animation:inputHighlighter 0.3s ease;
  -moz-animation:inputHighlighter 0.3s ease;
  animation:inputHighlighter 0.3s ease;
}

/* ANIMATIONS ================ */
@-webkit-keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}
@-moz-keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}
@keyframes inputHighlighter {
	from { background:#5264AE; }
  to 	{ width:0; background:transparent; }
}

</style>