<template>
    
    <vQuizz></vQuizz>
    <div class="studyMenu" v-if="false">
        <button class="element" @click="startQuizz">
            <p class="counter">2/5</p>
            <p class="title">Tutorial</p>
            <hr>
            <p class="explanation">You need to go here  if you still do not know, how to use the application</p>
        </button>
        <button class="element">
            <p class="counter">3/9</p>
            <p class="title">Tutorial</p>
            <hr>
            <p class="explanation">You need to go here  if you still do not know, how to use the application</p>
        </button>
        <button class="element">
            <p class="counter">6/8</p>
            <p class="title">Tutorial</p>
            <hr>
            <p class="explanation">You need to go here  if you still do not know, how to use the application</p>
        </button>
        <button class="element">
            <p class="counter">2/10</p>
            <p class="title">Tutorial</p>
            <hr>
            <p class="explanation">You need to go here  if yon. You need to go here  if you still do not know, how to use the application</p>
        </button>
        <button class="element">
            <p class="counter">0/7</p>
            <p class="title">Tutorial</p>
            <hr>
            <p class="explanation">You need to go here  if you still do not know, how to use the application</p>
        </button>

    </div>

</template>

<script>
import dictionary from './dictionary/studyMenu.js';
import vQuizz from './vQuizz.vue';

export default {
    name: 'studyMenu',
    components: {
        vQuizz,
    },
    props: {
        language: String,

    },
    data () {
        return {
            dictionary,
        }
    }
}

</script>

<style scoped>

    .studyMenu {
        display: flex;
        width: 50%;
        margin: auto;
        flex-wrap: wrap;
        justify-content: space-around;
        background-color: #2d2d2d;
        border-radius: 10px;
        color: #fff;
    }

    .element {
        position: relative;
        width: 200px;
        background: #1d1d1d;
        margin: 5px;
        border: 3px solid #fff;
        padding: 5px;
        border-radius: 10px;
        color: #fff;
        align-self: flex-start;
        overflow:hidden;
        scrollbar-color: red;
        height: 125px;
    }

    .title {
        width: fit-content;
        margin: auto;
        font-weight: bold;
    }
    .counter {
        width: fit-content;
        height: fit-content;
        position: absolute;
        right: 2px;
        top: 2px;
        padding: 5px;
        margin: 0;
        font-size: x-small;
        border-radius: 50%;
        background-color: green;
        
    }



</style>