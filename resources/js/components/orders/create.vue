<template>
    <div class="card">
        <div class="card-header  py-4">
            <span>Add Order Form</span>
            <router-link :to="{ name: 'order' }"  class="nav-item float-end navbar-brand p-0 ">Go Back</router-link>
        </div>

        <div class="card-body">
                <div class="row mb-3 align-items-center">
                    <div class="co-12 col-md-3">
                        <div class="input-group mb-3">
                            <label for="username" class="input-group-text">Doctor Name: </label>
                            <input id="username" name="username" class="form-control text-capitalize" disabled :value="current.name"/> 
                        </div>
                    </div>
                    <div class="co-12 col-md-4">
                        <div class="input-group mb-3">
                            <label for="drug" class="input-group-text">Drug Name: </label>
                            <!-- <input class="form-select form-control" list="brow">
                                <datalist id="brow">
                                    <option v-for="(drug, index) in filterddrugs" :value="drug.name" :key="index">{{drug.name}}</option>
                                </datalist>  -->


                            <select id="drug" v-model="drugindex" name="drug"  class="form-select form-control" required> 
                                <option v-for="(drug, index) in filterddrugs" :value="index" :key="index">{{drug.name}}</option>
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
                            <th>#</th>
                            <th>drug_name</th>
                            <th>qty</th>
                            <th>unit</th>
                            <th>price</th>
                            <th>Discount</th>
                            <th>total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>		
                        <tr v-for="(item, index) in items" :key="index">
                            <td>{{index + 1}}</td>
                            <td>{{item.name}}</td>
                            <td :class="item.qty>0 ? '':'bg-danger text-light'" style="--bs-bg-opacity: .3;">
                                <input class="form-control d-inline me-1" style="width:55px" v-model="item.qty">
                                <input class="form-control d-inline px-0" disabled style="width:55px" :value="item.showav(item.avilable,item.type,item.packet)">
                            </td>
                            <td :class="item.unit ? '':'bg-danger text-light'" style="--bs-bg-opacity: .3;">
                                <select id="drug" v-model="item.unit" name="drug"  class="form-select form-control" required> 
                                    <option v-if="item.type !== 'Syrp'">Tap</option>
                                    <option v-if="item.type !== 'Syrp'">Box</option>
                                    <option v-if="item.type === 'Syrp'">Bottle</option>
                                </select>
                            </td>
                            <td><input class="form-control" disabled style="width:110px" :value="item.price(item.unit,item.smallprice,item.packet)"></td>
                            <td>
                                <input class="form-control d-inline" style="width:65px;" v-model="item.disc">
                                <input class="form-control d-inline" disabled style="width:55px;" :value="item.olddisc">
                            
                            </td>
                            <td>
                                <input class="form-control" style="width:110px; display: inline" :value="item.total(item.qty, item.unit,item.smallprice,item.packet,item.disc)? item.total(item.qty, item.unit,item.smallprice,item.packet,item.disc) : 'the unit'" type="text" disabled>
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
                            <td colspan="2" style="background-color: #D6EEEE">total: {{total? total:"Enter the amount and the unit of drugs PLZ" }}</td>
                            <td colspan="4">
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
            drugindex:'',
            total:'0',
            data:{},
            current:'',
            send:false,
        }
    },
    mounted() {
        this.getdrugs()
        this.currentuser()
        sortField: 'text'; //ينفع ابحث فيه select box علشان اخلي ال
    },
    methods:{
        currentuser(){
            axios.get('http://localhost/NewPh/public/current')
                .then(response=>{this.current=response.data})
                // .catch(location.reload());
        },
        updatetotal(){
            this.total= 0
            this.items.forEach(item => {
                this.total = parseFloat(this.total) + item.total(item.qty, item.unit,item.smallprice,item.packet,item.disc)
            });

        },
        removeitem(id){
            this.items = this.items.filter((item)=>{return item.name != id ? item : ""})
            this.filterddrugs.push(
                this.drugs.filter((drug)=>{return drug.name === id  ?  drug : ""})[0]
            )
            this.updatetotal()
            // this.filterddrugs=this .drugs
        },
        additem(){
            this.items.push(
                {
                name:this.filterddrugs[this.drugindex].name,
                qty:'0',
                type:this.filterddrugs[this.drugindex].type,
                unit:'',
                smallprice:this.filterddrugs[this.drugindex].smallprice,
                packet:this.filterddrugs[this.drugindex].packet,
                disc:'0',
                olddisc:this.filterddrugs[this.drugindex].disc,
                avilable:this.filterddrugs[this.drugindex].avilablesunit,
                showav:function(a,t,p){
                    if(t==="Syrp")
                        return a;
                    else
                    {
                        return  Math.floor(a/p) + " : " + parseInt(a % p)
                    }
                },
                netqty:function(q,t,p){
                    if(t==="Tap"||t==="Bottle")
                    {
                        return q;
                    }
                    else if(t==="Box")
                    {
                        return p*q
                    }
                },
                price:function(t,p,pack){
                    if(t==="tap"||t==="Tap"||t==="bottle"||t==="Bottle")
                        return p;
                    else if(t==="box"||t==="Box")
                        return p*pack
                }, 
                //q => qty , p =>price , pack => packet , dis => discount 
                total:function(q,t,p,pack,dis){
                    if(t==="tap"||t==="Tap"||t==="bottle"||t==="Bottle")
                        {
                            return (p*q) - (p*q*dis/100)
                        }
                    else if(t==="box"||t==="Box")
                        {
                            return (p*pack*q) - (p*pack*q * dis/100)
                        }
                    }
                    
                })
                this.filter(this.filterddrugs[this.drugindex].name)
                this.updatetotal()
                this.drugindex=''
        },
        getdrugs(){
            axios.get('http://localhost/NewPh/public/drugs')
                .then(response => {this.drugs = response.data;this.filterddrugs=response.data})
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
            this.data["username"] = this.current.name
            if(this.items && this.total > 0 && this.current.name)
                {
                    this.items.every(item => {

                        if((item.avilable - item.netqty(item.qty,item.unit,item.packet)) < 0)
                        {
                            this.send=false
                            alert("you dont have enough amount of "+item.name)
                            // to break every key word =============================================================>
                            return false;
                        }
                        else{
                            this.send=true
                            // to continue looping (i use (every) to loop not foreach)==============================>
                            return true;
                        }
                            
                    });
                    if(this.send)
                    {
                        axios.post("http://localhost/NewPh/public/orders",this.data)
                            .then(this.$router.push({ name: "order"}) )
                            .catch(error => console.log(error))
                    }
                    
                }
            else 
                alert('you have no items in this order')
        }
    }
}
</script>

<style>

</style>