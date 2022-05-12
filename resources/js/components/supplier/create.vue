<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Supplier Form</span>
            <router-link :to="{ name: 'supplier' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="supplier.name" type="text" class="form-control" name="name" required autocomplete="off" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="supplier.phone" type="text" class="form-control" name="phone" required autocomplete="phone" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="company" class="col-md-4 col-form-label text-md-end">company</label>
                    <div class="col-md-6">
                        <select id="company_name"  v-model="supplier.company_name" name="company_name"  class="form-select form-control" required> 
                            <option v-for="company in companies" :key="company.id" :value="company.name">{{company.name}}</option>
                        </select> 
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="submit" class="btn btn-primary">
                            Save The Supplier
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
            companies:[],
            supplier:{
                name:'',
                phone:'',
                company_name:''
            },
            suppliers:[],
            send:false
            
        }
    },
    mounted(){
        this.getcompanies()
        this.getsuppliers()
    },
    methods:{
        getsuppliers(){
            axios.get('http://localhost/NewPh/public/suppliers')
                .then(response => {this.suppliers = response.data})
                .catch(error => console.log(error))
                this.search=""
        },
        getcompanies(){
            axios.get('http://localhost/NewPh/public/companies')
                .then(response => {this.companies = response.data})
                .catch(error => console.log(error))
        },
        submit(e){
            e.preventDefault();
            if(this.supplier.name && this.supplier.phone && this.supplier.company_name)
                {
                    this.suppliers.every(element => {
                        if(element.name.split(" ").join("").toUpperCase() === this.supplier.name.split(" ").join("").toUpperCase()){
                            this.send=false
                            return false;
                        }
                        else{
                            this.send=true
                            return true;
                        }
                    })
                    if(this.send){
                        axios.post("http://localhost/NewPh/public/suppliers",this.supplier)
                        .then(this.$router.push({ name: "supplier"}) )
                        .catch(error => console.log(error))
                    }
                    else{
                        alert('This Supplier Exists Before')
                    }
                    
                }
        }
    }
}
</script>

<style>

</style>