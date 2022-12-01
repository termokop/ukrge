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
export default {
    name: 'vHeader',
    props: {
        dictionary: Object,
        language: String
    },
    methods: {
        addToCart() {
            this.$emit('add-to-cart', this.variants[this.selectedVariant].id)
        },
        updateLang(index) {
            this.$emit('change-lang', index)
        }
    }
 }
 </script>

 <style scoped>
 .header {
  overflow: hidden;
  padding: 0;
  display: flex;
  justify-content: space-between;
  color: #ffffff;
  font-size: 21px;
  
}
.header a {
    float: left;
    color: black;
    text-align: center;
    font-size: 18px;
    
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

@media screen and (max-width: 500px) {
  .header a {
    float: none;
    display: block;
    text-align: left;
    
  }

}

</style>