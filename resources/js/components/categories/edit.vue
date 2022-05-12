<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Category Form</span>
            <router-link :to="{ name: 'category' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Category Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="category.name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="update" class="btn btn-primary">
                            Update Category
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
            category: {}
        }
    },
    mounted() {
        this.edit(this.$route.params.id);
    },
    methods: {
        edit(id) {
            axios.get(`http://localhost/NewPh/public/categories/${id}/edit`)
            .then((res) => {
                this.category = res.data;
            });
        },
        update(e) {
            e.preventDefault();
            axios.put(`http://localhost/NewPh/public/categories/${this.category.id}`,this.category)
            .then((res) => {
                this.$router.push({ name: 'category' });
                }).catch((error)=>{console.log(error)})
        }
    }
}
</script>

<style>

</style>