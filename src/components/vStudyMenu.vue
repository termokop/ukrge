<template>
    <vLoader :loader="loader"></vLoader>
    <vQuizz v-if="openQuiz" :quiz="quiz"></vQuizz>
    <div class="studyMenu" v-if="!openQuiz">
        <button 
            class="element" 
            v-for="topic in topics" 
            :key="topic.short_name" 
            :disabled="topic.ready === '0'"
            @click="startQuizz(topic.short_name)"

            >
            <p class="counter">2/5</p>
            <p class="title">{{topic.name}}</p>
            <hr>
            <p class="explanation">{{topic.description}}</p>
        </button>
        

    </div>

</template>

<script>
import dictionary from './dictionary/studyMenu.js';
import vQuizz from './vQuizz.vue';
import vLoader from './vLoader.vue';

export default {
    name: 'studyMenu',
    components: {
        vQuizz,
        vLoader,
    },
    props: {
        language: String,

    },
    data () {
        return {
            dictionary,
            topics: null,
            loader: false,
            quiz: null,
            openQuiz: false,
        }
    },
    methods: {
        getTopics() {
             fetch('http://ukrgeserver/api/get_task_list.php')
            .then((response) => response.json())
            .then((data) => {
                localStorage.topics = JSON.stringify(data.task)
            });
        },
        async startQuizz(key) {
            this.loader = true
            const url = 'http://ukrgeserver/api/get_task.php'
            const json = JSON.stringify({topic: key})
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
                if (result.task.length < 1) {
                    throw new Error('not found any tasks')
                }
                this.quiz = result.task
                this.openQuiz = true
                console.log(this.quiz)
            } catch (error) {
                alert(error)
                console.log(error)
            } finally {
                this.loader = false
            }
        }
    },
    created() {
    },
    mounted() {
        if(localStorage.topics) {
           this.topics = JSON.parse(localStorage.topics)
           this.getTopics()
        } else {
            this.getTopics()
        }
    },
    // watch: {
    //     topics(newTopics) {
    //         localStorage.topics = newTopics
    //     }
    // }
}

</script>

<style scoped>

    .studyMenu {
        display: flex;
        width: 70%;
        margin: auto;
        flex-wrap: wrap;
        justify-content: space-around;
        background-color: #2d2d2d;
        border-radius: 10px;
        color: #fff;
    }

    .element {
        position: relative;
        width: 300px;
        background: #1d1d1d;
        margin: 5px;
        border: 3px solid #fff;
        padding: 5px;
        border-radius: 10px;
        color: #fff;
        align-self: flex-start;
        overflow:hidden;
        scrollbar-color: red;
        height: 150px;
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

    button[disabled] {
        opacity: 50%;
    }



</style>