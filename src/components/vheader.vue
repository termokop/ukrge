<template>
      <div class="header">
        <a href="#" class="logo left" @click.prevent="updateLang('ua')">
            <img src="@/assets/ua.svg" />

        </a>

        <p class="title">
            <span>&larr; українська</span>
            <span> ქართული &rarr;</span>
        </p>

        <a href="#" class="logo right" @click.prevent="updateLang('ge')">
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
  font-size: 16px;
  height: 15vh;
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

.title {
    width: 100%;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
}

.title span {
    padding: 8px;
}
 @media screen and (max-width: 600px) {
  .title {
    font-size: 15px;
    justify-content: center;
    
  }
} 
@media screen and (max-width: 350px) {
    .title {
        display: none;
    }
}



</style>