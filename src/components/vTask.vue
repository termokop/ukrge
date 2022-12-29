<template>
<div class="task" v-if="task[0].type === 'words'">
    <div class="question">
        <p class="center">{{dictionary.task[language]}}</p>
    </div>
    <div class="variants">
        <p><vPlayAudio v-if="false"></vPlayAudio></p>
        <div class="word-items">
            <!-- ge------------------------------------------ -->
            <button 
                :disabled="answered.includes(item.id)"
                class="word-item"
                :class="{choosed: item.id === choosedWordGe, wrong: wrongAnsForAnimatGe === item.id}" 
                v-for="item in task" 
                :key="item.id" 
                @click="chooseWordGe(item.id)"
                >
                <p><span v-html="func.translit(item.ge,language)"></span></p>
            </button>
        </div>
        <div class="word-items">
            <!-- ua----------------------------------------------- -->
            <button 
                :disabled="answered.includes(item.id)"
                class="word-item" 
                :class="{choosed: item.id === choosedWordUa, wrong: wrongAnsForAnimatUa === item.id}"
                v-for="item in sorted" 
                :key="item.id" 
                @click="chooseWordUa(item.id)"
                >
                <p><span v-html="func.translit(item.ua,language)"></span></p>
            </button>
        </div>
    </div>
    <div class="ansButton">

        <button 
            @click="nextTask"
            :disabled="answered.length !== 4"
            :class="{visible: answered.length === 4}"
            >
            {{dictionary.button[language]}}
        </button>
        <div 
            class="skip"
            @click="skipTask">
            <button>
                Пропустити
            </button>
        </div>

    </div>
</div>
</template>

<script>
import vPlayAudio from './vPlayAudio.vue';
import func from '@/helpers/jsFunc'
import dictionary from './dictionary/task_words';
export default {
    name: 'vTask',
    components: {
        vPlayAudio,
    },
    props: {
        task: {
            type: Array,
            required: true
        },
        language: String,
    },
    data() {
        return {
            choosedWordGe: '',
            choosedWordUa: '',
            answered: [],
            pointsForTheTask: 4,
            wrongAnsForAnimatGe: '',
            wrongAnsForAnimatUa: '',
            func,
            dictionary,
        }
    },
    methods: {
        nextTask() {
            this.$emit('nextTask', this.pointsForTheTask / 4)
            this.answered = []
        },
        skipTask() {
            this.pointsForTheTask = 0
            this.nextTask()
        },
        chooseWordGe(key) {
            this.choosedWordGe = key === this.choosedWordGe ? '' : key
            this.compireWords(key)
            
            
        },
        chooseWordUa(key) {
            this.choosedWordUa = key === this.choosedWordUa ? '' : key
            this.compireWords(key)
            
        },
        compireWords(key) {
            
            //correct answer
            if(this.choosedWordGe === this.choosedWordUa && this.choosedWordGe !== '') {
                this.answered.push(key)
                this.choosedWordGe = ''
                this.choosedWordUa = ''
            }
            
            //wrong answer
            if(this.choosedWordGe !== this.choosedWordUa && this.choosedWordGe !== '' && this.choosedWordUa !== '') {
                this.pointsForTheTask = this.pointsForTheTask === 0 ? 0 : --this.pointsForTheTask
                this.wrongAnsForAnimatGe = this.choosedWordGe
                this.wrongAnsForAnimatUa = this.choosedWordUa
                setTimeout(()=> {
                    this.wrongAnsForAnimatGe = ''
                    this.wrongAnsForAnimatUa = ''
                }, 1000)
                this.choosedWordGe = ''
                this.choosedWordUa = ''
            }
        }
    },
    computed: {
        sortedTask() { return [...this.task]},
        sorted() {return this.func.shuffle([...this.sortedTask])}
        
    },
    created() {
        window.addEventListener('keydown', e=> {
                if(e.key === 'Enter' && this.answered.length === 4) this.nextTask()
            })
    }
}
 // i need it 
    // cursor: pointer;
</script>

<style scoped>
    .word-items {
        width: 50%;
        margin: 0;
    }

    .word-items button {
        background-color: transparent;
        color: #fff;
    }

    @keyframes correct {
        from {background-color: green;}
        to {background-color: #3d3d3d;}
}
    @keyframes wrong {
        from {background-color: red;}
        to {background-color: #1d1d1d;}
}

    .variants button[disabled] {
        background-color: #3d3d3d;
        color: #000;
        animation-name: correct;
        animation-duration: 2s;
    }

    .word-item {
        display: flex;
        width: 75%;
        border: 3px solid #3d3d3d;
        border-radius: 10px;
        margin: auto;
        margin-top: 3%;
        height: 60px;
    }

    .word-item p {
        margin: auto;
        width: 90%;
    }
    .word-items :deep() table{
            font-size: 14px;
        }
    .word-items :deep() table .ua{
        font-size: 12px;
    }

    .choosed {
        border-color: rgb(0, 8, 255);
    }

    .wrong {
        animation-name: wrong;
        animation-duration: 1s;
        background-color: rgb(255, 0, 0);
    }
    button {
        width: 30%;
        background-color: #fff;
    }

    span {
        display: flex;
        width: fit-content;
        margin: auto;
    }

    @media screen and (max-width: 700px) {
        .word-item {
        width: 95%;
    }
    .word-items :deep() table {
            font-size: 2.3vw;
        }
    .word-items :deep() table .ua {
        font-size: 1.8vw;
    }

    }


</style>
