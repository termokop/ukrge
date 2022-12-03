<template>
<div class="quizz">
<vTask></vTask>
</div>
</template>

<script>
import vTask from './vTask.vue'

export default {
    name: 'vQuizz',
    components: {
        vTask,
    }
}

</script>

<style scoped>
 .quizz {
    display: flex;
    border: 2px solid red;
    width: 50%;
    min-width: 600px;
    margin: auto;
 }
</style>