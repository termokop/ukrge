<template>
<div class="task" v-if="task[0].type === 'words'">
    <div class="quetion">
        <p>Знайди відповідності</p>
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
                <p><span v-html="func.translit(item.ge)"></span></p>
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
                <p><span v-html="func.translit(item.ua)"></span></p>
            </button>
        </div>
    </div>
    <div class="ansButton" @click="nextTask">
        <button 
            :disabled="answered.length !== 4"
            :class="{visible: answered.length === 4}"
            >
            This is CHECK-button
        </button>
    </div>
</div>
</template>

<script>
import vPlayAudio from './vPlayAudio.vue';
import func from '@/helpers/jsFunc'
export default {
    name: 'vTask',
    components: {
        vPlayAudio,
    },
    props: {
        task: {
            type: Array,
            required: true
        }
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
        }
    },
    methods: {
        nextTask() {
            this.$emit('nextTask', this.pointsForTheTask / 4)
            this.answered = []
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
    }
}

</script>

<style scoped>
    .task {
        display: block;
        width: 100%;
        border: 2px solid blue;
        margin: auto;
        color: #fff;
    }
    .quetion {
        
        padding: 0;
        margin: auto;
        width: fit-content;
        font-size: x-large;
    }

    .ansButton {
        width: 50%;
        margin: auto;
        margin-top: 5%;
        margin-bottom: 10px;
    }
    .ansButton button {
        border-radius: 10px;
        width: 100%;
        margin: auto;
        background-color: green;
        padding: 20px;
        color: rgb(0, 0, 0);
        font-size: large;
        font-weight: bold;
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

    
    .variants {
        width: 100%;
        padding: 0;
        margin: 0;
        display: flex;
        flex-wrap: wrap;
        margin-bottom: 20px;
    }

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
        margin-top: 5%;
        height: 60px;
    }

    .word-item p {
        margin: auto;
        width: 90%;
        font-size: 15px;
    }

    .choosed {
        border-color: rgb(0, 8, 255);
    }

    .wrong {
        animation-name: wrong;
        animation-duration: 1s;
        background-color: rgb(255, 0, 0);
    }

    span {
        display: flex;
        width: fit-content;
        margin: auto;
    }



</style>