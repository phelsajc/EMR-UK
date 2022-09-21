<template>
    <div>

    
        <!-- <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-12">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">All Employee</h1>
                        </div>
                        
                        
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div> --><div class="row">
        <router-link to="/add_employee" class="btn btn-primary">Add Employee</router-link>
        <a href="javascript:void(0)" @click="pdf()" class="btn btn-sm btn-danger">PDF</a>
    </div>
<br><br>
<input type="text" v-model="searchTerm" class="form-control" style="width:300px;" placeholder="Search here">
        <div class="row">
            <div class="col-lg-12 mb-4">
              <!-- Simple Tables -->
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
          </div>

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
                employees:[],
                searchTerm:''
            }
        },
        computed:{
            filtersearch(){
                return this.employees.filter(e => {
                  return e.name.match(this.searchTerm)
                })
            }
        },
        methods: {
            allEmployee(){
                axios.get('/api/employee')
                .then(({data}) => (this.employees = data))
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
</style>