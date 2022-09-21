
let login = require('./components/auth/login.vue').default;
let register = require('./components/auth/register.vue').default
let forget = require('./components/auth/forget.vue').default
let logout = require('./components/auth/logout.vue').default

//End Aithetication
let home = require('./components/home.vue').default

//Employee Component
let storeEmployee = require('./components/employee/create.vue').default
let all_employee = require('./components/employee/index.vue').default
let editEmployee = require('./components/employee/edit.vue').default

/*
    path, component & name should be the same inorder to work
*/

export const routes = [
    { path: '/', component: login, name: '/' },
    { path: '/register', component: register, name: 'register' },
    { path: '/forget', component: forget, name: 'logout' },
    { path: '/logout', component: logout, name: 'forget' },
    { path: '/home', component: home, name: 'home' },

    //employee routes
    { path: '/add_employee', component: storeEmployee, name: 'storeEmployee' },
    { path: '/all_employee', component: all_employee, name: 'all_employee' },
    { path: '/edit-employee/:id', component: editEmployee, name: 'edit-employee' },
]


