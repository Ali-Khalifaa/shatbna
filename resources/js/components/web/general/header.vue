<template>
    <!-- Header -->
    <header :class="['header',scroll ?'custom-header':'']">
        <nav :class="['navbar','navbar-expand-lg','header-nav',token ? 'navbar-space' : '']">
            <div class="navbar-header">
                <a id="mobile_btn" href="javascript:void(0);">
							<span class="bar-icon">
								<span></span>
								<span></span>
								<span></span>
							</span>
                </a>
                <router-link :to="{name:'home',params: {lang:this.$i18n.locale}}" class="navbar-brand logo">
                    <img src="/web/img/logo.png" class="img-fluid" alt="Logo">
                </router-link>
            </div>
            <div class="main-menu-wrapper">
                <div class="menu-header">
                    <router-link :to="{name:'home',params: {lang:this.$i18n.locale}}" class="menu-logo">
                        <img src="/web/img/logo.png" class="img-fluid" alt="Logo">
                    </router-link>
                    <a id="menu_close" class="menu-close" href="javascript:void(0);">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <ul class="main-nav">
                    <li :class="[$route.name == 'home' ? 'active' : '','nav-item']">
                        <router-link :to="{name:'home',params: {lang:this.$i18n.locale}}">
                            {{$t('header.home')}}
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name:'browse-project',params: {lang:this.$i18n.locale}}">
                            {{$t('header.browse')}}
                        </router-link>
                    </li>
                    <li class="has-submenu">
                        <a href="#">{{$t('header.service')}}<i class="fas fa-chevron-down"></i></a>
                        <ul class="submenu">
                            <li>
                                <router-link :to="{name:'company-partiner',params: {lang:this.$i18n.locale}}">
                                    {{$t('header.company')}}
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'design-partiner',params: {lang:this.$i18n.locale}}">
                                    {{$t('header.desgin')}}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="index.html">{{$t('header.bargain')}}</a>
                    </li>

                    <li :class="[$route.name == 'sizingService' ? 'active' : '','nav-item']">
                        <router-link :to="{name:'sizingService',params: {lang:this.$i18n.locale}}" class="partner">
                            {{$t('header.size')}}
                        </router-link>
                    </li>
                    <li :class="[$route.name == 'advisorShatabna' ? 'active' : '','nav-item']">
                        <router-link :to="{name:'advisorShatabna',params: {lang:this.$i18n.locale}}" class="partner">
                            {{$t('header.advisor')}}
                        </router-link>
                    </li>
                </ul>
                <ul class="nav header-navbar-rht">
                    <li v-if="token">
                        <router-link :to="{name:'home',params: {lang:this.$i18n.locale}}" class="partner">
                            Ahmed Mohamed
                        </router-link>
                    </li>
                    <li v-if="!token">
                        <router-link :to="{name:'partners',params: {lang:this.$i18n.locale}}" class="partner">
                            {{$t('header.partner')}}
                        </router-link>
                    </li>
                    <li v-if="!token" :class="[$route.name == 'registerPartiner' ? 'active' : '']">
                        <router-link :to="{name:'registerClient',params: {lang:this.$i18n.locale}}" class="reg-btn custom">
                            <i class="fas fa-user"></i> {{$t('header.register')}}
                        </router-link>
                    </li>
                    <li v-if="!token" :class="[$route.name == 'loginPartiner' ? 'active' : '']">
                        <router-link :to="{name:'loginPartiner',params: {lang:this.$i18n.locale}}" class="log-btn custom">
                            <i class="fas fa-lock"></i>
                            {{$t('header.login')}}
                        </router-link >
                    </li>
                    <lang  />
                    <li v-if="token">
                        <router-link
                            :to="{name:'addProject',params: {lang:this.$i18n.locale}}"
                            v-if="role.role_name.includes('client')"
                            class="login-btn addProject"
                        >
                            {{$t('header.project')}}
                        </router-link >
                    </li>
                    <li v-if="!token">
                        <router-link :to="{name:'addProject',params: {lang:this.$i18n.locale}}" class="login-btn">
                            {{$t('header.project')}}
                        </router-link >
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- /Header -->
</template>

<script>
import lang from './LangWeb.vue';
import {useStore} from 'vuex';
import {computed,ref,onMounted} from 'vue';

export default {
    name: "layout-header",
    components:{
        lang
    },
    data(){
        return {
            roles: localStorage.getItem('user')? JSON.parse(localStorage.getItem('user')).role_name : []
        }
    },
    setup(){

        const store = useStore();
        const token = computed(() => store.getters['auth/token']);
        const role = computed(() => store.getters['auth/user'] || []);


        function init() {
            var $this = $('.main-nav a');
            $('.main-nav a').on('click', function(e) {
                if($(this).parent().hasClass('has-submenu')) {
                    e.preventDefault();
                }
                if(!$(this).hasClass('submenu')) {
                    $('ul', $(this).parents('ul:first')).slideUp(350);
                    $('a', $(this).parents('ul:first')).removeClass('submenu');
                    $(this).next('ul').slideDown(350);
                    $(this).addClass('submenu');
                } else if($(this).hasClass('submenu')) {
                    $(this).removeClass('submenu');
                    $(this).next('ul').slideUp(350);
                }
            });
        }


        onMounted(() => {
            init();
        });

        return {token,scroll,role};
    }
}
</script>

<style scoped>
    .header{
        background-color: #fff;
        position: static;
    }

    .navbar-space{
        justify-content: space-around ;
    }

    .header.custom-header{
        position: fixed;
    }

    .logo{
        width: 140px;
    }
    .main-menu-wrapper{
        display: flex;
    }

    .main-nav li a{
        font-size: 15px !important;
        font-weight: 500;
        color: #000;
    }
    .main-nav li a:hover{
        color: #fcb00c;
    }
    .main-nav > li.active > a{
        color: #fcb00c;
    }
    .main-nav > li.active > a::after {
        background: #fcb00c;
    }

    .header-navbar-rht .reg-btn:hover {
        color: #fcb00c !important;
    }
    .header-navbar-rht .login-btn {
        background: #fcb00cd6;
        border-color: #fcb00cd6;
        padding: 5px 15px;
        font-size: 16px;
        box-shadow: none;
    }
    .header-navbar-rht .login-btn:hover {
        background: #fcb00c;
        border-color: #fcb00c;
    }
    .header-navbar-rht .custom{
            font-size: 13px !important;
    }

    .header-navbar-rht .partner{
        color: #fcb00c;
        padding: 5px 15px;
        font-size: 14px;
        box-shadow: none;
        border: 1px solid #fcb00c;
        border-radius: 50px;
    }
    .header-navbar-rht .partner:hover{
       background-color: #fcb00c !important;
       color: #fff !important;
    }

    .active{
        color: #fcb00c;
    }

    .addProject{
        color: #fff !important;
    }

    .main-nav > li > a > i {
        font-size: 15px;
        margin: 0 5px !important;
    }

    @media only screen and (max-width: 1115px){
        .main-nav > li {
            margin-right: 11px;
        }
        .main-nav li a {
            font-size: 13px !important;
        }
        .header-navbar-rht .login-btn {
            padding: 5px 8px;
            font-size: 11px !important;
        }
        .header-navbar-rht .partner{
            padding: 5px 8px;
            font-size: 10px !important;
        }
        .header-navbar-rht li {
            margin-right: 15px;
        }
        .header-navbar-rht .custom{
            font-size: 11px !important;
        }
        .main-nav > li:last-child {
            margin-right: 15px;
        }
    }

    @media only screen and (max-width: 992px){
        .main-menu-wrapper{
            display: inline-block;
        }
        .main-nav li a {
            font-size: 15px !important;
        }
        .header-navbar-rht{
            margin-top: 20px;
        }
        .main-nav > li:last-child {
            margin-right: 20px;
        }
        .header-navbar-rht .login-btn {
            padding: 5px 12px;
            font-size: 12px !important;
            margin-top: 20px;
        }
        .header-navbar-rht .partner{
            padding: 5px 12px;
            font-size: 11px !important;
        }
        .navbar-header {
            width: 100%;
            justify-content: space-between;
        }
        .main-nav > li .submenu li a {
            background-color: #FFf;
        }
    }

    @media only screen and (max-width: 768px) {
        .header-navbar-rht .login-btn {
            padding: 5px 12px;
            font-size: 12px !important;
        }
        .header-navbar-rht .partner{
            padding: 5px 12px;
            font-size: 11px !important;
        }
    }

    @media only screen and (max-width: 600px) {
        .main-nav > li:last-child {
            margin-right: 15px;
        }
        .header-navbar-rht{
            display: block;
        }
    }

</style>
