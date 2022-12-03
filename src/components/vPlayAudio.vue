<template>
<div class="play" @click="play">
    <img v-if="!isPlay" src="../assets/speaker-off.svg">
    <img v-if="isPlay" src="../assets/speaker-on.svg">
    <audio ref="play" @ended="stopSound"  src="https://ms01.spac.me/m/042244097183098044224026157038251030171110069206044230210194/1670078884/22192505/0/b9b287435f6600b8892c40b7b69802f5/PERCY%20SLEDGE%20-%20Fall%20Inside%20Your%20Eyes.mp3"></audio>
</div>
</template>

<script>

export default {
    name: 'vPlayAudio',
    props: {
        audioUrl: String,
    },
    data() {
        return {
            isPlay: false
            
        }
    },
    methods: {
        play() {
            this.isPlay = true
            let player = this.$refs.play
            player.play()
        },
        stopSound() {
            this.isPlay = false
        }
    }
}

</script>

<style scoped>
    * {
        margin: 0;
        padding: 0;
    }
    img {
        width: 30px;
        }
</style>