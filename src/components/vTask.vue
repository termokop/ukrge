<template>
<div class="task">
    <div class="quetion">
        <p>Here will be quetion</p>
    </div>
    <div class="variants">
        <p>
        <vPlayAudio></vPlayAudio> here will be variants</p>
    </div>
    <div class="ansButton">
        <button>This is CHECK-button</button>
    </div>
</div>
</template>

<script>
import vPlayAudio from './vPlayAudio.vue';
export default {
    name: 'vTask',
    components: {
        vPlayAudio,
    }
}

</script>

<style scoped>
    .task {
        display: block;
        width: fit-content;
        border: 2px solid blue;
        margin: auto;
        color: #fff;
    }
    .quetion {
        font-size: x-large;
        padding: 0;
        margin: auto;
    }

</style>