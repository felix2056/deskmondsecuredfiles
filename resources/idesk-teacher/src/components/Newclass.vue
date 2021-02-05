<template>
    <div class="col-12 col-md-6 col-xl-4 mb-4">
        <div class="card h-100">
        <img :src="imagepath" class="card-img-top" alt="Maths">
        <div class="card-body d-flex justify-content-between flex-column">
            <h5 class="card-title mb-3">{{data.classname}}</h5>
            <p>Meet your teacher online today at 9am</p>
            <!-- <a href="pupils-start-class.php?id=" class="btn btn-primary btn-lg btn-block">Join class</a> -->
            <router-link :to="{ name: 'AttendClass', params: { data } }" class="btn btn-primary btn-lg btn-block">Join class</router-link>
        </div>
        <div class="card-footer">
            <small class="text-muted">Starting in 30 mins</small>
        </div>
        </div>
    </div>    
</template>

<script>
export default {
    props:['data'],
    data() {
        return{
            imagepath:'/assets/'
        }
    },
    mounted(){
        this.onImagepath();
    },
    methods:{
        onImagepath(){
            this.imagepath = this.imagepath + this.data.subject + '.png';
        }
    }
}

</script>