<template>
    <div class="task" v-if="task.type === 'create_sentence'">
        <div class="question">
            <p class="center">{{dictionary.task[language]}}</p>
        </div>
        <div class="variants">
            <div class="subquestion">
                <p class="tooltip">
                    <span  v-html="func.translit(task.question,language)"></span> 
                    <span  v-if="show_hints" class="tooltiptext">{{task.correct_answer}}</span>
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
            <div class="subvariants">
                <div 
                    class="word-item" 
                    v-for="variant in sorted" 
                    :key="variant" 
                    @click="addWordToSentence(variant)"
                    >
                    <button 
                    :disabled="answersArr.includes(variant)"
                    ><span v-html="func.translit(variant,language)"></span></button>
                </div>
            </div>
        </div>
        <div class="ansButton">
            <button
                @click="nextTask"
                :disabled="!showCheckBtn"
                :class="{visible:showCheckBtn}"
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
        <vDidUFindMistake
            :objInfo="task"
            >
        </vDidUFindMistake>
    </div>

    </template>
    
    <script>
    import func from '@/helpers/jsFunc'
    import dictionary from './dictionary/task_create_sentence'
    import VDidUFindMistake from './vDidUFindMistake.vue'
    export default {
        name: 'vTaskSen',
        components: {
    VDidUFindMistake
},
        props: {
            task: {
                type: Object,
                required: true
            },
            language: String,
            show_hints: Boolean,
        },
        data() {
            return {
                dictionary,
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
                //console.log("remove word")
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
            skipTask() {
                this.pointsForTheTask = 0
                this.$emit('nextTask', this.pointsForTheTask)
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



        .subquestion {
            width: fit-content;
            margin: auto;
            padding: 0;
        }
        .subquestion p  span{
            display: flex;
        }

        .answer {
            width: 100%;
            cursor: default;
        }
        .answer p {
            width: fit-content;
            margin: auto;
        }
    

    
        
        .subvariants {
            width: 100%;
            padding: 0;
            margin: auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .word-item {
            display: flex;
            width: max-content;
            align-content: center;
            margin: 5px;
        }
        .placehold {
            background-color: #2d2d2d;
            border: 1px solid #3d3d3d;
            border-radius: 3px;
            padding: 0 5px;
            margin-left: 3px;
            /* height: 90px; */
        }
        .wrongAns {
            background-color: darkred;
        }
        .corrAns {
            background-color: darkgreen;
            border-color: darkgreen;
        }

        .word-item button {
            background-color: transparent;
            color: #fff;
            border: 2px solid #3d3d3d;
            border-radius: 10px;
            padding: 10px;
            height: 60px;
            width: 100%;
            
        }
        .word-item button[disabled] {
            background-color: #3d3d3d;
            color: transparent;

        }
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


        @media screen and (max-width: 700) {
            .ua  {
                font-size: 1.8vw;
            }
        }

        
    
    
    </style>