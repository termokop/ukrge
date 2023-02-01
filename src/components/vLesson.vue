<template>

<div class="lesson">
    <div  class="title">
        <h2> Урок {{ lessonObj.lesson }}</h2>
    </div>

    <div class="intro">
        <span v-html="lessonObj.info.intro"></span>
    </div>
    
    <div v-if="lessonObj.letters.length > 0" class="letters">
        <h3>Літери для вивчення:</h3> 
        <table>
            <tr v-for="letter in lessonObj.letters" :key="letter.voice">
                <td><vPlayAudio :audioUrl="letter.voice"></vPlayAudio></td>
                <td class="ge">{{letter.ge}}</td>
                <td>-</td>
                <td class="ua">{{ letter.ua }}</td>
            </tr>
        </table>
    </div>

    <div v-if="lessonObj.words.length > 0" class="words">
        <h3>Слова для вивченя:</h3>
        <table>
            <tr v-for="word in lessonObj.words" :key="word.voice">
                <td><vPlayAudio :audioUrl="word.voice"></vPlayAudio></td>
                <td class="ge">{{ word.ge }}</td>
                <td>-</td>
                <td class="ua">{{ word.ua + ' ' +word.ua_additional }}</td>
            </tr>
        </table>
    </div>
    
    <div v-if="lessonObj.sentences.length > 0" class="sentences">
        <h3>Речення:</h3>  
        <table>
            <div v-for="sentence in lessonObj.sentences" :key="sentence.voice">
                <tr>
                <td><vPlayAudio :audioUrl="sentence.voice"></vPlayAudio></td>
                    <td class="ge">{{sentence.ge}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td class="ua">{{ sentence.ua }}</td>
                </tr>
            </div>
        </table>
    </div>

    <div class="gramar">
        <h3>Граматика</h3>
        <span v-html="lessonObj.info.gramar"></span>
    </div>
    
    <div class="addictional" v-if="lessonObj.info.addictional">
        <h3>Додатково:</h3>
        <span v-html="lessonObj.info.addictional"></span>
    </div>

    <div class="buttons">
        <button class="red" @click.prevent="backToMenu">Меню</button>
        <button class="green" @click.prevent="startQuiz">Практикуватися</button>
    </div>

    <vDidUFindMistake
        :objInfo="lessonObj"
    >
    </vDidUFindMistake>

</div>


</template>

<script>
import vPlayAudio from './vPlayAudio.vue';
import vDidUFindMistake from './vDidUFindMistake.vue';
export default {
    name: 'vLesson',
    components: {
        vPlayAudio,
        vDidUFindMistake,
    },
    props: {
        lessonObj: Object,
    },
    emits: ['backToMenu', 'start_quiz'],
    data() {
        return {
 
        }
    },
    methods: {
        backToMenu() {
            this.$emit('backToMenu')
        },
        startQuiz() {
            this.$emit('start_quiz', this.lessonObj.lesson)
        }
    },
    created() {
    }
}

</script>

<style scoped>

    .lesson{
        background-color: azure;
        max-width: 100%;
        margin: auto;
        padding: 10px;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        color: black;
    }
    .title, .gramar, .addictional, .intro, .buttons, .mistake {
        width: 100%;
    }
    .letters, .sentences, .words {
        width: fit-content;
        margin: 25px;
    }
    h1, h2, h3 {
        width: fit-content;
        margin: auto;
    }
    .ua {
        color: grey;
        font-style: italic;
    }

    .lesson :deep() .ua {
        color: grey;
        font-style: italic;
    }
    .lesson :deep() h4 {
        width: fit-content;
        margin: auto;
    } 
    .buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin: 5px;
    }
    .buttons button {
        font-weight: bold;
    }

    @media screen and (max-width: 700px) {
        .lesson {
            padding-bottom: 90px;
        }
    }

</style>