class AppStorage{

    storeToken(token){
        localStorage.setItem('token',token);
    }
   
    storeUser(user){
        localStorage.setItem('user',user);
    }

    
    storeUserId(user_id){
        localStorage.setItem('user_id',user_id);
    }
   
    store(token,user,user_id){
        this.storeToken(token)
        this.storeUser(user)
        this.storeUserId(user_id)
     }
   
     clear(){
         localStorage.removeItem('token')
         localStorage.removeItem('user')
         localStorage.removeItem('user_id')
     }
   
     getToken(){
         localStorage.getItem(token);
     }
   
     getUser(){
        localStorage.getItem(user);
    }

    getUserId(){
       localStorage.getItem(user_id);
    }
   
   
   
   }
   
   export default AppStorage = new AppStorage();