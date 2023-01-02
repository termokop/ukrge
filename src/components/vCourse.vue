<template>


    


    
<div class="content" v-if="!isLessonOpened">
    <h1 class='center'>Курс картвельської мови</h1> <br>
    <div class="studyMenu">
        <button class="element"
            v-for="n in 10"
            :key="n"
            @click.prevent="startLesson(n)">
            <p>Урок {{ n }}</p>
        </button>
    </div>
</div>

    <vLesson 
        v-if="isLessonOpened" 
        :lessonObj="lessonObj"
        @backToMenu="isLessonOpened = false"
        >
    </vLesson>

    <vLoader :loader="loader"></vLoader>


</template>

<script>
import dictionary from './dictionary/task_words.js';
import vLoader from './vLoader.vue';
import vLesson from './vLesson.vue'

export default {
    name: 'vCourse',
    components: {
        vLoader,
        vLesson
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
            lastTopic: '',
            lessonObj: null,
            isLessonOpened: false
        }
    },
    methods: {
        async startLesson(lesson) {
            this.loader = true
            const url = 'https://www.ukrge.site/api/get_lesson.php'
            const json = JSON.stringify({lesson: lesson})
            
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    body: json
                })
                let result = await response.json()
                if(result.info) {
                    this.lessonObj = result;
                    this.isLessonOpened = true
                } else alert('Урок №' + lesson + ' ще в розробці')
            } catch(error) {
                //console.log(error)
                alert('Поки що доступно тільки 2 уроки. Решта в розробці')
            } finally {
            this.loader = false
            }
        }
    },
    mounted() {

    },

}

</script>

<style scoped>
h1 {
    color: #fff;
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

    button[disabled] {
        opacity: 50%;
        background-color: gray;
    }

    @media screen and (max-width: 500px) {
        .studyMenu {
        width: 95vw;
    }
    .element {
        width: 90vh;

    }
    }



</style>