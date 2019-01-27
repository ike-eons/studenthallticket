<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Departments Table</h3>

                <div class="card-tools">
                    <!-- Button trigger modal -->
                    <button class="btn btn-success" @click="newModal()">
                        <i class="fas fa-user-plus fa-fw"></i> Add Department
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                 <!-- 
                     * departments table
                    *  display all users
                  -->
                  <tr v-for="department in departments" :key="department.id">
                    <td>{{ department.id }}</td>
                    <td><a href="#" class="nav-link">{{ department.department_code | uppercase}}</a></td>
                    <td>{{ department.department_name | uppercase}}</td>
                    <td>{{ department.created_at |datetime|uppercase}}</td>
                    <td>
                        <!-- Edit User -->
                        <a href="#" @click="editModal(department)">
                            <i class="fa fa-edit text-green"></i>
                        </a> &nbsp;

                        <!-- Delete User -->
                        <a href="#" @click="deleteUser(department.id)">
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
        <div class="modal fade" id="addNewDepartment" tabindex="-1" role="dialog" aria-labelledby="addNewDepartmentLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewDepartmentLabel">Add Department</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewDepartmentLabel">Edit Department Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            <!-- forms -->
            <form @submit.prevent="editmode ? updateDepartment() : createDepartment()" >
                <div class="modal-body">
                    <!-- department code -->
                    <div class="form-group">
                        <input v-model="form.department_code" id="department_code" placeholder="Department Code"
                                type="text" name="department_code"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('deparment_code') }"> 
                        <has-error :form="form" field="department"></has-error>
                    </div>

                    <!-- Department name -->
                    <div class="form-group">
                        <input v-model="form.department_name" id="department_name" placeholder="Department Name"
                                type="text" name="department_name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('department_name') }"> 
                        <has-error :form="form" field="department_name"></has-error>
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
                departments: {}, //user object

                // Create a new form instance
                form: new Form({
                        id: '',
                        department_code: '',
                        department_name: '',
                        })
                    }
                }, // end of data
        methods:{
                newModal(){
                    this.editmode = false;
                    this.form.reset(); //reset filled of form
                     $('#addNewDepartment').modal('show');
                },
                editModal(department){
                    this.editmode = true;
                    this.form.reset(); //reset filled of form
                     $('#addNewDepartment').modal('show');
                     this.form.fill(department);
                },
                createDepartment(){
                   this.$Progress.start();
                    this.form.post('api/department')
                    .then( () => {
                        Fire.$emit('reload');

                        $('#addNewDepartment').modal('hide');

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
                loadDepartments(){
                    axios.get("api/department")
                         .then( 
                            ({data})  => (this.departments = data.data)
                          );
                },
                updateDepartment(){
                    this.$Progress.start();
                    this.form.put('api/department/'+this.form.id)
                        .then( () => {
                            Fire.$emit('reload');
                            //success
                            $('#addNewDepartment').modal('hide');
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
                deleteDelete(id){
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

                                this.form.delete('api/department/'+id)
                                .then(()=>{
                                    swal(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                        );
                                     Fire.$emit('reload');
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
            this.loadDepartments();

            //fire new vue instance to listen for 'searching'
            //send an http request to the server
            Fire.$on('searching',() => {
                let query = this.$parent.search; // query parent(app.js) for 'search'
                axios.get('api/findDepartment?q='+query)
                     .then(data => {
                         this.departments = data.data;
                        })
                     .catch();
                //console.log('searching...');
            });

            Fire.$on('reload',() => {
                this.loadDepartments();
            });
            
            // setInterval(() => {
            //     this.loadUsers();
            // }, 3000);
        }
    }
</script>
