<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Company Form</span>
            <router-link :to="{ name: 'company' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Company Name</label>
                    <div class="col-md-6">
                        <input id="place" v-model="company.name" type="text" class="form-control" name="place" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Company Phone</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="company.phone" type="text" class="form-control" name="phone" required autocomplete="phone" autofocus>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="submit" class="btn btn-primary">
                            Save Company
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
            company:{
                name:'',
                phone:''
            },
            companies:[],
            send:false
            
        }
    },
   mounted() {
        this.getcompanies()
    },
    methods:{
        getcompanies(){
            axios.get('http://localhost/NewPh/public/companies')
                .then(response => {this.companies = response.data;})
                .catch(error => console.log(error))
                this.search=""
        },
        submit(e){
            e.preventDefault();
            if(this.company.name && this.company.phone)
                {
                    this.companies.every(element => {
                        if(element.name.split(" ").join("").toUpperCase() === this.company.name.split(" ").join("").toUpperCase()){
                            this.send=false
                            return false;
                        }
                        else{
                            this.send=true
                            return true;
                        }
                    })
                    if(this.send){
                        axios.post("http://localhost/NewPh/public/companies",this.company)
                        .then(this.$router.push({ name: "company"}) )
                        .catch(error => console.log(error))
                    }
                    else{
                        alert('This Company Exists Before')
                    }
                    
                }
        }
    }
}
</script>

<style>

</style>