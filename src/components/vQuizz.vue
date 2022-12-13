<template>
    <div class="quizz">
        <vTask 
            v-if="!showScore && typeof(quiz[counter][0]) === 'object'" 
            :task="quiz[counter]" 
            @nextTask="nextTask"
            >
        </vTask>
        <template v-for="(item,index) in quiz" :key="index">
            <vTaskSen 
                v-if="index === counter && !showScore && typeof(quiz[counter]) === 'object' && quiz[counter].type === 'create_sentence'" 
                :task="quiz[counter]" 
                @nextTask="nextTask"
                >
            </vTaskSen>
        </template>
        <vScore 
            v-if="showScore" 
            :score="score" 
            :maxScore="quiz.length"
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
        console.log('type',typeof(this.quiz[this.counter]))
    }
}


</script>

<style scoped>
 .quizz {
    display: flex;
    border: 2px solid red;
    min-width: 600px;
    margin: auto;

 }
</style>