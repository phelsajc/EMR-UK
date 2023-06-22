<template>    
    <aside id="sidebar" class="main-sidebar sidebar-dark-primary elevation-4" >
            <router-link to="/all_employee" class="brand-link">
            <img :src="('../../../../public/backend2/uk_logo.jpg')" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">UNAKonsulta</span>           
            </router-link> 
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                    <img :src="('../../../../public/backend2/uk_logo.jpg')" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                    <user-info></user-info>
                    </div>
                </div> 
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">              
                    
          <li class="nav-item menu-open">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Patients
                            <i class="right fas fa-angle-left"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <router-link to="/all_employee" class="collapse-item">List</router-link>
                            </a>
                        </li>
                        </ul>
                    </li>

                    <li class="nav-item ">
                        <a href="#" class="nav-link"  id="usermenu">
                        <i class="far fa-circle nav-icon"></i>
                        <router-link to="/userslist" class="collapse-item">Users</router-link>
                        </a>
                    </li>
                
                    <li class="nav-item">
                        <router-link to="/logout" class="nav-link">
                        <p>
                            Logout
                        </p>
                        </router-link>
                    </li>
                    
                    <li class="nav-item">
            <a class="nav-link col-sm-6  col-sm-offset-6" data-widget="pushmenu" href="#" role="button">
              <i class="fas fa-arrow-left"></i>
            </a>
                    </li>
                    </ul>
                </nav>
            </div>  
    </aside>
</template>
<script>
    export default {
      data() {
        return {}
      },
    }
</script>