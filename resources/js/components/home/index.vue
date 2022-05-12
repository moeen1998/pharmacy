<template>
    <div>
        <div class="card mb-4">
            <div class="card-header ">
                <span class="d-block mb-4 mt-2 fw-bold">
                    <!-- <i class="fa-solid fa-house-chimney"></i> -->
                    <i class="fas fa-house-chimney me-1"></i>
                    Home
                </span>
                <br>

                <div class="d-flex justify-content-between">
                    <div style="border-radius:5px;" class="p-3 flex-fill text-center pt-4 me-2 bg-primary text-white">Drugs : {{count['drugs']}}</div>
                    <div style="border-radius:5px;" class="p-3 flex-fill text-center me-2 bg-success text-white">Orders: {{count['orders']}}<br>Totl: {{count['totalorders']}}</div>
                    <div style="border-radius:5px;" class="p-3 flex-fill text-center me-2 bg-info text-dark">Purchases: {{count['parchases']}}<br>Totl: {{count['totalparchases']}}</div>
                    <div style="border-radius:5px;" class="p-3 flex-fill text-center pt-4 bg-danger text-white">Shortage: {{count['short']}}</div>
                </div>
                <br>
            </div>
            <div :class="[drugs.length > 0 ? 'card-body overflow-auto': 'd-none' ]">
                <table class="table table-bordered border-primary text-center caption-top">
                    <caption>List of Shortage Drugs</caption>
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
                        <tr v-for="(drug, index) in count['shortdrugs']" :key="drug.id" :class="[drug.short ? 'bg-dark':'']" style="--bs-bg-opacity: .2;">
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
                                <router-link v-if="current.role === 'admin'" :to="{ name: 'drugEdit' , params: { id: drug.id }}"  class="btn btn-primary text-decoration-none text-light">Edit</router-link>
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
            count:[],
            Loding:"Loading",
            current:''
        }
    },
    mounted() {
        this.getdrugs()
        this.getroot()
        this.currentuser()
    },
    methods:{
        currentuser(){
            axios.get('http://localhost/NewPh/public/current')
            .then(response=>{this.current=response.data})
            .catch(erroe=>console.log('logged out'));
        },
        calc(av,pk){
            return Math.floor(av/pk)
        },
        getdrugs(){
            axios.get('http://localhost/NewPh/public/drugs')
                .then(response => {this.drugs = response.data;this.Loding="There Is No Drugs"})
                .catch(error => console.log(error))
        },
        getroot(){
            axios.get('http://localhost/NewPh/public/root')
                .then(response => {this.count = response.data;this.Loding="There Is No Drugs"})
                .catch(error => console.log(error))
        },
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