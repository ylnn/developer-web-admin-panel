<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Variables</div>

                    <div class="card-body">
                        <div class="pb-1">
                            <b-button @click="showFormForNew">Add</b-button>
                        </div>
                        <div class="box" v-show="showingForm">
                            <form action="" class="inline">
                                <div class="row">
                                    <div class="col-md-5 mb-3">
                                        <label for="id">ID</label>
                                        <input type="text" class="form-control" id="id" placeholder="" value="" v-model="inputId" disabled>
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label for="key">Key</label>
                                        <input type="text" class="form-control" id="key" placeholder="" value="" required v-model="inputKey">
                                    </div>
                                    <div class="col-md-5 mb-3">
                                        <label for="value">Value</label>
                                        <input type="text" class="form-control" id="value" placeholder="" value="" required v-model="inputValue">
                                    </div>
                                    <div class="col-md-2 mb-3 d-flex flex-column justify-content-end">
                                        <button class="btn btn" @click="post_form">Save</button>
                                    </div>
                                </div>
                            </form>

                            <b-alert :show="alertCountDown"
                                    dismissible
                                    variant="warning"
                                    @dismissed="alertCountDown=0"
                                    >
                            {{alertMessage}}
                            </b-alert>
                        </div>

                        <table class="table">
                            <thead>
                                <th>Id</th>
                                <th>Key</th>
                                <th>Value</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <tr  v-for="content in contents" v-bind:key="content.id">
                                    <td>{{ content.id }}</td>
                                    <td>{{ content.key }}</td>
                                    <td>{{ content.value }}</td>
                                    <td><button class="btn btn-sm btn-warning" @click="edit(content.id)">Edit</button></td>
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
    export default {
        data: function() {
            return {
                showingForm : false,
                
                alertCountDown : 0,
                alertSeconds : 5,
                alertMessage : 'message',
                
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

            showFormForNew: function() {
                this.create_and_get_id(); 
                this.showingForm = true; 
            },

            showAlert(message) {
                this.alertMessage = message;
                this.alertCountDown = this.alertSeconds
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
                // .then(({data}) => self.inputId = data.id)
                .then(function(response) {
                    self.inputId = response.data.id 
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
                        self.showAlert('Saved.')
                    })
                }
            }
        }
    }
</script>
