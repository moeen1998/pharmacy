<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Drug Form</span>
            <router-link :to="{ name: 'drug' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>
        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="drug.name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
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
                            <option>Tap</option>
                            <option>Box</option>
                        </select>
                        </div>
                </div>
                <div class="row mb-3">
                    <label for="min" class="col-md-4 col-form-label text-md-end">Minimum Qty</label>
                    <div class="col-md-6">
                        <input id="min" v-model="drug.min" type="number" style="width: 79%; display:inline" class="form-control" name="min" autofocus>
                        <select id="place_name"  v-model="miniType" name="place_name" style="width: 20%; display:inline" class="form-select form-control" required> 
                            <option>Tap</option>
                            <option>Box</option>
                        </select>
                        </div>
                </div>
                <div class="row mb-3">
                    <label for="smallprice" class="col-md-4 col-form-label text-md-end">Price</label>
                    <div class="col-md-6">
                        <input id="smallprice" v-model="drug.smallprice" type="number" style="width: 79%; display:inline" class="form-control" name="smallprice" autofocus>
                        <select id="place_name"  v-model="priceType" name="place_name" style="width: 20%; display:inline" class="form-select form-control" required> 
                            <option>Tap</option>
                            <option>Box</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="disc" class="col-md-4 col-form-label text-md-end">Discount</label>
                    <div class="col-md-6">
                        <input id="disc" v-model="drug.disc" type="number" class="form-control" name="disc" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="packet" class="col-md-4 col-form-label text-md-end">Packet</label>
                    <div class="col-md-6">
                        <input id="packet" v-model="drug.packet" type="number" class="form-control" name="packet" required autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="place_name" class="col-md-4 col-form-label text-md-end">Place</label>
                    <div class="col-md-6">
                        <select id="category_name"  v-model="drug.place_name" name="category_name"  class="form-select form-control" required> 
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
                        <button type="submit" @click="update" class="btn btn-primary">
                            Save Place
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            drug:{},
            places:[],
            categories:[],
            pakingType:'Tap',
            priceType:'Tap',
            miniType:'Tap',
        }
    },
    mounted() {
        this.getplaces()
        this.getcategories()
        this.edit(this.$route.params.id);
    },
    methods: {
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
        edit(id) {
            axios.get(`http://localhost/NewPh/public/drugs/${id}/edit`)
            .then((res) => {this.drug = res.data})
            .catch(error=>{console.log(error)})
        },
        update(e) {
            e.preventDefault();
            if(this.drug.name && this.drug.type && this.drug.disc >= 0  && this.drug.avilablesunit && this.drug.smallprice && this.drug.packet && this.drug.place_name && this.drug.category_name && this.pakingType &&this.priceType ){
                if(this.pakingType === 'Box')
                    this.drug.avilablesunit= parseInt(this.drug.avilablesunit) * parseInt(this.drug.packet)
                if(this.priceType === 'Box')
                    this.drug.smallprice = parseInt(this.drug.smallprice) / parseInt(this.drug.packet)
                if(this.miniType === 'Box')
                    this.drug.min = parseInt(this.drug.min) * parseInt(this.drug.packet)
                axios.put(`http://localhost/NewPh/public/drugs/${this.drug.id}`,this.drug)
                    .then((res) => {
                        this.$router.push({ name: 'drug' });
                    }).catch((error)=>{console.log(error)})
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