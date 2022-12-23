<template>
    <div class="hold-transition login-page">
        <!-- <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5">
                <div class="card-body p-0">
                    <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Login</h1>
                        </div>
                        <form class="user" @submit.prevent="login">
                            <div class="form-group">                          
                                <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" v-model="form.username">
                                <small class="text-danger" v-if="errors.username">{{ errors.username[0] }}</small>
                            </div>
                            <div class="form-group">                       
                                <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" v-model="form.password">
                                <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small> </div>
                            <div class="form-group">
                            <div class="custom-control custom-checkbox small" style="line-height: 1.5rem;">
                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                <label class="custom-control-label" for="customCheck">Remember
                                Me</label>
                            </div>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <hr>
                        </form>
                        <hr>
                        <div class="text-center">
                            <router-link to="/register" class="font-weight-bold small">Create an Account!</router-link>
                        </div>
                        <div class="text-center">
                            <router-link to="/forget" class="font-weight-bold small">Forgot Password</router-link>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div> -->
        <div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="javascript:void(0);" class="h1"><b>Login</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <!-- <form action="../../index3.html" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form> -->
        <form class="user" @submit.prevent="login">
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" v-model="form.username">
                <small class="text-danger" v-if="errors.username">{{ errors.username[0] }}</small>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>        
            <div class="input-group mb-3">
                <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" v-model="form.password">
                <small class="text-danger" v-if="errors.password">{{ errors.password[0] }}</small>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
            <hr>
        </form>                
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
    </div>
</template>

<style lang="scss" scoped>
    @import "../../../../public/backend2/dist/css/adminlte.min.css";
    /* {{ asset('backend2/dist/css/adminlte.min.css') }} */
</style>    

<script type="text/javascript">

    export default {
        created(){
            if(!User.loggedIn()){
                this.$router.push({name: '/'})
            }
        },

        data() {
            return {
                form: {
                    username: null,
                    password: null,
                },
                errors:{}
            }
        },
        methods: {
            async login() {
                await axios.post('/api/auth/login',this.form)
                    .then(res => {
                    
                    User.responseAfterLogin(res)
                    Toast.fire({
                        icon: 'success',
                        title: 'Signed in successfully1'
                    })
                    //this.$router.push({name: 'home'})
                    
                    this.$router.push({ name: 'all_employee' })
                    //location = "/all_employee"
                })
                .catch(error => this.errors = error.response.data.errors)
                .catch(
                    Toast.fire({
                        icon: 'warning',
                        title: 'User Not Found!'
                    }),

                    console.log(this.errors)
                )
            }
        },
    }
    
</script>

<style>

</style>