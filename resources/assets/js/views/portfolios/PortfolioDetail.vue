<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Portfolio Detail</div>

                    <div class="card-body">
                        
                            <div >
                                <h3 slot="header">Portfolio</h3>
                                <div class="box" slot="body" v-show="form.id > 0">
                                        <form action="" class="inline">
                                            <div class="row">
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="id">ID</label>
                                                    <input type="text" class="form-control" ref="id" id="id" placeholder="" value="" required v-model="form.id" autofocus>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" ref="title" id="title" placeholder="" value="" required v-model="form.title" autofocus>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="description">Description</label>
                                                    <!-- <input type="text" class="form-control" id="description" placeholder="" description="" required v-model="form.description"> -->
                                                    <textarea class="form-control" cols="30" rows="10" v-model="form.description"></textarea>
                                                    <!-- <wysiwyg v-model="form.description" /> -->
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="row justify-content-start">
                                                        <div class="col-1" v-for="file in remotePhotos" v-bind:key="file.id">
                                                            <span> <img v-on:click="add_image_to_editor(file.filename)" :src="'/image/50/50/'+ file.filename" alt=""></span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <p>Select photo, copy and paste into text.</p>
                                                        <textarea class="image-textarea" cols="40" v-model="imageTextArea" ref="imageTextArea"></textarea>
                                                        <button class="btn btn-sm" v-on:click="copyImage">Copy</button>
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

                content :'',
                
                form : {
                    id: '',
                    title: '',
                    description: '',
                    url: ''
                },

                remotePhotos: [],
                imageTextArea: '',
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
                            console.log(data);
                            self.form.id = id;
                            self.form.title = data.title;
                            self.form.description = data.description;
                            self.form.url = data.url;
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

            copyImage(image) {
                let self = this;
                self.$refs.imageTextArea.select();
                document.execCommand('copy');
            },

            add_image_to_editor: function(filename) {
                let image = '{image|'+filename+'|50|50|image}';
                console.log(image);
                this.imageTextArea = image;
                console.log('resim seçildi');
            }
        }
    }
</script>
