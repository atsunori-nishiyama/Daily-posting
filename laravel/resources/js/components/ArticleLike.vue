<template>
  <div>
    <button
      type="button"
      class="btn m-0 p-1 shadow-none"
    >
      <i class="fas fa-heart mr-1"
       :class="{'red-text':this.isLikedBy, 'animated heartBeat fast' :this.gotToLike}" 
       @click="clickLike"
      />
    </button>
    {{ countLikes }}
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
      initialCountLikes: {
        type: Number,
        default: 0,
      },
      authorized: {
        type: Boolean,
        default: false,
      },
      endpoint: {
        type: String,
      }
    },
    data() {
      return {
        //プロパティinitialIsLikedByの値をそのままデータisLikedByにセット
        //データisLikedByを別途定義して、こちらを利用する※countLikes:も同様
        isLikedBy: this.initialIsLikedBy,
        countLikes: this.initialCountLikes,
        gotToLike: false,
      }
    },
    methods: {
      clickLike() {
        if (!this.authorized) {
          alert('いいね昨日はログイン中のみ使用できます')
          return
        }

        this.isLikedBy
          ? this.unlike()
          : this.like()
      },
      async like() {
        //URIarticles/{article}/likeに対して、HTTPのPUTメソッドでリクエスト
        const responce = await axios.put(this.endpoint) 

        this.isLikedBy = true
        this.countLikes = responce.data.countLikes //いいね数を取得、いいね数の表示が変更
        this.gotToLike = true
      },
      async unlike() {
        const responce = await axios.delete(this.endpoint)

        this.isLikedBy = false
        this.countLikes = responce.data.countLikes
        this.gotToLike = false
      },
    },
  }
</script>