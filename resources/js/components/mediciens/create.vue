<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Drug Form</span>
            <router-link :to="{ name: 'drug' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
        </div>
        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="drug.name" type="text" class="form-control" name="name" required autocomplete="Drug_name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end">Type</label>
                    <div class="col-md-6">
                        <select id="type"  v-model="drug.type" name="type"  class="form-select form-control" required> 
                            <option>Cab</option>
                            <option>Syrp</option>
                            <option>Amp</option>
                            <option>Drop</option>
                            <option>Subb</option>
                            <option>Fawar</option>
                            <option>other</option>
                        </select> 
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="avilablesunit" class="col-md-4 col-form-label text-md-end">Avilable</label>
                    <div class="col-md-6">
                        <input id="avilablesunit" v-model="drug.avilablesunit" type="number" style="width: 79%; display:inline" class="form-control" name="avilablesunit" autofocus>
                        <select id="place_name"  v-model="pakingType" name="place_name" style="width: 20%; display:inline" class="form-select form-control" required> 
                            <option>Box</option>
                            <option v-if="drug.type != 'Syrp' ">Tap</option>
                        </select>
                        </div>
                </div>
                <div class="row mb-3">
                    <label for="min" class="col-md-4 col-form-label text-md-end">Minimum Qty</label>
                    <div class="col-md-6">
                        <input id="min" v-model="drug.min" type="number" style="width: 79%; display:inline" class="form-control" name="min" autofocus>
                        <select id="place_name"  v-model="miniType" name="place_name" style="width: 20%; display:inline" class="form-select form-control" required> 
                            <option>Box</option>
                            <option v-if="drug.type != 'Syrp' ">Tap</option>
                        </select>
                        </div>
                </div>
                <div class="row mb-3">
                    <label for="smallprice" class="col-md-4 col-form-label text-md-end">Price</label>
                    <div class="col-md-6">
                        <input id="smallprice" v-model="drug.smallprice" type="number" style="width: 79%; display:inline" class="form-control" name="smallprice" autofocus>
                        <select id="place_name"  v-model="priceType" name="place_name" style="width: 20%; display:inline" class="form-select form-control" required> 
                            <option>Box</option>
                            <option v-if="drug.type != 'Syrp' ">Tap</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="disc" class="col-md-4 col-form-label text-md-end">Discount</label>
                    <div class="col-md-6">
                        <input id="disc" v-model="drug.disc" type="number" class="form-control" name="disc" required autofocus>
                    </div>
                </div>
                <div class="row mb-3" v-if="drug.type != 'Syrp' ">
                    <label for="packet" class="col-md-4 col-form-label text-md-end">Packet</label>
                    <div class="col-md-6">
                        <input  id="packet" v-model="drug.packet " type="number" class="form-control" name="packet" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="place_name" class="col-md-4 col-form-label text-md-end">Place</label>
                    <div class="col-md-6">
                        <select id="place_name"  v-model="drug.place_name" name="place_name"  class="form-select form-control" required> 
                            <option v-for="place in places" :key="place.id">{{place.place}}</option>
                        </select> 
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="category_name" class="col-md-4 col-form-label text-md-end">Category</label>
                    <div class="col-md-6">
                        <select id="category_name"  v-model="drug.category_name" name="category_name"  class="form-select form-control" required> 
                            <option v-for="category in categories" :key="category.id">{{category.name}}</option>
                        </select> 
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="submit" class="btn btn-primary">
                            Save Drug
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
            drug:{
                name:'',
                type:'',
                disc:'',
                avilablesunit:'',
                smallprice:'',
                packet:'',
                place_name:'',
                category_name:'',
                min:'',
                drugs:[],
                send:false
            },
            places:[],
            categories:[],
            pakingType:'Box',
            priceType:'Box',
            miniType:'Box',
        }
    },
    mounted() {
        this.getplaces()
        this.getcategories()
        this.getdrugs()
    },
    methods:{
        getdrugs(){
            axios.get('http://localhost/NewPh/public/drugs')
                .then(response => {this.drugs = response.data})
                .catch(error => console.log(error))
                this.search=""
        },
        getplaces(){
            axios.get('http://localhost/NewPh/public/places')
                .then(response => {this.places = response.data})
                .catch(error => console.log(error))
        },
        getcategories(){
            axios.get('http://localhost/NewPh/public/categories')
                .then(response => {this.categories = response.data})
                .catch(error => console.log(error))
        },
        submit(e){
            e.preventDefault();
            if(this.drug.type === 'Syrp')
                this.drug.packet=1
            if(this.drug.name && this.drug.type && this.drug.disc && this.drug.avilablesunit && this.drug.smallprice && this.drug.packet && this.drug.place_name && this.drug.category_name && this.pakingType &&this.priceType ){
                if(this.pakingType === 'Box')
                    this.drug.avilablesunit= parseInt(this.drug.avilablesunit) * parseInt(this.drug.packet)
                if(this.priceType === 'Box')
                    this.drug.smallprice = parseInt(this.drug.smallprice) / parseInt(this.drug.packet)
                if(this.miniType === 'Box')
                    this.drug.min = parseInt(this.drug.min) * parseInt(this.drug.packet)
                // if(drug.name)
                this.drugs.every(element => {
                    if(element.name.split(" ").join("").toUpperCase() === this.drug.name.split(" ").join("").toUpperCase() && element.type === this.drug.type){
                        this.send=false
                        return false;
                    }
                    else{
                        this.send=true
                        return true;
                    }
                })
                if(this.send){
                    axios.post("http://localhost/NewPh/public/drugs",this.drug)
                    .then(this.$router.push({ name: "drug"}))
                    .catch(error => console.log(error))
                }
                else{
                    alert('this drug Exists Before')
                }
                
            }
            else{
            alert("the data isnot compleate");
            }
        }
    }
}
</script>

<style>

</style>