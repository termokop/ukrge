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
                <p><span v-html="translit(item.ge)"></span></p>
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
                <p>{{item.ua}}</p>
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
        }
    },
    methods: {
        nextTask() {
            console.log(this.pointsForTheTask)
            this.$emit('nextTask', this.pointsForTheTask)
            this.answered = []
        },
        shuffle() {
            let numbers = [...this.sortedTask];
            let first,
                second,
                temp,
                count = numbers.length;
            for (let i = 0; i < 4; i++) {
                first = Math.floor(Math.random() * count);
                second = Math.floor(Math.random() * count);
                temp = numbers[first];
                numbers[first] = numbers[second];
                numbers[second] = temp;
            }
            return numbers;
        },
        translit(str) {
            let ge = ['ა','ბ','გ','დ','ე','ვ','ზ','თ','ი','კ','ლ','მ','ნ','ო','პ','ჟ','რ','ს','ტ','უ','ფ','ქ','ღ','ყ','შ','ჩ','ც','ძ','წ','ჭ','ხ','ჯ','ჰ']
            let ua = ['а','б','ґ','д','е','в','з','т*','і','к','л','м','н','о','п','ж','р','с','т','у','ф*','к*','р*','к','ш','ч','ц','дз','ц*','ч*','х','дж','г']

            //рядок з якого робитиму трансліт

            // записую трансліт в змінну res
            let spaces = 0
            for( let i = 0; i<str.length; i++) {
                if(str[i] === ' ') spaces++
            }
            // записую трансліт в змінну res
            let res = []
            for (let i = 0; i < str.length; i++) {
                    res.push(~ge.indexOf(str[i]) ? ua[ge.indexOf(str[i])] : str[i])
                
            }
            let result = '';
            // додаємо значення в таблиці, розділені пробілами
            let j = 0;
            for(let i = 0; i<= spaces; i++) {
                let strForTableGE = ``
                let strForTableUA = ``
                while(j<str.length) {
                    if(str[j] === ' ') {
                        j++
                        break;}

                    strForTableGE += `<td>${str[j]}</td>`
                    strForTableUA += `<td>${res[j]}</td>`
                    j++
                }
                result += `
                <table>
                    <tr class="ge">
                        ${strForTableGE}
                    </tr>
                    <tr class="ua">
                        ${strForTableUA}
                    </tr>
                </table>
                &nbsp;&nbsp;&nbsp;`
            }
            return result
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
        sorted() {return this.shuffle()}
        
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