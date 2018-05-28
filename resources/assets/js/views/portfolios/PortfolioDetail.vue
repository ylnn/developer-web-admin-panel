<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Portfolio Detail</div>

                    <div class="card-body">
                        
                            <div >
                                <h3 slot="header">Portfolio Detail</h3>
                                <div class="box" slot="body" v-show="form.id > 0">
                                        <form action="" class="inline">
                                            <div class="row">
                                                
                                                <div class="col-md-3 mb-3">
                                                    <label for="id">ID</label>
                                                    <input type="text" class="form-control" disabled="disabled" ref="id" id="id" placeholder="" value="" required v-model="form.id" autofocus>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" ref="title" id="title" placeholder="" value="" required v-model="form.title" autofocus>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="description">Description</label>
                                                    <wysiwyg v-model="form.description" />
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="row justify-content-start">
                                                        <div class="col-12">
                                                            <p>Selected photos <span class="badge badge-secondary" >{{selectPhotoStatus}}</span></p>
                                                        </div>
                                                        <div class="col-1" v-for="(file, index) in selectedPhotos" v-bind:key="file.id">
                                                            <span><img v-on:click="removeImageFromSelected(index)" :src="'/image/50/50/'+ file.filename" alt=""></span>
                                                        </div>
                                                        <div class="col-6" v-if="selectedPhotos.length == 0">None</div>
                                                    </div>
                                                    <div class="row justify-content-start">
                                                        <div class="col-12">
                                                            <hr>
                                                                <p>Uploaded Photos (click for add)</p>
                                                        </div>
                                                        <div class="col-1" v-for="file in remotePhotos" v-bind:key="file.id">
                                                            <span><img v-on:click="addImageToSelected(file)" :src="'/image/50/50/'+ file.filename" alt=""></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="url">URL</label>
                                                    <input type="text" class="form-control" ref="url" id="url" placeholder="" value="" v-model="form.url">
                                                </div>
                                                <div class="col-md-3 mb-3 d-flex flex-column justify-content-end">
                                                    <button class="btn btn-primary" @click="post_form">Save</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div v-show="showingAlert"
                                                class="alert alert-warning"
                                                >
                                        {{alertMessage}}
                                        </div>
                                    </div>
                            </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        data: function() {
            return {
                showingAlert: false,
                alertMessage : 'message',
                alertMessageStatus : 'warning',
                
                contents : [],

                form : {
                    id: '',
                    title: '',
                    description: '',
                    url: ''
                },

                remotePhotos: [],
                selectedPhotos: [],
                selectPhotoStatus : '',

            }
        },
        mounted() {
            let id = this.$route.params.id;
            if (id > 0) {
                // id var edit yapılacak
                console.log('id var edit yapılacak: ', id);
                this.edit(id);
            } else {
                console.log('id yok, yeni kayıt');
                this.create_and_get_id();
            }

            this.get_images();
            
        },

        methods: {

            // show form for new record, before show create and get id;
            showFormForNew: function() {
                this.create_and_get_id(); 
                this.showingForm = true; 
                let self = this;
                Vue.nextTick(function () {
                    // DOM updated
                    self.$refs.title.focus(); 
                });
            },

            // show alert
            showAlert(message, status) {
                this.alertMessage = message;
                this.alertMessageStatus = status;
                this.showingAlert = true;                
                setTimeout(() => {
                    this.showingAlert = false;                
                }, 1500);
            },

            // CREATE - create and get created id
            create_and_get_id: function () {
                let self = this;
                axios.post('/api/manage/portfolios/create')
                .then(function(response) {
                    self.form.id = response.data.id;
                })
            },

            //EDIT - get details and fill form for edit content 
            edit: function(id) {
                let self = this;
                axios.get(`/api/manage/portfolios/edit/${id}`)
                      .then(function (response) {
                            let data = response.data.data;
                            self.form.id = id;
                            self.form.title = data.title;
                            self.form.description = data.description;
                            self.form.url = data.url;
                            self.getRemoteSelectedPhotos();
                      });
            },

            // SAVE - save or update content with id
            post_form: function() {
                let self = this;

                if(self.form.id !== "" && self.form.title !== "" && self.form.description !== ""){
                    axios.post('/api/manage/portfolios/save/' + self.form.id, {
                        id: self.form.id,
                        title: self.form.title,
                        description: self.form.description,
                        url: self.form.url,
                    })
                    .then(function (response) {
                        self.showAlert('Saved.', 'success');
                        setTimeout(() => {
                            self.$router.push({ name: 'portfolios'});
                        }, 1500);
                    });
                }
            },

            remove: function(id) {
                let self = this;
                axios.delete(`/api/manage/portfolios/delete/${id}`)
                      .then(function (response) {
                          self.get_all();
                      });
            },

            clear_form: function() {
                this.form.id = "";
                this.form.title = "";
                this.form.description = "";
                this.form.url = "";
            },

            get_images: function() {
                let self = this;
                axios.get('/api/manage/images/all')
                      .then(({data}) => self.remotePhotos  = data.data);
            },

            addImageToSelected(file) {
                if(this.selectedPhotos.indexOf(file) === -1) {
                    this.selectedPhotos.push(file);
                }
                this.updateSelectedPhotos();
            },

            removeImageFromSelected(index) {
                this.selectedPhotos.splice(index, 1);
                this.updateSelectedPhotos();
            },

            updateSelectedPhotos() {
                let self = this;
                let newArray = [];
                self.selectedPhotos.forEach(function(element){
                    newArray.push(element.id);
                })
                let postStr = newArray.toString();
                axios.post('/api/manage/portfolios/images_sync/'+self.form.id, {
                    ids: postStr
                })
                .then(response => this.updateSelectPhotoStatus('Updated!'))
                .catch(error => this.updateSelectPhotoStatus('Error!'))
                ;
            },

            getRemoteSelectedPhotos() {
                let self = this;
                axios.get('/api/manage/portfolios/images/'+self.form.id)
                .then(function(response) {
                    // console.log(response.data);
                    self.selectedPhotos = response.data;
                })
                .catch(error => console.log('remote images error'));

            },

            updateSelectPhotoStatus(message){
                this.selectPhotoStatus = message;
                setTimeout(() => {
                    this.selectPhotoStatus = '';
                }, 1500);
            }
        }
    }
</script>
