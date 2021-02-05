<template>

    <b-embed
        type="iframe"
        aspec="16by9"
        :src="vlink"
        allowfullscreen
    ></b-embed>

</template>

<script>
export default {
    props: {
        vlink: {
            type: String,
            required: true
        }  
    },
    data(){
        return {

        }
    }
}
</script>