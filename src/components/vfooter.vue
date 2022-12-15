<template>
     <div class="footer">
        <ul class="list">
            <li class="list-item">
                <button @click.prevent="showInfo(arr[0])">{{dictionary.about[language]}}</button>
            </li>
            <li class="list-item">
                <button @click.prevent="showInfo(arr[1])">{{dictionary.cooper[language]}}</button>
            </li>
            <li class="list-item">
                <button @click.prevent="showInfo(arr[2])">{{dictionary.something[language]}}</button>
            </li>
        </ul>
      </div>
</template>

<script>
import dictionary from './dictionary/footer';
export default {
    name: 'vFooter',
    props: {
        language: String
    },
    data() {
        return {
            dictionary,
            arr: [
                    'Я українець. Моя дружина з Грузії. Я бачу проблему у відсутності безкоштовного сервісу, який здатен допомогти нам вивчати мову один одного. З цією ідеєю я почав працювати над даним проектом.',
                    `Розробник: Груба Юрій
                    instagram: https://www.instagram.com/hruba.yurii/
                    telegram: 380669980782
                    Пишіть мені з приводу проблем, пропозицій та ідей. Залюбки вислухаю кожного.`, 
                    `Ви завжди можете допомогти проекту. Нам потрібні люди, які добре володіють українською та грузинською мовами, або які просто хочуть їй вчити, розвиваючись разом з проеком. Якщо це про тебе - напиши мені.
                    Також ви можете підтримати фінансово:
                    Mono: 4441 1144 4029 1555,
                    BOG: GE02BG0000000539571616,
                    BUST, USDT: 0xcaF909f67943bD712EE0a2275F740f27EB9c4ba4`]
        }
    },
    methods: {
        showInfo(info) {
            alert(info)
        }
    }
}


</script>


<style scoped> 
    .footer {
        width: fit-content;
        margin: auto;
        height: 45px;
    }
    .list {
        display: flex;
        align-items: center;
        margin: 5px;
        padding: 0;
        
    }
    .list-item {
        display: inline;
        margin: 10px;
        justify-content: center;
        align-content: center;
        font-size: 13px;
        background-color: #0000cc;
        border-radius: 5px;
        padding: 5px;
    }
    a{
        color: rgb(255, 255, 255);
        text-decoration: none;
    }
</style>