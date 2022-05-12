<template>
    <div class="text-capitalize">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <router-link :to="{ name: 'PharmacyHome' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-p"></i>harmacy</router-link>

            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <div class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0"></div>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle show" @click="toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="true"><i class="fas fa-user fa-fw me-2"></i>{{current.name}}</a>
                    <ul :class=" show? 'dropdown-menu dropdown-menu-end show' :'dropdown-menu dropdown-menu-end'" @click="toggle" style="position: absolute; top:100; right:-20px" aria-labelledby="navbarDropdown">
                        <li>
                            <router-link :to="{ name: 'PharmacyHome' }"   class="ms-1 navbar-brand nav-item nav-link dropdown-item" style="color: #212529;">Home</router-link>
                        </li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a  @click="logout" href="#" class="dropdown-item">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <div v-if="current.role === 'admin'" >
                                <router-link :to="{ name: 'Users' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-users sb-nav-link-icon"></i>Users</router-link>
                                <router-link :to="{ name: 'category' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-list sb-nav-link-icon"></i>Categories</router-link>
                                <router-link :to="{ name: 'place' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-location-dot sb-nav-link-icon"></i>Location Rack</router-link>
                                <router-link :to="{ name: 'company' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-building sb-nav-link-icon"></i>Medical Companies</router-link>
                                <router-link :to="{ name: 'supplier' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-truck-field-un sb-nav-link-icon"></i>Medical Suppliers</router-link>
                                <router-link :to="{ name: 'drug' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-kit-medical sb-nav-link-icon"></i>Medicien</router-link>
                                <router-link :to="{ name: 'parchase' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-money-check-dollar sb-nav-link-icon"></i>Medican Purchases</router-link>
                                <router-link :to="{ name: 'order' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-dollar-sign sb-nav-link-icon"></i>Orders</router-link>
                                <a @click="logout" href="#" class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-arrow-right-from-bracket sb-nav-link-icon"></i>Loout</a>
                            </div>
                            <div v-else>
                                <router-link :to="{ name: 'parchase' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-money-check-dollar sb-nav-link-icon"></i>Medican Parchases</router-link>
                                <router-link :to="{ name: 'order' }"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-dollar-sign sb-nav-link-icon"></i>Orders</router-link>
                                <a @click="logout" href="#"  class="navbar-brand ps-3 nav-item nav-link"><i class="fa-solid fa-arrow-right-from-bracket sb-nav-link-icon"></i>Loout</a>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as : {{current.role}} user</div>
                        {{current.name}}
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <router-view> </router-view>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Reserved To Moeen Adly 2022</div>
                            <div>
                                <a href="tel:01210430759"><i class="fa-solid fa-phone me-2"></i>01210430759</a>
                                <a href="https://www.facebook.com/moeen.adly"><i class="fa-brands fa-facebook-square mx-2"></i>Moeen Adly</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                current:'',
                show:false
            }
        },
        mounted(){
            this.currentuser()
        },
        methods:{
            toggle(){
                this.show=!this.show;
            },
            logout(){
                axios.post('http://localhost/NewPh/public/logout')
                .then(setTimeout(()=>{window.location.href = "http://localhost/NewPh/public/login"}, 500))
            },
            currentuser(){
                axios.get('http://localhost/NewPh/public/current')
                .then(response=>{this.current=response.data})
                .catch(erroe=>console.log('logged out'));
            },
        }
    }
</script>