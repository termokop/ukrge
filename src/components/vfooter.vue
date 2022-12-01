<template>
     <div class="footer">
        <ul class="list">
            <li class="list-item">
                <a href="#">{{dictionary.about[language]}}</a>
            </li>
            <li class="list-item">
                <a href="#">{{dictionary.cooper[language]}}</a>
            </li>
            <li class="list-item">
                <a href="#">{{dictionary.something[language]}}</a>
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
            dictionary
        }
    }
}


</script>


<style scoped> 
    .footer {
        width: fit-content;
        margin: auto;
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
        background-color: rgb(150, 11, 11);
        border-radius: 5px;
        padding: 5px;
    }
    a{
        color: rgb(0, 0, 0);
        text-decoration: none;
    }
</style>