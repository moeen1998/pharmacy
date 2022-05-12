<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Category Form</span>
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
                        <button type="submit" @click="submit" class="btn btn-primary">
                            Save Category
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
            category:{
                name:'',
            },
            categories:[],
            send:false
            
        }
    },
    mounted() {
        this.getcategories()
    },
    methods:{
        getcategories(){
        // http://127.0.0.1:8000/
            axios.get('http://localhost/NewPh/public/categories')
                .then(response => {this.categories = response.data;})
                .catch(error => console.log(error))
                this.search=""
        },
        submit(e){
            e.preventDefault();
            if(this.category.name)
                {
                    this.categories.every(element => {
                        if(element.name.split(" ").join("").toUpperCase() === this.category.name.split(" ").join("").toUpperCase()){
                            this.send=false
                            return false;
                        }
                        else{
                            this.send=true
                            return true;
                        }
                    })
                    if(this.send){
                        axios.post("http://localhost/NewPh/public/categories",this.category)
                        .then(this.$router.push({ name: "category"}) )
                        .catch(error => console.log(error))
                    }
                    else{
                        alert('This Category Exists Before')
                    }
                    
                }
        }
    }
}
</script>

<style>

</style>