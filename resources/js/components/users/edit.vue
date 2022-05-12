<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit User Form</span>
            <router-link :to="{ name: 'Users' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>
                    <div class="col-md-6">
                        <input id="name" v-model="user.name" type="text" class="form-control" name="name" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">Phone</label>
                    <div class="col-md-6">
                        <input id="phone" v-model="user.phone" type="text" class="form-control" name="phone" required autocomplete="phone" autofocus>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="role" class="col-md-4 col-form-label text-md-end">Role</label>
                    <div class="col-md-6">
                        <select id="inputGroupSelect01" v-model="user.role" class="form-select" name="role" required autocomplete="phone" autofocus>
                            <option value="normal">Normal User</option>
                            <option value="admin">Admin User</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                    <div class="col-md-6">
                        <input id="email" v-model="user.email" type="email" class="form-control" name="email" required autocomplete="email">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                    <div class="col-md-6">
                        <input id="password" v-model="user.password" type="password" class="form-control" name="password">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirm Password</label>
                    <div class="col-md-6">
                        <input id="password-confirm" v-model="user.password_confirmation" type="password" class="form-control" name="password_confirmation">
                    </div>
                </div>

                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="update" class="btn btn-primary">
                            Update The User
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
                user: {}
            }
        },
        mounted() {
            this.edit(this.$route.params.id);
        },
        methods: {
            edit(id) {
                axios.get(`http://localhost/NewPh/public/users/${id}/edit`)
                .then((res) => {
                    this.user = res.data;
                });
            },
            update(e) {
                e.preventDefault();
                axios.put(`http://localhost/NewPh/public/users/${this.user.id}`,this.user)
                .then((res) => {
                    this.$router.push({ name: 'PharmacyHome' });
                }).catch((error)=>{console.log(error)})
            }
        }
}
</script>

<style>

</style>