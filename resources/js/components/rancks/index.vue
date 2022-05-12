<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Places Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search Here By Place">
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'placeCreate' }"  class="text-decoration-none text-light">Add Place</router-link>
                    </button>
                </form>
            </div>
            <div :class="[places.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>	
                        <tr v-for="(place, index) in filterdplaces" :key="place.id">
                            <td>{{index + 1}}</td>
                            <td>{{place.place}}</td>
                            <td>
                                <router-link :to="{ name: 'placeEdit' , params: { id: place.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a @click="del(place.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[places.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            places:[],
            filterdplaces:[],
            search:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getplaces()
    },
    methods:{
        getplaces(){
            axios.get('http://localhost/NewPh/public/places')
                .then(response => {this.places = response.data;this.filterdplaces = response.data;this.Loding="There Is No Places"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/places/${id}`)
                .then(()=>{
                    this.places = this.places.filter((place)=>{return place.id!= id ?  place : ""})
                    this.filterdplaces = this.places
                    })
        }
    },
    watch: {
        search() {
            if (this.search.length>0) {
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