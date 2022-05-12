<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Supplier Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search By supplier Name Or Company Name">
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'supplierCreate' }"  class="text-decoration-none text-light">Add Supplier</router-link>
                    </button>
                </form>
            </div>
            <div :class="[suppliers.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>company</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>	
                        <tr v-for="(supplier , index) in filterdsuppliers" :key="supplier.id">
                            <td>{{index + 1}}</td>
                            <td>{{supplier.name}}</td>
                            <td>{{supplier.phone}}</td>
                            <td>{{supplier.company_name}}</td>
                            <td>
                                <router-link :to="{ name: 'supplierEdit' , params: { id: supplier.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a @click="del(supplier.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[suppliers.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            suppliers:[],
            filterdsuppliers:[],
            search:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getsuppliers()
    },
    methods:{
        getsuppliers(){
            axios.get('http://localhost/NewPh/public/suppliers')
                .then(response =>{this.suppliers = response.data;this.filterdsuppliers = response.data;this.Loding="There Is No Suppliers"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/suppliers/${id}`)
                .then(()=>{
                    this.suppliers = this.suppliers.filter((supplier)=>{return supplier.id!= id ?  supplier : ""})
                    this.filterdsuppliers = this.suppliers
                    })
        }
    },
    watch: {
        search() {
            if (this.search.length) {
                this.filterdsuppliers = this.suppliers.filter((supplier)=>{return supplier.name.toUpperCase().match(this.search.toUpperCase()) || supplier.company_name.toUpperCase().match(this.search.toUpperCase())  ?  supplier : ""})
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