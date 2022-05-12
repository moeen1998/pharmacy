<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add User Form</span>
            <router-link :to="{ name: 'Users' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="user.name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="user.phone" type="text" class="form-control" name="phone" required autocomplete="phone" autofocus>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Role</label>
                    <div class="col-md-6">
                        <select id="inputGroupSelect01" v-model="user.role" class="form-select" name="role" required autocomplete="phone" autofocus>
                            <option value="normal">Normal User</option>
                            <option value="admin">Admin User</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                    <div class="col-md-6">
                        <input id="email" v-model="user.email" type="email" class="form-control" name="email" required autocomplete="email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                    <div class="col-md-6">
                        <input id="password" v-model="user.password" type="password" class="form-control" name="password" required autocomplete="new-password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" v-model="user.password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="submit" class="btn btn-primary">
                            Save The User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            user:{
                name:'',
                phone:'',
                role:'',
                email:'',
                password:'',
                password_confirmation:''
            },
            users:[],
            send:false
            
        }
    },
    mounted() {
        this.getUsers()
    },
    methods:{
        getUsers(){
// axios.post("https://reqres.in/api/articles", article).then(response => (this.info = response)).catch(error => console.log(error))
            axios.get('http://localhost/NewPh/public/users')
                .then(response => {this.users = response.data;this.filterdusers = response.data})
                .catch(error => console.log(error))
                this.search=""
        },
        submit(e){
            e.preventDefault();
            if(this.user.name && this.user.phone && this.user.role && this.user.email && (this.user.password === this.user.password_confirmation))
                {
                    this.users.every(element => {
                        if(element.name.split(" ").join("").toUpperCase() === this.user.name.split(" ").join("").toUpperCase()){
                            this.send=false
                            return false;
                        }
                        else{
                            this.send=true
                            return true;
                        }
                    })
                    if(this.send){
                        axios.post("http://localhost/NewPh/public/users",this.user)
                        .then(this.$router.push({ name: "PharmacyHome"}) )
                        .catch(error => console.log(error))
                    }
                    else{
                        alert('This User Exists Before')
                    }
                    
                }
        }
    }
}
</script>

<style>

</style>