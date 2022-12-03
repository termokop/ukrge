<template>
    <div class="lds-ellipsis" v-if="(loader === true)">
        <div>

        </div>
        <div>

        </div>
        <div>

        </div>
        <div>

        </div>
    </div>
</template>

<script>
 export default {
    name: 'vLoader',
    props: {
        loader: Boolean,
    }
 }

</script>

<style scoped>
    /* animation for load....*/
.lds-ellipsis {
  width: 80px;
  height: 80px;
  position: fixed;
  top: 50%;
  left: 50%;
  margin-right: -50%;
  transform: translate(-50%, -50%);
  z-index: 999999;
}
.lds-ellipsis div {
  position: fixed;
  width: 13px;
  height: 13px;
  background: rgb(4, 0, 255);
  animation-timing-function: cubic-bezier(0, 1, 1, 0);
}
.lds-ellipsis div:nth-child(1) {
  left: 8px;
  animation: lds-ellipsis1 0.6s infinite;
}
.lds-ellipsis div:nth-child(2) {
  left: 8px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(3) {
  left: 32px;
  animation: lds-ellipsis2 0.6s infinite;
}
.lds-ellipsis div:nth-child(4) {
  left: 56px;
  animation: lds-ellipsis3 0.6s infinite;
}
@keyframes lds-ellipsis1 {
  0% {
    transform: scale(0);
  }
  100% {
    transform: scale(1);
  }
}
@keyframes lds-ellipsis3 {
  0% {
    transform: scale(1);
  }
  100% {
    transform: scale(0);
  }
}
@keyframes lds-ellipsis2 {
  0% {
    transform: translate(0, 0);
  }
  100% {
    transform: translate(24px, 0);
  }
}
</style>