<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section id="video-chat" class="col-12">
          <div class="card">
            <div class="card-body text-justify">
              <livestream />
              <!-- <div class="btn btn-block btn-lg btn-primary mt-3">Start Live Streaming</div> -->
            </div>
          </div>
        </section>
      </div>
    </div>
  </section>
</template>

<script>
import livestream from '../components/livestream';

export default {
    components:{
        livestream
    },
    data(){
        return {

        }
    }
}
</script>