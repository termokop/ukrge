<template>
    <div class="task" v-if="task.type === 'create_sentence'">
        <div class="quetion">
            <p>Заповни пробіли в перекладі речення:</p>
        </div>
        <div class="question ">
            <p class="tooltip">
                <span  v-html="func.translit(task.question)"></span> 
                <span class="tooltiptext">{{task.correct_answer}}</span>
            </p>
        </div>
        <div class="answer">
            <p ref="answer">
                <span v-for="(word,index) in sentence" :key="word"> 
                    <span v-if="word!=='<...>'">{{word + ' '}}</span> 
                    <span 
                        class="placehold" 
                        :class="{wrongAns:wrongAns,corrAns: corrAns}"
                        @click="removeWord(index)" 
                        v-else>{{count(index) + ' '}}
                    </span>
                </span>
            </p>
        </div>
        <div class="variants">
            <div 
                class="word-item" 
                v-for="variant in sorted" 
                :key="variant" 
                @click="addWordToSentence(variant)"
                >
                <button 
                :disabled="answersArr.includes(variant)"
                ><span v-html="func.translit(variant)"></span></button>
            </div>
        </div>
        <div 
            
            class="ansButton"
            @click="nextTask"
            >
            <button
                :disabled="!showCheckBtn"
                :class="{visible:showCheckBtn}"
                >
                {{ansBtnText}}
            </button>
        </div>
    </div>
    </template>
    
    <script>
    import func from '@/helpers/jsFunc'
    export default {
        name: 'vTaskSen',
        components: {
        },
        props: {
            task: {
                type: Object,
                required: true
            }
        },
        data() {
            return {
                ansBtnText: 'Перевірити',
                variants: [...this.task.variants_fake.split(','), ...this.task.variants_real.split(',')],
                sentence: [],
                answersArr: [],
                indexes: [],
                showCheckBtn: false,
                func,
                pointsForTheTask: 1,
                correct_ans_arr:  [...this.task.correct_answer.split('|')],
                wrongAns: false,
                corrAns: false
            }
        },
        methods: {
            removeWord(index) {
                console.log("remove")
                this.answersArr[index] = '...'
                this.showCheckBtn = false
            },
            addWordToSentence(word) {
                for ( let value of this.indexes) {
                    if(this.answersArr[value] === '...') {
                        this.answersArr[value] = word
                        this.checkBtn()
                        return
                    }
                }
            },
            count(index) {
                if(!this.indexes.includes(index)) this.indexes.push(index)
                return this.answersArr[index]
            },
            nextTask() {
                if(this.correct_ans_arr.includes(this.$refs.answer.textContent.trim())) {
                    this.corrAns = true
                    setTimeout(()=> {
                        setTimeout(()=> {
                            this.$emit('nextTask', this.pointsForTheTask)
                        }, 0)
                        this.corrAns = false
                    }, 1000)
                } else {
                    this.pointsForTheTask = 0
                    this.resetAnswers()
                    this.wrongAns = true
                    setTimeout(()=> {
                        this.wrongAns = false
                    }, 1000)
                }
            },
            checkBtn() {
                for ( let value of this.indexes) {
                    if(this.answersArr[value] === '...') {
                        this.showCheckBtn = false
                        return
                    }
                }
                this.showCheckBtn = true
                return
            },
            resetAnswers() {
                this.answersArr = []
                for (let i = 0; i < this.sentence.length; i++) {
                    this.answersArr.push('...')
                }
            }
            
            
        },
        computed: {
            sorted() {return this.func.shuffle([...this.variants])}
            
        },
        created() {
            this.sentence = this.task.answer.split(' ')
            window.addEventListener('keydown', e=> {
                if(e.key === 'Enter' && this.showCheckBtn) this.nextTask()
            })
            
        },
        mounted() {
            this.resetAnswers()
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

        }
        .question {
            display: flex;
            padding: 0;
            margin: auto;
            width: fit-content;
            font-size: x-large;
        }
        .question span {
            display: flex;
            width: fit-content;
        }

        .answer {
            width: fit-content;
            margin: auto;
            font-size: 40px;
            height: 200px;
        }
    
        .ansButton {
            width: 50%;
            margin: auto;
            margin-top: 5%;
            margin-bottom: 10px;
        }
        .ansButton button {
            border-radius: 30px;
            width: 100%;
            margin: auto;
            background-color: green;
            padding: 20px;
            color: rgb(0, 0, 0);
            font-size: large;
            font-weight: bold;
            border: none;
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
            width: 75%;
            padding: 0;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

    
        /* @keyframes correct {
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
        } */
    
        .word-item {
            display: flex;
            width: max-content;
            margin: 5px;
        }
        .placehold {
            background-color: #2d2d2d;
            border: 3px solid #3d3d3d;
            border-radius: 10px;
            padding: 0 5px;
            margin-left: 3px;
            /* height: 90px; */
        }
        .wrongAns {
            background-color: darkred;
        }
        .corrAns {
            background-color: darkgreen;
        }

        .word-item button {
            background-color: transparent;
            color: #fff;
            border: 3px solid #3d3d3d;
            border-radius: 15px;
            padding: 10px;
            font-size: 20px;
            height: 70px;
            
        }
        .word-item button[disabled] {
            background-color: #3d3d3d;
            color: transparent;

        }
    
        /* .wrong {
            animation-name: wrong;
            animation-duration: 1s;
            background-color: rgb(255, 0, 0);
        } */
        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: fit-content;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            opacity: 80%;
            
            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 1;
        }

/* Show the tooltip text when you mouse over the tooltip container */
        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
        .tooltip .tooltiptext::after {
            content: " ";
            position: absolute;
            bottom: 100%;  /* At the top of the tooltip */
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: transparent transparent black transparent;
        }
        
    
    
    </style>