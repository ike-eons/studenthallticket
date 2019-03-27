<template>
    <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Students Table</h3>

                <div class="card-tools">
                    <!-- Button trigger modal -->
                    <button class="btn btn-success" @click="newModal()">
                        <i class="fas fa-user-plus fa-fw"></i> Add New Student
                    </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody><tr>
                    <th>Index_no</th>
                    <th>Name</th>
                    <th>Department</th>
                    <th>Session Type</th>
                    <th>Action</th>
                  </tr>
                 <!-- 
                     * students table
                    *  display all students
                  -->
                  <tr v-for="student in students" :key="student.id">
                    <td>
                        <a :href="'/profile/'+student.id" class="nav-link text-info font-weight-bold">
                            {{ student.index_no | uppercase }}
                        </a> 
                        <!-- <router-link to="/profile" class="nav-link text-info font-weight-bold">
                            {{ student.index_no | uppercase }}
                        </router-link> -->
                    </td>
                    <!-- <td>{{ student.firstname|uppercase}} {{student.middlename||" "|uppercase}} {{student.lastname|uppercase}}</td> -->
                    <td>{{getFullName(student) | capitalize}}</td>
                    <td>{{student.department}}</td>
                    <td>{{ student.regular_or_weekend | capitalize }}</td>
                    <td>
                        <!-- Edit Student -->
                        <a href="#" @click="editModal(student)">
                            <i class="fa fa-edit text-green"></i>
                        </a> &nbsp;

                        <!-- Delete Student -->
                        <a href="#" @click="deleteStudent(student.id)">
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
        <div class="modal fade" id="addNewStudent" tabindex="-1" role="dialog" aria-labelledby="addNewStudentLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewStudentLabel">Add New Student</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewStudentLabel">Edit Student Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                
            <!-- forms -->
            <form @submit.prevent="editmode ? updateStudent() : createStudent()" >
                <div class="modal-body">
                    <!-- index no -->
                    <div class="form-group">
                        <input v-model="form.index_no" id="name" placeholder="Index Number"
                                type="text" name="index_no"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('index_no') }"> 
                        <has-error :form="form" field="index_no"></has-error>
                    </div>

                    <!-- Firstname -->
                    <div class="form-group">
                        <input v-model="form.firstname" id="firstname" placeholder="First Name"
                                type="text" name="firstname"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('firstname') }"> 
                        <has-error :form="form" field="firstname"></has-error>
                    </div>
                     <!-- Middlename -->
                    <div class="form-group">
                        <input v-model="form.middlename" id="middlename" placeholder="Middle Name"
                                type="text" name="middlename"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('middlename') }"> 
                        <has-error :form="form" field="middlename"></has-error>
                    </div>
                     <!-- Lastname -->
                    <div class="form-group">
                        <input v-model="form.lastname" id="lastname" placeholder="Last name"
                                type="text" name="lastname"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('lastname') }"> 
                        <has-error :form="form" field="lastname"></has-error>
                    </div>

                    <!-- department -->
                    <div class="form-group">
                        <select v-model="form.department" placeholder="Department" id="department"
                                type="text" name="department"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('department') }"> 
                                <option value="">Select Department</option>
                                <option value="Business Administration">Business Adminstration</option>
                                <option value="Biomedical Engineering">Biomedical Engineering</option>
                                <option value="Computer Science & Engineering">Computer Science & Engineering</option> 
                                <option value="Oil & Gas Engineering">Oil & Gas Engineering</option> 
                                <option value="Electrical & Communication Engineering">Electrical & Communication Engineering</option> 
                        </select>
                        <has-error :form="form" field="department"></has-error>
                    </div>
                    <!-- course -->
                    <div class="form-group">
                        <select v-model="form.course" placeholder="Course" id="course"
                                type="text" name="course"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('course') }"> 
                                <option value="">Select Course</option>
                                <option value="B.A Business Administration">B.A. Business Adminstration</option>
                                <option value="B.E. Biomedical Engineering">B.E. Biomedical Engineering</option>
                                <option value="B.E. Computer Engineering">B.E. Computer Engineering</option>
                                <option value="BSc. Computer Science">BSC. Computer Science</option>  
                                <option value="B.E. Oil & Gas Engineering">B.E. Oil & Gas Engineering</option> 
                                <option value="B.E. Electrical & Communication Engineering">B.E. Electrical & Communication Engineering</option> 
                        </select>
                        <has-error :form="form" field="course"></has-error>
                    </div>
                    <!-- regular or weekend -->
                    <div class="form-group">
                        <select v-model="form.regular_or_weekend" placeholder="Session Type" id="regular_or_weekend"
                                type="text" name="regular_or_weekend"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('regular_or_weekend') }"> 
                                <option value="">Select Session</option>
                                <option value="regular">regular</option>
                                <option value="weekend">weekend</option>
                                </select>
                        <has-error :form="form" field="regular_or_weekend"></has-error>
                    </div>

                    <!-- nationality -->
                    <div class="form-group">
                        <select v-model="form.nationality" placeholder="Session Type" id="nationality"
                                type="text" name="nationality"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('nationality') }"> 
                                <option value="">Select Country</option>
                                <option value="Ghanaian">Ghana</option>
                                <option value="Nigerian">Nigeria</option>
                                </select>
                        <has-error :form="form" field="nationality"></has-error>
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
                students: {}, //student object

                // Create a new form instance
                form: new Form({
                        id: '',
                        index_no:'',
                        firstname: '',
                        middlename: '',
                        lastname: '',
                        department: '',
                        course:'',
                        regular_or_weekend:'',
                        nationality:''
                       })
                    } //end of data()
                },
        methods:{
                    newModal(){
                    this.editmode = false;
                    this.form.reset(); //reset filled of form
                     $('#addNewStudent').modal('show');
                },
                editModal(student){
                    this.editmode = true;
                    this.form.reset(); //reset filled of form
                     $('#addNewStudent').modal('show');
                     this.form.fill(student);
                },
                createStudent(){
                    this.$Progress.start();
                    this.form.post('api/student')

                    .then( () => {
                        Fire.$emit('reload');

                        $('#addNewStudent').modal('hide');

                        toast({
                            type: 'success',
                            title: 'Student Created'
                            });
                            
                        this.$Progress.finish();

                        })
                    .catch( () =>{
                        this.$Progress.fail();
                    })
                },
                loadStudents(){
                    axios.get('api/student')
                        .then(
                            ({data}) => (this.students = data.data)
                        )
                },
                updateStudent(){
                    this.$Progress.start();
                    this.form.put('api/student/'+this.form.id)
                        .then( () => {
                            Fire.$emit('reload');
                            //success
                            $('#addNewStudent').modal('hide');
                            swal(
                                'Updated!',
                                'Student Info has been updated.',
                                'success'
                                )
                            this.$Progress.finish();
                        })
                        .catch(() => {
                            this.$Progress.fail();
                        });
                },
                deleteStudent(id){
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

                            this.form.delete('api/student/'+id)
                            .then(()=>{
                                console.log('deleted');
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
                },
                getFullName(student){
                    return student.firstname + " " + (student.middlename||'') + "  " + student.lastname;
                }
        },
        created(){
            this.loadStudents();

            Fire.$on('reload',()=>{
                this.loadStudents();
            });

            Fire.$on('searching',()=>{
                let query = this.$parent.search; // query parent(app.js) for 'search'
                axios.get('api/findStudent?q='+query)
                     .then(data => {
                         this.students = data.data;
                        })
                     .catch();
            })
        }
    }
</script>
