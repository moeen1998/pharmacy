<template>
<div class="card">
        <div class="card-header  py-4">
            <span>Edit Pill Form</span>
            <router-link :to="{ name: 'parchase' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
        </div>

        <div class="card-body">
                <div class="row mb-3 align-items-center">

                    <div class="co-12 col-md-3">
                        <div class="input-group mb-3">
                            <label for="supplier" class="input-group-text">Supplier</label>
                            <select id="supplier" v-model="suppliername" name="supplier"  class="form-select form-control" required> 
                                <option v-for="supplier in suppliers" :key="supplier.id">{{supplier.name}}</option>
                            </select>  
                        </div>
                    </div>
                    <div class="co-12 col-md-4">
                        <div class="input-group mb-3">
                            <label for="drug" class="input-group-text">Drug</label>
                            <select id="drug" v-model="drugname" name="drug"  class="form-select form-control" required> 
                                <option v-for="drug in filterddrugs" :key="drug.id">{{drug.name}}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="input-group mb-3">
                            <button @click="additem" class="btn btn-success w-100">Add</button>
                        </div>
                    </div>
                </div> 
                <table class="table table-bordered border-primary">
                    <thead>
                        <tr>
                            <th>drug_name</th>
                            <th>qty</th>
                            <th>price</th>
                            <th>Discount</th>
                            <th>total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>		
                        <tr v-for="item in items" :key="item.count">
                            <td>{{item.name}}</td>
                            <td><input class="form-control" style="width:110px" v-model="item.qty"></td>
                            <td><input class="form-control" style="width:110px" v-model="item.price"></td>
                            <td><input class="form-control" style="width:110px;" v-model="item.disc"></td>
                            <td>
                                <input class="form-control" style="width:110px; display: inline" :value="item.total(item.qty,item.price)" type="text" disabled>
                                <button @click="updatetotal()" class="btn btn-success"><i class="fa-solid fa-check"></i></button>
                                </td>
                            <td>
                                <button @click="removeitem(item.name)" class="btn btn-danger">Rmove</button>
                                
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" style="background-color: #D6EEEE">items: {{items.length}}</td>
                            <td colspan="2" style="background-color: #D6EEEE">total: {{total}}</td>
                            <td colspan="2">
                                <button v-if="items.length > 0" type="submit" @click="submit" class="btn btn-primary float-end">Save The Items</button>
                            </td>
                        </tr>
                    </tfoot>
                </table>
        </div>
    </div>
</template>

<script>
export default {


data(){
        return{
            items:[],
            drugs:[],
            filterddrugs:[],
            suppliers:[],
            suppliername:'',
            drugname:'',
            total:'0',
            data:{},
            parchase:{}
        }
    },
    mounted() {
        this.getsuppliers()
        this.getdrugs()
        this.edit(this.$route.params.id);
    },
    methods:{
        updatetotal(){
            this.total=0
            this.items.forEach(item => {
                this.total = parseFloat(this.total) + item.total(item.qty,item.price)
            });
        },
        removeitem(id){
            this.items = this.items.filter((item)=>{return item.name != id ? item : ""})
            this.filterddrugs.push(
                this.drugs.filter((drug)=>{return drug.name === id  ?  drug : ""})[0]
            )
            this.updatetotal()
        },
        additem(){
            this.items.push({
                name:this.drugname,
                qty:'0',
                price:'0',
                disc:'0',
                total:function(qty,price){
                    return parseInt(qty) * parseFloat(price)
                    }
                })
                this.filter(this.drugname)
                this.updatetotal()
        },
        getsuppliers(){
            axios.get('http://localhost/NewPh/public/suppliers')
                .then(response =>{this.suppliers = response.data})
                .catch(error => console.log(error))
        },
        getdrugs(){
            axios.get('http://localhost/NewPh/public/drugs')
                .then(response => {this.drugs = response.data;this.filterddrugs=response.data;})
                .catch(error => console.log(error))
        },
        filter(name){
            this.filterddrugs = this.filterddrugs.filter((drug)=>{return drug.name.toUpperCase()!=name.toUpperCase()  ?  drug : ""})
        },
        submit(){
            this.updatetotal()
            this.data={}
            this.data["items"] = this.items
            this.data["total"] = this.total
            this.data["suppliername"] = this.suppliername
            if(this.items && this.total>0 && this.suppliername)
                {
                    axios.put(`http://localhost/NewPh/public/parchases/${this.$route.params.id}`,this.data)
                        .then(this.$router.push({ name: "parchase"}) )
                        .catch(error => console.log(error))
                }
        },
        edit(id) {
            axios.get(`http://localhost/NewPh/public/parchases/${id}/edit`)
                .then((res) => {
                    this.parchase=res.data;
                    this.parchase["drugs"].forEach(item => {
                        this.items.push({
                            name:item.drug_name,
                            qty:item.qty,
                            price:item.price,
                            disc:item.disc,
                            total:function(qty,price){
                                return parseInt(qty) * parseFloat(price)
                                }
                            })
                            this.filter(item.drug_name)
                            this.updatetotal()
                        });
                        this.suppliername=this.parchase["supplier_name"] 
                }
            );
        },
    }
}
</script>

<style>

</style>