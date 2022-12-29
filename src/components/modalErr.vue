<template>
    <div class="bg" @click="$emit('closeModal')"></div>
    <div class="modal">
        <h1>Повідомлення про помилку</h1>
        <div class='description'>
            <form action="">
                <div class="checkboxItem">
                    <input type="checkbox" name="audio" id="audio" v-model="audio">
                    <label for="audio">Некоректне аудіо</label>
                </div>
                <div class="checkboxItem">
                    <input type="checkbox" name="gramar" id="gramar" v-model="gramar">
                    <label for="gramar">Граматична помилка</label>
                </div>
                <div class="checkboxItem">
                    <input type="checkbox" name="translate" id="translate" v-model="translate">
                    <label for="translate">Некоректний переклад</label>
                </div>
                <div class="checkboxItem">
                    <input type="checkbox" name="other" id="other" v-model="other">
                    <label for="other">Інша проблема</label>
                </div>
                <div class="checkboxItem">
                    <textarea name="explan" id="explan" maxlength="255" placeholder="Опишіть детальніше, будь ласка..."  v-model="text"></textarea>
                </div>
            </form>
        </div>
        <div class="buttons">
            <button class="red" @click="$emit('closeModal')">Відмінити</button>
            <button class="green" @click="sendMistakeInfo">Надіслати</button>
        </div>
    </div>


</template>

<script>
import dictionaryModal from './dictionary/modals';

export default {
    name: 'vModalErr',
    props: {
        obj: Object,
    },
    emits: ['closeModal'],
    data() {
        return {
            dictionaryModal,
            audio: false,
            gramar: false,
            translate: false,
            other: false,
            text: '',

        }
    },
    methods: {
        async sendMistakeInfo() {
            let mistakeInfoObj =  {
                info: {
                    audio: this.audio,
                    gramar: this.gramar,
                    translate: this.translate,
                    other: this.other,
                    obj: this.obj
                },
                user: JSON.parse(localStorage.userInfo).email,
                text: this.text
            }
            const json = JSON.stringify(mistakeInfoObj)
            
            console.log('object',mistakeInfoObj)
            console.log('json',json)
            const url = 'https://www.ukrge.site/api/set_mistake.php'
            try {
                let response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'Access-Control-Allow-Origin': '*' 
                    },
                    body: json
                })
                let result = await response.json()
                console.log('result',result)
                alert('Дякую, що допомогаєте нам ставати краще. Найближчим часом проблему буде розглянуто.')
                this.$emit('closeModal')
            } catch(e) {
                alert(e)
            }
        }
    }
}

</script>

<style scoped>
* {
    margin: 5px;
    padding: 0;
    box-sizing: border-box;
    font-size: 16px;
    color: black;
}

.bg{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 200%;
  opacity: 50%;
  background-color: black;
  z-index: 2;
}

.modal {
    position: fixed;
    top: 50%;
    left: 50%;
    margin-right: -50%;
    transform: translate(-50%, -50%);
    max-width: 500px;
    background-color: aliceblue;
    z-index: 3;
    border-radius: 30px;
    padding: 20px;
}

h1, .description, .buttons {
    width: 100%;
}

.buttons {
    display: flex;
    justify-content: space-around;
}
form {
    width: 100%;
    margin: 0;
}


h1 {
    font-size: 18px;
}

textarea {
    height: 80px;
    width: 100%;
    padding: 2px;
    border: rgb(87, 85, 85) solid 1px;
}

</style>