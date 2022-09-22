<template>
    <div>
        <!-- <div class="row">
            <router-link to="/add_employee" class="btn btn-primary">Add Employee</router-link>
            <a href="javascript:void(0)" @click="pdf()" class="btn btn-sm btn-danger">PDF</a>
        </div>
        <br><br>
        <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here">
        <div class="row">
            <div class="col-lg-12 mb-4">
              <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employee List</h6>
                </div>
                <div class="table-responsive">
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="e in filtersearch"  :key="e.id">
                        <td><a href="#">{{e.name}}</a></td>
                        <td><img :src="e.photo" alt="" class="em_photo"></td>
                        <td>{{e.phone}}</td>
                        <td><span class="badge badge-success">{{e.salary}}</span></td>
                        <td><a href="#" class="btn btn-sm btn-primary">{{ formatDate(e.joined_date) }}</a></td>
                        <td>
                            <router-link :to="{name: 'edit-employee',params:{id:e.id}}" class="btn btn-sm btn-warning">Edit</router-link >
                            <a href="javascript:void(0)" @click="deleteRecord(e.id)" class="btn btn-sm btn-danger">Delete</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="card-footer"></div>
              </div>
            </div>
        </div> -->

        
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employee List</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">&nbsp;</h3>                
                <router-link to="/add_employee" class="btn btn-primary btn-sm">Add Employee</router-link>
                <a href="javascript:void(0)" @click="pdf()" class="btn btn-sm btn-danger btn-sm">PDF</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here"> -->
                <input type="text" v-model="form.searchTerm2" @change="filterEmployee()" class="form-control to-right" style="width:300px;" placeholder="Search here"> <br><br>
                <table id="myTable" class="table table-bordered table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th>Name</th>
                        <th>Photo</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Date Joined</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="e in filtersearch"  :key="e.id">
                        <td><a href="#">{{e.PatientName}}</a></td>
                        <td>{{e.HospitalNo}}</td>
                        <td>{{e.PK_psPatRegisters}}</td>
                        <td><span class="badge badge-success">{{e.registrystatus}}</span></td>
                        <td>{{e.gender}}</td>
                        <td>
                           <!--  <router-link :to="{name: 'edit-employee',params:{id:e.id}}" class="btn btn-sm btn-warning">Edit</router-link >
                            <a href="javascript:void(0)" @click="deleteRecord(e.id)" class="btn btn-sm btn-danger">Delete</a> -->
                        </td>
                      </tr>
                    </tbody>
                </table>
                <br>
                      <nav aria-label="Page navigation example" class="to-right">
                        <ul class="pagination">
                          <li class="page-item" v-for="(e, index) in this.countRecords" ><a class="page-link" @click="getPageNo(index+1)" href="#">{{index+1}}</a></li>
                        </ul>
                      </nav>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    </div>
</template>

<script type="text/javascript">

    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
        }, 
        data(){
            
            return {
                form: {
                  searchTerm2: null,
                  start: 0
                },
                employees:[],
                searchTerm:'',
                countRecords: 0,
            }
        },
        computed:{
            filtersearch(){
                return this.employees.filter(e => {
                  return e.PatientName.match(this.searchTerm)
                })
            }
        },
        methods: {
            allEmployee(){
                //axios.get('/api/employee')
                axios.get('/api/patientEmployee')
                .then(({data}) => (this.employees = data[0].data ,this.countRecords =data[0].count ))
                .catch()
            },
            pdf(){
                /* axios.get('/pdf')
                .then(({data}) => (
                    console.log(data)
                ))
                .catch() */
                window.open("/api/pdf", '_blank');
            },
            formatDate(date) {
                const options = { year: 'numeric', month: 'long', day: 'numeric' }
                return new Date(date).toLocaleDateString('en', options)
            },
            deleteRecord(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/employee/'+id)
                        .then(() => {
                            this.employees = this.employees.filter(e => {
                                return e.id != id
                            })
                        })
                        .catch(() =>{
                            //this.$router.push({name: 'all_employee'})
                            this.$router.push("/all_employee").catch(()=>{});
                        })

                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        )
                    }
                })
            },
            filterEmployee(){                              
                this.employees = []
                this.countRecords = null
              this.form.start = 0
                //axios.post('/api/filterEmployee',this.form)
                axios.post('/api/patientEmployee',this.form)
                
                .then(res => {
                  this.employees = res.data[0].data
                  this.countRecords =res.data[0].count 
                  console.log(res.data.data)
                })
                .catch(error => this.errors = error.response.data.errors)
            },
            getPageNo(id){
              this.form.start = (id-1) * 10
              //alert(a)
              /* this.employees = []
              this.countRecords = null */
              //axios.post('/api/filterEmployee',this.form)
              axios.post('/api/patientEmployee',this.form)
                .then(res => {
                  this.employees = res.data[0].data
                  this.countRecords =res.data[0].count 
                  console.log(res.data.data)
              })
              .catch(error => this.errors = error.response.data.errors)
            }
        },
        created(){
            this.allEmployee();
        }
    }
    
</script>

<style>
    .em_photo{
        height: 40px;
        width: 40px;
    }

    .to-right{
      float: right;
    }
</style>