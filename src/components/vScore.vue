<template>


<vLoader :loader="loader"></vLoader>

    <div class="scoreMain">
        <div class="score">
            <div class='score100' v-if="percent === 100">
                <p>
                    {{percent}}% {{dictionary.correctAnswers[language]}}
                </p>
                <br>
                <p>
                    {{dictionary.best[language]}}
                </p>
            </div>
            <div class='score75' v-else-if="percent>=75">
                <p>
                    {{percent}}% {{dictionary.correctAnswers[language]}}
                </p>
                <br>
                <p>
                    {{dictionary.better[language]}}
                </p>
            </div>
            <div class='scoreLess75' v-else>
                <p>
                    {{percent}}% {{dictionary.correctAnswers[language]}}
                </p>
                <br>
                <p>
                    {{dictionary.bad[language]}}
                </p>
            </div>
        </div>

        <div class="templateMsg">
            <p>
                {{dictionary.tempMsg1[language]}}
            </p>
            <hr>
            <p>
                {{dictionary.tempMsg2[language]}}
            </p> 
            <hr>
            <p>   
                {{dictionary.tempMsg3[language]}}
            </p>
        </div>


        <div class="buttons">
            <template v-if="false">
                <button @click="repeat">{{dictionary.btnRepeat[language]}}</button>
                
                <button @click="changeTopic">{{dictionary.btnChangeTopic[language]}}</button>
            </template>

            <button @click="finish_quiz">Продовжити</button>
        </div>
    </div>
</template>

<script>
import dictionary from './dictionary/score';
import vLoader from './vLoader.vue';

export default {
    name: 'vScore',
    components: {
        vLoader,
    },
    props: {
        score: Number,
        maxScore: Number,
        language: String,
        show_hints: Boolean,
        lesson: Number,
    },
    emits: ['finish_quiz'],
    data() {
        return {
            dictionary,
            percent: Math.floor((this.score/this.maxScore)*100),
            loader: false,
        }
    },
    methods: {
        finish_quiz() {
            this.$emit('finish_quiz')
        },
        async sendScoreInfo() {
            const jwt = localStorage.getItem('jwt')
            const lesson = this.lesson
            const score = this.percent/10
            const email = JSON.parse(localStorage.getItem("userInfo")).email
            let body = {
                jwt: jwt,
                lesson: lesson,
                score: score,
                email: email
            }
            const url = 'https://www.ukrge.site/api/update_progress.php'
            const json = JSON.stringify(body)
            console.log("json i send from Score", json)
            try {
                this.loader = true
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
                // const course_1 = JSON.stringify(result.course_1)
                localStorage.setItem('course_1', result.course_1)
                localStorage.setItem('jwt', result.jwt)
            } catch (error) {
                console.log(error)
                alert("Не вдалося зберегти прогрес")
            }finally {
                this.loader = false
            }
        },
    },
    mounted() {
        if(!this.show_hints) this.sendScoreInfo()
    }

}


</script>

<style scoped>

    * {
        font-size: 16px;
    }
    .scoreMain {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        margin: auto;
        align-content: space-around;
        height: 70vh;
        color: #fff;
        padding: 10px;
    }
    .score {
        display: block;
        width: 100%;
        margin: auto;
        height: fit-content;
    }

    .score100, .score75 {
        color: green;
    }
    .scoreLess75 {
        color: yellow;
    }
    p {
        width: fit-content;
        margin: auto;
    }

    .templateMsg {
        width: 100%;
        margin: 10px auto;
        height: fit-content;
    }
    .buttons {
        width: 100%;
        display: flex;
        justify-content: center;
        margin: auto;
        height: fit-content;
    }

    button {
        margin: 0 20px;
        width: 40%;
        height: 60px;
        background-color: transparent;
        border: 3px solid #3d3d3d;
        border-radius: 25px;
        color: #fff;
    }
    hr {
        width: 50%;
    }

</style>