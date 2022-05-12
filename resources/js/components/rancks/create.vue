<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Places Form</span>
            <router-link :to="{ name: 'place' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
            </div>

        <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">Place</label>
                    <div class="col-md-6">
                        <input id="place" v-model="place.place" type="text" class="form-control" name="place" required autocomplete="name" autofocus>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" @click="submit" class="btn btn-primary">
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
    data(){
        return{
            place:{
                place:'',
            },
            places:[],
            send:false
            
        }
    },
    mounted() {
        this.getplaces()
    },
    methods:{
        getplaces(){
            axios.get('http://localhost/NewPh/public/places')
                .then(response => {this.places = response.data})
                .catch(error => console.log(error))
                this.search=""
        },
        submit(e){
            e.preventDefault();
            if(this.place.place)
                {
                    this.places.every(element => {
                        if(element.name.split(" ").join("").toUpperCase() === this.place.place.split(" ").join("").toUpperCase()){
                            this.send=false
                            return false;
                        }
                        else{
                            this.send=true
                            return true;
                        }
                    })
                    if(this.send){
                        axios.post("http://localhost/NewPh/public/places",this.place)
                        .then(this.$router.push({ name: "place"}) )
                        .catch(error => console.log(error))
                    }
                    else{
                        alert('This Place Exists Before')
                    }
                    
                }
        }
    }
}
</script>

<style>

</style>