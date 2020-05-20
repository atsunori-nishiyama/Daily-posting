<template>
  <div>
    <button
      type="button"
      class="btn m-0 p-1 shadow-none"
    >
      <i class="fas fa-heart mr-1"
       :class="{'red-text':this.isLikedBy}" 
      />
    </button>
    10
  </div>
</template>
<script>
  export default {
    props: {
      //Blade側で、initial-is-liked-byに渡した値は、プロパティinitialIsLikedByに渡され
      initialIsLikedBy: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        //プロパティinitialIsLikedByの値をそのままデータisLikedByにセット
        //データisLikedByを別途定義して、こちらを利用する
        isLikedBy: this.initialIsLikedBy,
      }
    },
  }
</script>