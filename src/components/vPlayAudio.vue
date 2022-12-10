<template>
<div class="play" @click="play">
    <img v-if="!isPlay" src="../assets/speaker-off.svg">
    <img v-if="isPlay" src="../assets/speaker-on.svg">
    <audio ref="play" @ended="stopSound"  src=""></audio>
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