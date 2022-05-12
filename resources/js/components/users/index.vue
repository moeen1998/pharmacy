<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Users Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search Here By User Name Or Email">
                    <!-- create user link -->
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'UserCreate' }"  class="text-decoration-none text-light">Add User</router-link>
                    </button>
                </form>
            </div>
            <div :class="[users.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(user, index )  in filterdusers" :key="user.id">
                            <td>{{index + 1}}</td>
                            <td>{{user.name}}</td>
                            <td>{{user.phone}}</td>
                            <td>{{user.role}}</td>
                            <td>{{user.email}}</td>
                            <td>
                                <router-link :to="{ name: 'UserEdit' , params: { id: user.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a :class="(current.id === user.id)? 'd-none' :''" @click="del(user.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[users.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            users:[],
            filterdusers:[],
            search:'',
            current:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getUsers()
        this.currentuser()
    },
    methods:{
        getUsers(){
// axios.post("https://reqres.in/api/articles", article).then(response => (this.info = response)).catch(error => console.log(error))
            axios.get('http://localhost/NewPh/public/users')
                .then(response => {this.users = response.data;this.filterdusers = response.data;this.Loding="There Is No Users"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/users/${id}`)
                .then(()=>{
                    this.users = this.users.filter((user)=>{return user.id!= id ?  user : ""})
                    this.filterdusers = this.users
                    })
        },
        currentuser(){
                axios.get('http://localhost/NewPh/public/current')
                .then(response=>{this.current=response.data})
                .catch(erroe=>console.log('logged out'));
            }
    },
    watch: {
        search() {
            if (this.search.length>0) {
                this.filterdusers = this.users.filter((user)=>{return user.name.toUpperCase().match(this.search.toUpperCase()) || user.email.toUpperCase().match(this.search.toUpperCase()) ?  user : ""})
            }
            else{
                this.filterdusers = this.users
            }
        }
    },
}
</script>

<style>
form #search{
    width: 30%;
    padding: 5px ;
    font-size: 1rem;
    font-weight: 400;
    color: #212529;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 0.25rem;
    transition: all 0.15s ease-in-out;
    outline: #ced4da auto 1px;
    
}
form #search:focus-visible{
    outline: rgb(182, 182, 182) auto 1px;
}
form button{
    padding: 4px 20px;
    background-color: #0d6efd;
    border: 1px solid transparent;
    color: #FFF;
    border-radius: 5px;  
    font-weight: 600;
}
</style>