<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Table</h3>

                <div class="card-tools">
                    <!-- Button trigger modal -->
                    <button class="btn btn-success" @click="newModal()">
                        <i class="fas fa-user-plus fa-fw"></i> Add New User
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                 <!-- 
                     * users table
                    *  display all users
                  -->
                  <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name | capitalize}}</td>
                    <td>{{ user.email }}</td>
                    <td>{{user.type | capitalize}}</td>
                    <td>{{ user.created_at |datetime }}</td>
                    <td>
                        <!-- Edit User -->
                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit text-green"></i>
                        </a> &nbsp;

                        <!-- Delete User -->
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash text-red"></i>
                        </a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /. row -->

        <!-- Modal -->
        <div class="modal fade" id="addNewUser" tabindex="-1" role="dialog" aria-labelledby="addNewUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewUserLabel">Add New User</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewUserLabel">Edit User Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            <!-- forms -->
            <form @submit.prevent="editmode ? updateUser() : createUser()" >
                <div class="modal-body">
                    <!-- name -->
                    <div class="form-group">
                        <input v-model="form.name" id="name" placeholder="Name"
                                type="text" name="name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('name') }"> 
                        <has-error :form="form" field="name"></has-error>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input v-model="form.email" id="email" placeholder="Email Address"
                                type="text" name="email"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('email') }"> 
                        <has-error :form="form" field="email"></has-error>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <input v-model="form.password" id="password" placeholder="Password"
                                type="text" name="password"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('password') }"> 
                        <has-error :form="form" field="password"></has-error>
                    </div>

                    <!-- type or role -->
                    <div class="form-group">
                        <select v-model="form.type" placeholder="Role" id="type"
                                type="text" name="type"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('type') }"> 
                                <option value="">Select User Role</option>
                                <option value="admin">Admin</option>
                                <option value="Lecturer">Lecturer</option>
                                <option value="Student">Student</option> 
                                <option value="QA">Quality Assurance</option> 
                                <option value="Librarian">Librarian</option> 
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

            </div>
            <!-- ./modal-body -->
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="!editmode" type="submit" class="btn btn-success">Create</button>
                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
            </div>
            <!-- ./footer -->
            </form>
        </div> <!-- ./modal content -->
    </div> <!-- ./modal dialog -->
    </div> <!-- ./end of modal  -->
    </div>
    <!-- /.container -->
</template>

<script>


    import { Form, HasError, AlertError } from 'vform'

    export default {
        
        data () {
            return {
                
                editmode : true, // for edit conditional
                users: {}, //user object

                // Create a new form instance
                form: new Form({
                        id: '',
                        name: '',
                        password: '',
                        email: '',
                        type: '',
                       })
                    }
                }, // end of data
        methods:{
                newModal(){
                    this.editmode = false;
                    this.form.reset(); //reset filled of form
                     $('#addNewUser').modal('show');
                },
                editModal(user){
                    this.editmode = true;
                    this.form.reset(); //reset filled of form
                     $('#addNewUser').modal('show');
                     this.form.fill(user);
                },
                createUser(){
                    this.$Progress.start();
                    this.form.post('api/user')
                    .then( () => {
                        Fire.$emit('afterCreated');

                        $('#addNewUser').modal('hide');

                        toast({
                            type: 'success',
                            title: 'User Created'
                            });
                            
                        this.$Progress.finish();

                        })
                    .catch( () =>{
                        this.$Progress.fail();
                    })
                },
                loadUsers(){
                    axios.get("api/user")
                         .then( 
                            ({data})  => (this.users = data.data)
                          );
                },
                updateUser(){
                    this.$Progress.start();
                    this.form.put('api/user/'+this.form.id)
                        .then( () => {
                            Fire.$emit('afterCreated');
                            //success
                            $('#addNewUser').modal('hide');
                            swal(
                                'Updated!',
                                'User Info has been updated.',
                                'success'
                                )
                            this.$Progress.finish();
                            
                        })
                        .catch(() => {
                            this.$Progress.fail();
                        });
                },
                deleteUser(id){
                    swal({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                        })
                        .then((result) => {

                            // Send AJAX request to the server
                            if (result.value) {

                                this.form.delete('api/user/'+id)
                                .then(()=>{
                                    swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                     Fire.$emit('afterCreated');
                                })
                                .catch(()=>{
                                    swal(
                                        'Failed!',
                                        'There was something wrong.',
                                        'warning'
                                        )
                                });
                                
                            }
 
                      })
                }
                
        },
        created(){
            this.loadUsers();

            //fire new vue instance to listen for 'searching'
            //send an http request to the server
            Fire.$on('searching',() => {
                let query = this.$parent.search; // query parent(app.js) for 'search'
                axios.get('api/findUser?q='+query)
                     .then(data => {
                         this.users = data.data;
                        })
                     .catch();
                //console.log('searching...');
            });

            Fire.$on('afterCreated',() => {
                this.loadUsers();
            });
            
            // setInterval(() => {
            //     this.loadUsers();
            // }, 3000);
        }
    }
</script>
