<template>
<div class="score">
    <p>
        Your score {{score}}
    </p>
    <p>
        {{percent}}% correct answers
    </p>
</div>

</template>

<script>
export default {
    name: 'vScore',
    props: {
        score: Number,
        maxScore: Number,
    },
    data() {
        return {
            percent: Math.floor((this.score/this.maxScore)*100)
        }
    },
    methods: {
        sendScoreInfo() {
            // here fetch for send new score on the server
        }
    }
}


</script>

<style scoped>
    .score {
        width: 100%;
    }
    p {
        width: fit-content;
        margin: auto;
        font-size: 60px;
        margin-top: 30px;
        margin-bottom: 20px;
    }

</style>