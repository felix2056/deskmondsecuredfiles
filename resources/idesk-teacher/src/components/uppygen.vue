<template>
    <form>
        <div class="image-container mb-3" v-if="previewPath">
            <img :src="previewPath" alt="Uploaded Image Preview">
        </div>
        <div class="form-group">
            <div ref="dashboardContainer"></div>
        </div>
    </form>
</template>

<script>
    import Uppy from '@uppy/core';
    import XHRUpload from '@uppy/xhr-upload';
    import Dashboard from '@uppy/dashboard';

    // Import From 3rd Party
    import Instagram from "@uppy/instagram";
    import Facebook from "@uppy/facebook";
    import Webcam from "@uppy/webcam";
    import ScreenCapture from "@uppy/screen-capture";
    import ImageEditor from "@uppy/image-editor";

    import '@uppy/core/dist/style.css'
    import '@uppy/dashboard/dist/style.css'

    export default {
        props: {
            maxFileSizeInBytes: {
                type: Number,
                required: true
            },
            classId: {
                type: Number,
                required: true,
            }
        },
        data() {
            return {
                payload: null,
                previewPath: null,
                disabled: true
            }
        },
        mounted() {
            this.instantiateUppy()
        },
        methods: {
            instantiateUppy() {
                this.uppy = Uppy({
                    debug: true,
                    autoProceed: false,
                    restrictions: {
                        maxFileSize: this.maxFileSizeInBytes,
                        minNumberOfFiles: 1,
                        maxNumberOfFiles: 10,
                        allowedFileTypes: ['image/*']
                    },
                    note: 'Images only please ...',
                    meta: {
                        id: 6,
                    },
                    onBeforeFileAdded: (currentFile, files)=>{
                        uppy.setMeta({id: this.classId});
                    } 
                    
                })
                    
                    .use(Dashboard, {
                        hideUploadButton: false,
                        inline: true,
                        height: 350,
                        target: this.$refs.dashboardContainer,
                        replaceTargetContent: true,
                        showProgressDetails: true,
                        browserBackButtonClose: true

                    })
                    .use(Instagram, { 
                        target: Dashboard, 
                        companionUrl: 'https://companion.uppy.io' 
                    })
                    .use(Facebook, { 
                        target: Dashboard, 
                        companionUrl: 'https://companion.uppy.io' 
                    })
                    .use(Webcam, { 
                        target: Dashboard 
                    })
                    .use(ScreenCapture, { 
                        target: Dashboard 
                    })
                    .use(ImageEditor, { 
                        target: Dashboard 
                    })
                    .use(XHRUpload, {
                        limit: 10,
                        // endpoint: 'http://lwmv3-gat.test/api/uploadFiles',
                        endpoint: '/api/uploadFiles',
                        formData: true,
                        fieldName: 'file',
                        metafields: ['name','id'],
                        withCredentials: true,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // from <meta name="csrf-token" content="{{ csrf_token() }}">
                            'X-Requested-With' : 'XMLHttpRequest'
                        }
                    });

                this.uppy.on('complete', (event) => {
                    if(event.successful[0] !== undefined) {
                        this.payload = event.successful[0].response.body.path;

                        this.disabled = false;
                    }
                });
            },
            updatePreviewPath({path}) {
                this.previewPath = path;

                return this;
            },
            resetUploader() {
                this.uppy.reset();
                this.disabled = true;

                return this;
            },
            confirmUpload() {
                if(this.payload) {
                    this.disabled = true;
                    axios.post('/store', { file: this.payload })
                        .then(({ data }) => {
                            this.updatePreviewPath(data)
                                .resetUploader()
                                .flash('Upload Successful!','success');
                        })
                        .catch(err => {
                            console.error(err);

                            this.resetUploader();
                        })
                    ;
                } else flash(`You don't have any file in processing`,'warning');

            }
        }
    };
</script>

<style scoped>
    .image-container {
        height: 150px;
        width: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: auto;
        margin-left: auto;
    }

    .image-container > img {
        width: inherit;
        height: inherit;
    }
</style>