<template>
    <!-- this component is to service the filepond upload -->
    <div id="documents" class="form-group">
        <div class="card mt-2">
            <div class="card-body">
                <div class="card-title">Documents to include</div>
                <!-- <div class="actions">
                    <button class="btn btn-light">
                    <i class="icon trash"></i>
                    </button>
                </div> -->
                <file-pond
                    name="test"
                    server="http://lwmv3-gat.test/api/uploadFileP"
                    ref="pond"
                    class-name="my-pond"
                    label-idle="Drop files here..."
                    allow-multiple="true"
                    accepted-file-types="image/jpeg, image/png"
                    v-bind:files="myFiles"
                    v-on:init="handleFilePondInit"/>
            </div>
        </div>
    </div>
</template>

<script>
// Import FilePond
import vueFilePond from 'vue-filepond';

// Import plugins
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';

// Import styles
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';


// Create FilePond component
const FilePond = vueFilePond( FilePondPluginFileValidateType, FilePondPluginImagePreview );

export default {
    components: {
        FilePond
    },    
    data(){
        return{
            myFiles: []
        }
    },

    methods: {
        handleFilePondInit: function() {
            console.log('FilePond has initialized');

            // FilePond instance methods are available on `this.$refs.pond`
        }
    },
}
</script>