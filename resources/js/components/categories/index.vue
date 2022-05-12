<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Categories Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search Here By Category Name">
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'categoryCreate' }"  class="text-decoration-none text-light">Add Category</router-link>
                    </button>
                </form>
            </div>
            <div :class="[categories.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>	
                        <tr v-for="(category, index) in filterdcategories" :key="category.id">
                            <td>{{index + 1}}</td>
                            <td>{{category.name}}</td>
                            <td>
                                <router-link :to="{ name: 'categoryEdit' , params: { id: category.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a @click="del(category.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[categories.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            categories:[],
            filterdcategories:[],
            search:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getcategories()
    },
    methods:{
        getcategories(){
            axios.get('http://localhost/NewPh/public/categories')
                .then(response => {this.categories = response.data;this.filterdcategories = response.data;this.Loding="There Is No categories"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/categories/${id}`)
                .then(()=>{
                    this.categories = this.categories.filter((category)=>{return category.id!= id ?  category : ""})
                    this.filterdcategories = this.categories
                    })
        }
    },
    watch: {
        search() {
            if (this.search) {
                this.filterdsuppliers = this.suppliers.filter((supplier)=>{return supplier.name.toUpperCase().match(this.search.toUpperCase())  ?  supplier : ""})
            }
            else{
                this.filterdsuppliers = this.suppliers
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