<template>
<div class="quizz">
<vTask v-if="!showScore" :task="quiz[counter]" @nextTask="nextTask"></vTask>
<vScore v-if="showScore" :score="score" :maxScore="quiz.length * 4"></vScore>
</div>
</template>

<script>
import vTask from './vTask.vue'
import vScore from './vScore.vue'

export default {
    name: 'vQuizz',
    components: {
        vTask,
        vScore,
    },
    props: {
        quiz: Array
    },
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
    }
}


</script>

<style scoped>
 .quizz {
    display: flex;
    border: 2px solid red;
    width: 80%;
    min-width: 600px;
    margin: auto;

 }
</style>