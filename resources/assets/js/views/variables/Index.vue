<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Variables</div>

                    <div class="card-body">
                        <div class="pb-1">
                            <button class="btn btn-success" @click="showFormForNew">Add</button>
                        </div>
                        <div>

                            <modal v-if="showingForm" @close="showingForm = false">
                                <h2 slot="header">Variable</h2>
                                <div class="box" slot="body">
                                        <form action="" class="inline">
                                            <div class="row">
                                                <div class="col-md-2 mb-3">
                                                    <label for="id">ID</label>
                                                    <input type="text" class="form-control" id="id" placeholder="" value="" v-model="inputId" disabled>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label for="key">Key</label>
                                                    <input type="text" class="form-control" id="key" placeholder="" value="" required v-model="inputKey" autofocus>
                                                </div>
                                                <div class="col-md-5 mb-3">
                                                    <label for="value">Value</label>
                                                    <input type="text" class="form-control" id="value" placeholder="" value="" required v-model="inputValue">
                                                </div>
                                                <div class="col-md-3 mb-3 d-flex flex-column justify-content-end">
                                                    <button class="btn btn-primary" @click="post_form">Save</button>
                                                </div>
                                            </div>
                                        </form>

                                        <alert v-show="showingAlert"
                                                class="alert alert-warning"
                                                >
                                        {{alertMessage}}
                                        </alert>
                                    </div>
                            </modal>
                        </div>
                        <table class="table">
                            <thead>
                                <th>Id</th>
                                <th>Key</th>
                                <th>Value</th>
                                <th width="150">Action</th>
                            </thead>
                            <tbody>
                                <tr  v-for="content in contents" v-bind:key="content.id">
                                    <td>{{ content.id }}</td>
                                    <td>{{ content.key }}</td>
                                    <td>{{ content.value }}</td>
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
                
                inputId: '',
                inputKey: '',
                inputValue: '',

            }
        },
        created() {
            this.get_all();
            },
        methods: {
            // toggle form
            toggleForm: function () {
                this.showingForm = !this.showingForm
            },

            // show form for new record, before show create and get id;
            showFormForNew: function() {
                this.create_and_get_id(); 
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
                axios.get('/api/manage/variables/all')
                      .then(({data}) => self.contents  = data.data);
            },

            // CREATE - create and get created id
            create_and_get_id: function () {
                let self = this;
                axios.post('/api/manage/variables/create')
                .then(function(response) {
                    self.inputId = response.data.id;
                })
            },

            //EDIT - get details and fill form for edit content 
            edit: function(id) {
                let self = this;
                axios.get(`/api/manage/variables/edit/${id}`)
                      .then(function (response) {
                          console.log(response.data.data);
                          if(self.showingForm == false) {
                              self.toggleForm();
                              self.inputId = id;
                              self.inputKey = response.data.data.key;
                              self.inputValue = response.data.data.value;
                          }
                      });
            },

            // SAVE - save or update content with id
            post_form: function() {
                let self = this;

                if(self.inputId !== "" && self.inputKey !== "" && self.inputValue !== ""){
                    axios.post('/api/manage/variables/save/' + self.inputId, {
                        id: self.inputId,
                        key: self.inputKey,
                        value: self.inputValue
                    })
                    .then(function (response) {
                        self.get_all();
                        self.showAlert('Saved.')
                        setTimeout(() => {
                            self.clear_form();
                            self.toggleForm();
                            
                        }, 1000);
                    })
                }
            },

            remove: function(id) {
                let self = this;
                axios.delete(`/api/manage/variables/delete/${id}`)
                      .then(function (response) {
                          self.get_all();
                      });
            },

            clear_form: function() {
                this.inputId = "";
                this.inputKey = "";
                this.inputValue = "";
            }
        }
    }
</script>
