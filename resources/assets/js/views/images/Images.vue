<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Images</div>

                    <div class="card-body">
                        <div class="pb-1 d-flex columns" style="height: 60px;">
                            <div>
                                <button class="btn btn-success" @click="showFormForNew">Add</button>
                            </div>
                            <div class="pl-3">
                                <div v-show="showingAlert"
                                        class="alert alert alert-warning"
                                        >
                                {{alertMessage}}
                                </div>
                            </div>
                        </div>
                        <div>

                            <modal v-if="showingForm" @close="showingForm = false">
                                <h2 slot="header">Image</h2>
                                <div class="box" slot="body">
                                    <div class="col-md-12 mb-3">
                                        <label for="title">Upload Image</label>
                                        <input type="file" class="form-control" ref="file" required v-on:change="newFile" accept="image/*">
                                    </div>
<!--                                                 <div class="col-md-3 mb-3 d-flex flex-column justify-content-end">
                                                    <button class="btn btn-primary" @click="post_form">Upload</button>
                                                </div> -->

                                    
                                </div>
                            </modal>

                            
                        </div>
                        <table class="table">
                            <thead>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr  v-for="file in remotePhotos" v-bind:key="file.id">
                                    <td> <img :src="'/image/50/50/'+ file.filename" alt=""> </td>
                                    <td>{{ file.filename }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger" @click="remove(file.id)">Delete</button> 
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Modal from './../../components/Modal';

    export default {
        components: {
            modal: Modal
        },
        data: function() {
            return {
                showingForm : false,
                
                showingAlert: false,
                alertMessage : 'message',
                alertMessageStatus : 'warning',
                
                remotePhotos: [],
                uploadPhotos: []
            }
        },
        created() {
            this.get_all();
        },

        methods: {

            // toggle form
            toggleForm: function () {
                this.showingForm = !this.showingForm;
            },

            // show form for new record, before show create and get id;
            showFormForNew: function() {
                this.showingForm = true; 
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

            // GET - contents
            get_all: function() {
                let self = this;
                axios.get('/api/manage/images/all')
                      .then(({data}) => self.remotePhotos  = data.data);
            },

            // SAVE - save or update content with id
            post_form: function() {
                // console.log(this.uploadPhotos);
                let self = this;

                for (let file of this.uploadPhotos){

                    let data = new FormData();
                    data.set('file', file);

                    axios.post('/api/manage/images/save', data)
                        .then(function(response){
                            console.log('upload success');
                            self.get_all();
                            self.showAlert('Uploaded');
                            self.clear_form();
                            self.showingForm = false;
                        })
                        .catch(
                        function(reason) {
                            self.showAlert('Upload ERROR');
                            console.log('Handle rejected promise ('+reason+') here.');
                            self.clear_form();
                            self.showingForm = false;
                        });
                }

            },

            remove: function(id) {
                let self = this;
                axios.delete(`/api/manage/images/delete/${id}`)
                      .then(function (response) {
                          self.get_all();
                          self.showAlert('Deleted.', 'success');
                      });
            },

            clear_form: function() {
                this.uploadPhotos = [];
            },
            newFile(event) {
                var files = event.target.files;
                if (files.length) this.uploadPhotos = files;
                console.log('added');
                this.post_form();
            },
        }
    }
</script>
