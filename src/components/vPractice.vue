<template>


    <vLoader :loader="loader"></vLoader>


    <div class="content">
        <h1>Перевір свої знання</h1>

        <div class="studyMenu">
            <button 
                class="element" 
                v-for="topic in topics" 
                :key="topic.short_name" 
                :disabled="topic.ready === '0'"
                @click="startQuizz(topic.short_name)"

                >
                <p class="counter">2/5</p>
                <p class="title">{{(JSON.parse(topic.name))[language]}}</p>
                <hr>
                <p class="explanation">{{(JSON.parse(topic.description))[language]}}</p>
            </button>
        </div>
    </div>

</template>

<script>
import dictionary from './dictionary/task_words.js';
import vLoader from './vLoader.vue';

export default {
    name: 'vPractice',
    components: {
        vLoader,
    },
    props: {
        language: String,

    },
    emits: ['start_quiz'],
    data () {
        return {
            dictionary,
            topics: null,
            loader: false,
            quiz: null,
            lastTopic: '',
        }
    },
    methods: {
        getTopics() {
             fetch('https://www.ukrge.site/api/get_task_list.php')
            .then((response) => response.json())
            .then((data) => {
                localStorage.topics = JSON.stringify(data.task)
            });
        },
        async startQuizz(key) {
            this.lastTopic = key
            this.loader = true
            const url = 'https://www.ukrge.site/api/get_task.php'
            const json = JSON.stringify({topic: key})
            
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
                this.$emit('start_quiz', result.task, true)
            } catch (error) {
                alert(error)
                console.log(error)
            } finally {
                this.loader = false
            }
        },
    },
    created() {
        if(localStorage.topics) {
           this.topics = JSON.parse(localStorage.topics)
           this.getTopics()
        } else {
            this.getTopics()
        }
    },
    mounted() {

    },
    unmounted() {
    }

}

</script>

<style scoped>

h1 {
    color: white;
    width: fit-content;
    margin: auto;
}

    .studyMenu {
        display: flex;
        width: 100%;
        margin: auto;
        flex-wrap: wrap;
        justify-content: center;
        background-color: transparent;
        color: #fff;
    }

    .element {
        position: relative;
        width: 300px;
        background: rgba(0, 0, 127, 0.7);
        margin: 5px 5px;
        border: 2px solid #2d2d2d;
        border-width: 1px 3px 5px 3px;
        padding: 5px;
        border-radius: 10px;
        color: #fff;
        align-self: flex-start;
        overflow:hidden;
        scrollbar-color: red;
        height: 150px;
    }
    .element:hover{
        border-width: 3px 3px 3px 3px;
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
        display: none;
    }

    button[disabled] {
        opacity: 50%;
        background-color: gray;
    }
    /* @media screen and (max-width: 1000px) {
        .studyMenu {
        width: 95vw;
    }
    .element {
        width: 250px;
    }
} */

@media screen and (max-width: 700px) {
        .content {
            padding-bottom: 90px;
        }
    }

    @media screen and (max-width: 500px) {
        .studyMenu {
        width: 95vw;
    }
    .element {
        width: 95vh;

    }
    }



</style>