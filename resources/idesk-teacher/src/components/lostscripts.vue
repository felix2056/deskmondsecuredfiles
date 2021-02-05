<template>
<div>
        <b-modal id="AddYoutube" title="Add YouTube link">
         <form>
            <div class="form-group">
               <input type="text" class="form-control" id="ClassYoutubelink" placeholder="Paste YouTube link here" v-model="classDet.videoLink">
               <b-button variant="primary mt-2" @click="onAddvideo">Add video</b-button>
            </div>
         </form>
      </b-modal>

      <b-modal id="Atxt" title="Add Text">
         <form>
            <div class="form-group">
               <input type="text" class="form-control" id="ClassText" placeholder="Start typing..." v-model="classDet.content">
               <!-- <b-button variant="primary mt-2">Add video</b-button> -->
            </div>
         </form>
      </b-modal>

      <b-modal id="AddDoc" title="Add Document" size="lg" @ok="refreshImageThumbs">
         <uppydoc :maxFileSizeInBytes="maxFileSize" :classId="classDet.id" />
      </b-modal>
      <b-modal id="AddImage" title="Add Image" size="lg" @ok="refreshImageThumbs">
         <uppygen :maxFileSizeInBytes="maxFileSize" :classId="classDet.id" />
      </b-modal>
</div>
</template>