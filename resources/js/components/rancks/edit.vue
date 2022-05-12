<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Place Form</span>
            <router-link :to="{ name: 'place' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="place" class="col-md-4 col-form-label text-md-end">Place</label>
                    <div class="col-md-6">
                        <input id="place" v-model="place.place" type="text" class="form-control" name="place" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="update" class="btn btn-primary">
                            Update Place
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
            place: {}
        }
    },
    mounted() {
        this.edit(this.$route.params.id);
    },
    methods: {
        edit(id) {
            axios.get(`http://localhost/NewPh/public/places/${id}/edit`)
            .then((res) => {
                this.place = res.data;
            });
        },
        update(e) {
            e.preventDefault();
            axios.put(`http://localhost/NewPh/public/places/${this.place.id}`,this.place)
            .then((res) => {
                this.$router.push({ name: 'place' });
                }).catch((error)=>{console.log(error)})
        }
    }
}
</script>

<style>

</style>