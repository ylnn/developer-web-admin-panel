<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">Articles</div>

                    <div class="card-body">
                        <div class="pb-1">
                            <button class="btn btn-success" @click="showFormForNew">Add</button>
                        </div>
                        <table class="table">
                            <thead>
                                <th>Id</th>
                                <th>Title</th>
                                <th width="150">Action</th>
                            </thead>
                            <tbody>
                                <tr  v-for="content in contents" v-bind:key="content.id">
                                    <td>{{ content.id }}</td>
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

            }
        },
        created() {
            this.get_all();
        },

        methods: {

            // show form for new record, before show create and get id;
            showFormForNew: function() {
                let self = this;
                self.$router.push({ name: 'articles_detail', params: { id: 0 }});
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
                axios.get('/api/manage/articles/all')
                      .then(({data}) => self.contents  = data.data);
            },


            //Redirect to edit page
            edit: function(id) {
                let self = this;
                self.$router.push({ name: 'articles_detail', params: { id: id }});
            },

            remove: function(id) {
                let self = this;
                axios.delete(`/api/manage/articles/delete/${id}`)
                      .then(function (response) {
                          self.get_all();
                      });
            },


        }
    }
</script>
