<template>
<div class="content" v-if="!isLessonOpened">
    <h1 class='center'>Курс картвельської мови</h1> <br>
    <div class="studyMenu">
        <button class="element"
            v-for="n in user_progress.length"
            :key="n"
            >
            <p class="center">Урок {{ n }}</p>
            <div class="buttons">
                <button
                    @click.prevent="startLesson(n)" 
                    class="theory"
                    >
                    <img src="../assets/theory.svg" alt="theory">
                    <!-- <img v-if="user_progress+3 > n * 3 + 0" class="done" src="../assets/done.svg" alt="done"> -->
                </button>
                <button 
                    @click.prevent="practice(n)" 
                    class="practice"
                    >
                    <img src="../assets/practice_lesson.svg" alt="practice">
                    <!-- <img v-if="user_progress+3 > n * 3 + 1" class="done" src="../assets/done.svg" alt="done"> -->
                </button>
                <button 
                    @click.prevent="exam(n)" 
                    class="exam"
                    >
                    <img v-if="user_progress[n-1][1] === '10'" src="../assets/doneA.svg" alt="doneExam">
                    <img v-else-if="user_progress[n-1][1] >= '8.2'" src="../assets/doneB.svg" alt="doneExam">
                    <img v-else-if="user_progress[n-1][1] >= '7.5'" src="../assets/doneC.svg" alt="doneExam">
                    <img v-else-if="user_progress[n-1][1] >= '6'" src="../assets/doneD.svg" alt="doneExam">
                    <img v-else src="../assets/doneX.svg" alt="doneExam">
                    <!-- <img v-if="user_progress+3 > n * 3 + 2" class="done" src="../assets/done.svg" alt="done"> -->
                </button>
            </div>
        </button>
    </div>
</div>

<vLesson 
    v-if="isLessonOpened" 
    :lessonObj="lessonObj"
    @backToMenu="isLessonOpened = false"
    @start_quiz="start_quiz"
    >
</vLesson>

<vLoader 
    :loader="loader"
    >
</vLoader>


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
    emits: ['start_quiz'],
    data () {
        return {
            dictionary,
            loader: false,
            lessonObj: null,
            isLessonOpened: false,
            user_progress: [],
        }
    },
    created() {
        let progresJSON = localStorage.getItem('course_1');
        console.log("progres_json",progresJSON)
        let arrOfProgress = Object.entries(JSON.parse(progresJSON))
        this.user_progress = arrOfProgress
        console.log(this.user_progress)
    },
    methods: {
        start_quiz(lesson) {
            this.practice(lesson)
            this.isLessonOpened = false
        },
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
                alert('Щось пішло не так....')
            } finally {
            this.loader = false
            }
        },
        async startQuizz(key, show_hints, lesson=0) {
            this.loader = true
            const url = 'https://www.ukrge.site/api/get_task_for_course.php'
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
                this.$emit('start_quiz', result.task, show_hints,lesson)
                console.log(result.task)
            } catch (error) {
                alert(error)
                console.log(error)
            } finally {
                this.loader = false
            }
        },
        practice(lesson) {
            this.startQuizz("lesson_" + lesson, true)
        },
        exam(lesson) {
            this.startQuizz("lesson_" + lesson, false, lesson)
        }
    },
    updated() {
        // let progresJSON = localStorage.getItem('course_1');
        // let arrOfProgress = Object.entries(JSON.parse(progresJSON))
        // this.user_progress = arrOfProgress
    },
}

</script>

<style scoped>
h1 {
    color: #fff;
}
.content {
    padding-bottom: 90px;
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
        height: 150px;
    }
    button.element:hover{
        border-width: 3px 3px 3px 3px;
    }

    button[disabled] {
        opacity: 50%;
        background-color: gray;
    }

    p {
        padding: 10px;
    }


    .buttons {
        height: 70%;
        display: flex;
        justify-content: space-between;
        align-content: center;

    }

    button {
        position: relative;
        width: 30%;
        height: 100%;
        margin: auto;
        background-color: transparent;
    }
    .buttons button:hover {
        background: #2d2d2d;
    }

    button img {
        width: 100%;
    }
      img.done {
        position: absolute;
        right: 0;
        bottom: 0;
        width: 40%;
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