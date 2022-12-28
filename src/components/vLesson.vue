<template>

<div class="lesson">
    <div  class="title">
        <h2> Урок {{ lessonObj.lesson }}</h2>
    </div>

    <div class="intro">
        <span v-html="lessonObj.info.intro"></span>
    </div>
    
    <div class="letters">
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

    <div class="words">
        <h3>Слова для вивченя:</h3>
        <table>
            <tr v-for="word in lessonObj.words" :key="word.voice">
                <td><vPlayAudio :audioUrl="word.voice"></vPlayAudio></td>
                <td class="ge">{{ word.ge }}</td>
                <td>-</td>
                <td class="ua">{{ word.ua }}</td>
            </tr>
        </table>
    </div>
    
    <div class="sentences">
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

    <div class="mistake">
        <button @click.prevent="showModalForMistake = true">Виявили помилку на цій сторінці? Натисніть тут</button>
    </div>

</div>

<vModalErr v-if="showModalForMistake" @closeModal="showModalForMistake = false" :obj="'lesson_' + lessonObj.lesson"></vModalErr>

</template>

<script>
import vModalErr from './modalErr.vue';
import vPlayAudio from './vPlayAudio.vue';
export default {
    name: 'vLesson',
    components: {
        vModalErr,
        vPlayAudio,
    },
    props: {
        lessonObj: Array,
    },
    data() {
        return {
            showModalForMistake: false,
        }
    },
    methods: {
        backToMenu() {
            this.$emit('backToMenu')
        },
        startQuiz() {
            alert('В розробці...')
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

    .listen {
        width: 20px;
    }

    .lesson :deep() .ua {
        color: grey;
        font-style: italic;
    }
    .lesson :deep() h4 {
        width: fit-content;
        margin: auto;
    } 
    .buttons, .mistake {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin: 5px;
    }
    .buttons button {
        font-weight: bold;
    }
    .mistake button {
        width: fit-content;
        margin: auto;
        font-style: italic;
        text-decoration: underline;
        border: none;
        background-color: transparent;
    }
    .mistake button:hover {
        color: grey;
    }


</style>