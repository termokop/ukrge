<template>
<div v-if="!disabled" class="play"  @click="play">
    <img v-if="!isPlay" src="../assets/speaker-off.svg">
    <img v-if="isPlay" src="../assets/speaker-on.svg">
    <audio ref="play" @ended="stopSound" @error="notFound"  :src="url"></audio>
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
            isPlay: false,
            disabled: false,
            
        }
    },
    methods: {
        play() {
            this.isPlay = true
            let player = this.$refs.play
            player.play()
            console.log(this.url)
        },
        stopSound() {
            this.isPlay = false
        },
        notFound() {
            this.disabled= true
        },
    },
    computed: {
        url() {
            return 'https://www.ukrge.site/audio/' + this.audioUrl + '.mp3'

        }
    },
    mounted() {
        console.log('mounted')
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