<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Portfolios</div>

                    <div class="card-body">
                        <div class="pb-1">
                            <button class="btn btn-success" @click="showFormForNew">Add</button>
                        </div>
                        <div>

                            <modal v-if="showingForm" @close="showingForm = false">
                                <h2 slot="header">Portfolio</h2>
                                <div class="box" slot="body">
                                        <form action="" class="inline">
                                            <div class="row">
                                                <div class="col-md-2 mb-3">
                                                    <label for="id">ID</label>
                                                    <input type="text" class="form-control" id="id" placeholder="" value="" v-model="form.id" disabled>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" ref="title" id="title" placeholder="" value="" required v-model="form.title" autofocus>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <label for="description">Description</label>
                                                    <input type="text" class="form-control" id="description" placeholder="" description="" required v-model="form.description">
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
                            </modal>
                        </div>
                        <table class="table">
                            <thead>
                                <!-- <th>Id</th> -->
                                <th>Title</th>
                                <th width="150">Action</th>
                            </thead>
                            <tbody>
                                <tr  v-for="content in contents" v-bind:key="content.id">
                                    <!-- <td>{{ content.id }}</td> -->
                                    <td>{{ content.title }}</td>
                                    <td width="150">
                                        <button class="btn btn-sm btn-warning" @click="edit(content.id)">Edit</button> 
                                        <button class="btn btn-sm btn-danger" @click="remove(content.id)">Delete</button> 
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
                
                contents : [],
                
                form : {
                    id: '',
                    title: '',
                    description: '',
                    url: ''
                }
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

            // GET - contents
            get_all: function() {
                let self = this;
                axios.get('/api/manage/portfolios/all')
                      .then(({data}) => self.contents  = data.data);
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
                          console.log(response.data.data);
                          if(self.showingForm == false) {
                              self.toggleForm();
                              let data = response.data.data;
                              self.form.id = id;
                              self.form.title = data.key;
                              self.form.description = data.description;
                              self.form.url = data.url;
                          }
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
                        self.get_all();
                        self.showAlert('Saved.', 'success')
                        setTimeout(() => {
                            self.clear_form();
                            self.toggleForm();
                            
                        }, 1000);
                    })
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
            }
        }
    }
</script>
