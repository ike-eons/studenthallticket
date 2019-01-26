<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Subjects Table</h3>

                <div class="card-tools">
                    <!-- Button trigger modal -->
                    <button class="btn btn-success" @click="newModal()">
                        <i class="fas fa-user-plus fa-fw"></i> Add New Subject
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>#ID</th>
                    <th>Subject Code</th>
                    <th>Subject Name</th>
                    <th>Credit Hours</th>
                    <th>Created_at</th>
                    <th>Action</th>
                  </tr>
                 <!-- 
                     * users table
                    *  display all users
                  -->
                   <tr v-for="subject in subjects" :key="subject.id">
                    <td>{{ subject.id }}</td>
                    <td>{{ subject.subject_code|uppercase }}</td>
                    <td>{{ subject.subject_name }}</td>
                    <td>{{ subject.credit_hours }}</td>
                    <td>{{ subject.created_at |datetime }}</td>
                    <td>
                        <!-- Edit Student -->
                        <a href="#" @click="editModal(subject)">
                            <i class="fa fa-edit text-green"></i>
                        </a> &nbsp;

                        <!-- Delete Student -->
                        <a href="#" @click="deleteSubject(subject.id)">
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
        <div class="modal fade" id="addNewSubject" tabindex="-1" role="dialog" aria-labelledby="addNewSubjectLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewSubjectLabel">Add New Subject</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewSubjectLabel">Edit Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            <!-- subject forms -->
            <!-- <form @submit.prevent="editmode ? updateSubject() : createSubject()" > -->
            <form @submit.prevent="editmode ? updateSubject() : createSubject()" >
                <div class="modal-body">

                    <!-- subject code -->
                    <div class="form-group">
                        <input v-model="form.subject_code" id="subject_code" placeholder="Subject Code"
                                type="text" name="subject_code"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('subject_code') }"> 
                        <has-error :form="form" field="subject_code"></has-error>
                    </div>

                    <!--subject name -->
                    <div class="form-group">
                        <input v-model="form.subject_name" id="subject_name" placeholder="Subject Name"
                                type="text" name="subject_name"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('subject_name') }"> 
                        <has-error :form="form" field="subject_name"></has-error>
                    </div>

                    <!-- credit hours -->
                    <div class="form-group">
                        <select v-model="form.credit_hours" placeholder="Credit Hours" id="credit_hours"
                                type="number" name="credit_hours"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('credit_hours') }"> 
                                <option value="">Select Credit Hours</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option> 
                                <option value="4">4</option> 
                                <option value="6">6</option> 
                        </select>
                        <has-error :form="form" field="credit_hours"></has-error>
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
                
                editmode : false, // for edit conditional
                subjects: {}, //subject object

                // Create a new form instance
                form: new Form({
                        id: '',
                        subject_code: '',
                        subject_name: '',
                        credit_hours: '',
                       })
                    }
                }, // end of data
        methods:{
            newModal(){
                    this.editmode = false;
                    this.form.reset(); //reset filled of form
                     $('#addNewSubject').modal('show');
            },
            editModal(subject){
                this.editmode = true;
                this.form.reset();
                $('#addNewSubject').modal('show');
                this.form.fill(subject);
            },
            createSubject(){
                this.$Progress.start();
                this.form.post('api/subject')
                    .then( () => {
                        Fire.$emit('reload');

                        $('#addNewSubject').modal('hide');

                        toast({
                            type: 'success',
                            title: 'Subject Created'
                        });
                        this.$Progress.finish();
                    })
                    .catch( () => {
                        this.$Progress.fail();
                    });
            },
            loadSubjects(){
                    axios.get('api/subject')
                        .then(
                            ({data}) => (this.subjects = data.data)
                        )
                    
                },
            updateSubject(){
                    this.$Progress.start();
                    this.form.put('api/subject/'+this.form.id)
                        .then( () => {
                            Fire.$emit('reload');
                            //success
                            $('#addNewSubject').modal('hide');
                            swal(
                                'Updated!',
                                'Subject Info has been updated.',
                                'success'
                                )
                            this.$Progress.finish();
                            
                        })
                        .catch(() => {
                            this.$Progress.fail();
                        });
                },
            deleteSubject(id){
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

                            this.form.delete('api/subject/'+id)
                            .then(()=>{
                                //console.log('deleted');
                                // swal(
                                //     'Deleted!',
                                //     'Your file has been deleted.',
                                //     'success'
                                //     );
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
        created(){  //mounted() can also be used
            this.loadSubjects();

            Fire.$on('reload',() => {
                this.loadSubjects();
            });

            //fire new vue instance to listen for 'searching'
            //send an http request to the server
            Fire.$on('searching',() => {
                let query = this.$parent.search; // query parent(app.js) for 'search'
                axios.get('api/findSubject?q='+query)
                     .then(data => {
                         this.subjects = data.data;
                        })
                     .catch();
                //console.log('searching...');
            });
        }
    }
</script>
