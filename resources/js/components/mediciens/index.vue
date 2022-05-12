<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <i class="fas fa-table me-1"></i>
                    Drugs Table
                </span>
                <form class="d-none d-md-inline-block w-100 py-2 align-center" action="#">
                    <input type="text" id="search" v-model="search" placeholder="Search  By Drug Name Or Category Name" autocomplete="off">
                    <button class="btn-success float-end  d-inline-block ">
                        <router-link :to="{ name: 'drugCreate' }"  class="text-decoration-none text-light">Add Drug</router-link>
                    </button>
                </form>
            </div>
            <div :class="[drugs.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>type</th>
                            <th colspan="2">Avilable</th>
                            <th>smallprice</th>
                            <th>Discount</th>
                            <th>packet</th>
                            <th>Place</th>
                            <th>category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>								
                        <tr v-for="(drug, index) in filterddrugs" :key="drug.id" :class="[drug.short ? 'bg-dark':'']" style="--bs-bg-opacity: .2;">
                            <td>{{index + 1}}</td>
                            <td>{{drug.name}}</td>
                            <td>{{drug.type}}</td>
                            <td v-if="drug.type != 'Syrp'">{{calc(drug.avilablesunit , drug.packet )}} </td>
                            <td v-else colspan="2">{{calc(drug.avilablesunit , drug.packet )}} </td>
                            <td v-if="drug.type !='Syrp' ">{{drug.avilablesunit % drug.packet }} </td>
                            <td>{{drug.smallprice}}</td>
                            <td>{{drug.disc}}  %</td>
                            <td v-if="drug.type === 'Syrp' ">-------</td>
                            <td v-else>{{drug.packet}}</td>
                            <td>{{drug.place_name}}</td>
                            <td>{{drug.category_name}}</td>
                            <td>
                                <router-link :to="{ name: 'parchaseCreate' , params: { id: drug.id }}"  class="btn btn-success text-decoration-none text-light"><i class="fa-solid fa-plus"></i> Parchase</router-link>
                                <router-link :to="{ name: 'drugEdit' , params: { id: drug.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
                                <a @click="del(drug.id)" class="btn btn-danger text-decoration-none text-light">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div :class="[drugs.length === 0 ? 'card-body text-center': 'd-none' ]">{{Loding}}</div>
        </div>

    </div>
</template>

<script>
export default {
    data(){
        return{
            drugs:[],
            filterddrugs:[],
            search:'',
            Loding:"Loading"
        }
    },
    mounted() {
        this.getdrugs()
    },
    methods:{
        calc(av,pk){
            return Math.floor(av/pk)
        },
        getdrugs(){
            axios.get('http://localhost/NewPh/public/drugs')
                .then(response => {this.drugs = response.data;this.filterddrugs = response.data;this.Loding="There Is No Drugs"})
                .catch(error => console.log(error))
                this.search=""
        },
        del(id){
            axios.delete(`http://localhost/NewPh/public/drugs/${id}`)
                .then(()=>{
                    this.drugs = this.drugs.filter((drug)=>{return drug.id!= id ?  drug : ""})
                    this.filterddrugs = this.drugs
                    })
        }
    },
    watch: {
        search() {
            if (this.search) {
                this.filterddrugs = this.drugs.filter((drug)=>{return drug.name.toUpperCase().match(this.search.toUpperCase()) || drug.category_name.toUpperCase().match(this.search.toUpperCase())  ?   drug : ""})
            }
            else{
                this.filterddrugs = this.drugs
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