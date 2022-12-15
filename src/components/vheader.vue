<template>
      <div class="header">
        <a href="#" class="logo left" @click="updateLang('ua')">
            <img src="@/assets/ua.svg" />

        </a>

        <p class="title">{{dictionary[language]}}</p>

        <a href="#" class="logo right" @click="updateLang('ge')">
            <img src="@/assets/ge.svg" />
        </a>
    </div> 
</template>

<script>
import dictionary from "./dictionary/header"
export default {
    name: 'vHeader',
    props: {
        language: String
    },
    data() {
        return {
            dictionary
        }
    },
    methods: {
        updateLang(index) {

            this.$emit('change-lang', index)
            ///localStorage.lang = index// for change language in localStorage
        }
    },
    created() {
        //if(!localStorage.lang) localStorage.lang = 'ua' // for change language in localStorage
    }
 }
 </script>

 <style scoped>
 .header {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: space-between;
  color: #ffffff;
  font-size: 20px;
  height: 10vh;
  min-height: 80px;
  
}
.header a {
    float: left;
    color: black;
    text-align: center;
    height: fit-content;
    
  }

img {
	height: 75px;
    margin:0;
    border-radius: 10px;
}

.right {
    float: right;
  }

p {
    text-shadow: 1px 1px 2px rgb(159, 159, 159), 0 0 1em rgb(0, 0, 0), 0 0 0.5em rgb(0, 0, 0);
}
 @media screen and (max-width: 700px) {
  .header p {
    font-size: 12px;
    width: fit-content;
    height: fit-content;
    display: flex;
    align-content: stretch;
    
  }
} 
@media screen and (max-width: 340px) {
    .header p {
        display: none;
    }
}



</style>