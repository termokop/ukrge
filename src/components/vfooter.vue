<template>
     <div class="footer">
        <ul class="list">
            <li class="list-item">
                <a href="#">Про нас</a>
            </li>
            <li class="list-item">
                <a href="#">Співпраця</a>
            </li>
            <li class="list-item">
                <a href="#">Ще щось</a>
            </li>
        </ul>
      </div>
</template>

<script>
export default {
    name: 'vFooter'
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