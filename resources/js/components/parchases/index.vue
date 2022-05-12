<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Parchases Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search Here By Date Or Supplier Name">
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'parchaseCreate' }"  class="text-decoration-none text-light">Add Pill</router-link>
                    </button>
                </form>
            </div>
            <div :class="[parchases.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier Name</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>		
                        <tr v-for='(parchase, index ) in filterdparchases' :key='parchase.id'>
                            <td>{{index + 1 }}</td>
                            <td>{{parchase.supplier_name}}</td>
                            <td>{{parchase.total}}</td>
                            <td>{{parchase.created_at.slice(0,10)}}</td>
                            <td>
                                <router-link :to="{ name: 'parchaseEdit' , params: { id: parchase.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a @click="del(parchase.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[parchases.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            parchases:[],
            filterdparchases:[],
            search:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getparchases()
    },
    methods:{
        getparchases(){
// axios.post("https://reqres.in/api/articles", article).then(response => (this.info = response)).catch(error => console.log(error))
            axios.get('http://localhost/NewPh/public/parchases')
                .then(response => {this.parchases = response.data;this.filterdparchases = response.data;this.Loding="There Is No Parchases"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/parchases/${id}`)
                .then(()=>{
                    this.parchases = this.parchases.filter((parchase)=>{return parchase.id!= id ?  parchase : ""})
                    this.filterdparchases = this.parchases
                    })
        },
    },
    watch: {
        search() {
            if (this.search) {
                this.filterdparchases = this.parchases.filter((parchase)=>{return parchase.supplier_name.toUpperCase().match(this.search.toUpperCase()) || parchase.created_at.toUpperCase().match(this.search.toUpperCase()) ?  parchase : ""})
            }
            else{
                this.filterdparchases = this.parchases
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