<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Company Form</span>
            <router-link :to="{ name: 'company' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="place" class="col-md-4 col-form-label text-md-end">Company Name</label>
                    <div class="col-md-6">
                        <input id="place" v-model="company.name" type="text" class="form-control" name="place" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="place" class="col-md-4 col-form-label text-md-end">Company Phone</label>
                    <div class="col-md-6">
                        <input id="place" v-model="company.phone" type="text" class="form-control" name="place" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="update" class="btn btn-primary">
                            Update Company
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
            company: {}
        }
    },
    mounted() {
        this.edit(this.$route.params.id);
    },
    methods: {
        edit(id) {
            axios.get(`http://localhost/NewPh/public/companies/${id}/edit`)
            .then((res) => {
                this.company = res.data;
            });
        },
        update(e) {
            e.preventDefault();
            axios.put(`http://localhost/NewPh/public/companies/${this.company.id}`,this.company)
            .then((res) => {
                this.$router.push({ name: 'company' });
                }).catch((error)=>{console.log(error)})
        }
    }
}
</script>

<style>

</style>