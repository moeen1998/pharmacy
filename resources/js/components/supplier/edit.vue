<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Supplier Form</span>
            <router-link :to="{ name: 'supplier' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="supplier.name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="supplier.phone" type="text" class="form-control" name="phone" required autocomplete="phone" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                        <select id="place_name"  v-model="supplier.company_name" name="place_name"  class="form-select form-control" required> 
                            <option v-for="company in companies" :key="company.id">{{company.name}}</option>
                        </select> 
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="update" class="btn btn-primary">
                            Update The Supplier
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
                supplier: {},
                companies:[],
            }
        },
        mounted() {
            this.edit(this.$route.params.id);
            this.getcompanies()
        },
        methods: {
            getcompanies(){
            axios.get('http://localhost/NewPh/public/companies')
                .then(response => {this.companies = response.data})
                .catch(error => console.log(error))
        },
            edit(id) {
                axios.get(`http://localhost/NewPh/public/suppliers/${id}/edit`)
                .then((res) => {
                    this.supplier = res.data;
                });
            },
            update(e) {
              e.preventDefault();
              axios.put(`http://localhost/NewPh/public/suppliers/${this.supplier.id}`,this.supplier)
                .then((res) => {
                  this.$router.push({ name: 'supplier' });
                }).catch((error)=>{console.log(error)})
            }
        }
}
</script>

<style>

</style>