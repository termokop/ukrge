<template>
    <div class="quizz">
        <vTask 
            v-if="!showScore && typeof(quiz[counter][0]) === 'object'" 
            :task="quiz[counter]" 
            @nextTask="nextTask"
            :language="language"
            >
        </vTask>
        <template v-for="(item,index) in quiz" :key="index">
            <vTaskSen 
                v-if="index === counter && !showScore && typeof(quiz[counter]) === 'object' && quiz[counter].type === 'create_sentence'" 
                :task="quiz[counter]" 
                @nextTask="nextTask"
                :language="language"
                >
            </vTaskSen>
        </template>
        <vScore 
            v-if="showScore" 
            :score="score" 
            :maxScore="quiz.length"
            :language="language"
            @repeat="this.$emit('repeat')"
            @changeTopic="this.$emit('changeTopic')"
            @finish_quiz="this.$emit('finish_quiz')"
            >
        </vScore>
    </div>
</template>

<script>
import vTask from './vTask.vue'
import vScore from './vScore.vue'
import vTaskSen from './vTaskSen.vue'

export default {
    name: 'vQuizz',
    components: {
        vTask,
        vScore,
        vTaskSen,
    },
    props: {
        quiz: Array,
        language: String,
    },
    emits: ['hide_menu'],
    data() {
        return {
            counter: 0,
            score: 0,
            showScore: false,
        }
    },
    methods: {
        nextTask(score) {
            this.score += score
            if(this.quiz.length-1 > this.counter) {
                this.counter++
            } else {
                this.showScore = true
            }
            
        }
    },
    created() {
        this.$emit('hide_menu', true)
        alert(this.quiz)
    },
    unmounted() {
        this.$emit('hide_menu', false)
    }
}


</script>

<style scoped>
 .quizz {
    display: flex;
    min-width: 100%;
    margin: auto;
    height: 100%
 }
</style>

<style>

    *{
        font-size: 16px;
        cursor: default;
    }
    .task {
        display: flex;
        flex-wrap: wrap;
        align-content: space-between;
        margin: auto;
        color: #fff;
        height: 100%;
    }
    .question {
        width: 100%;
        padding: 0;
        font-size: 1em;
        height: 100;
        margin-bottom: 10vh;
    }
    .variants {
        width: 100%;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        height: 280px;
        margin-bottom: 10vh;
    }
    .ansButton {
        width: 50%;
        margin: auto;
    }
    .ansButton button {
        border-radius: 30px;
        width: 100%;
        margin: auto;
        background-color: green;
        padding: 20px;
        color: rgb(0, 0, 0);
        /* font-weight: bold; */
        border: none;
        height: 100%;
    }
    @keyframes ansbutton {
        from {background-color: #3d3d3d;}
        to {background-color: green;}
    }
    @keyframes ansbuttonDissable {
        from {background-color: green;}
        to {background-color: #3d3d3d;}
    } 
    .ansButton button[disabled] {
        background-color: #3d3d3d;
        color: #1d1d1d;
        animation-name: ansbuttonDissable;
        animation-duration: 0.5s;
    } 
        .visible {
        animation-name: ansbutton;
        animation-duration: 1s;
        border: none;
    } 
    .skip {
        width: fit-content;
        margin: auto;
    }
    .skip button {
        background-color: transparent;
        color: white;
    }
</style>