<template>
    <div class="col-xl-3 col-md-4 theiaStickySidebar">
        <loader v-if="loading" />
<!--        <div-->
<!--            class="email-verify"-->
<!--            @click.once="verify"-->
<!--            v-if="!user.email_verified_at"-->
<!--        >تاكيد البريد الالكتروني-->
<!--        </div>-->
        <div class="settings-widget">
            <div v-if="user" class="settings-header imageUser d-sm-flex flex-row flex-wrap text-center text-sm-start align-items-center">
                <a  href="#" @click="image">
                    <img
                        alt="profile image"
                        :src="`/web/img/user/${user.id}/${user.image}`"
                        onerror="src='/web/img/img-04.jpg'"
                        id="imgSrc"
                        class="avatar-lg rounded-circle"
                    >
                    <form enctype="multipart/form-data">
                        <input type="file"  @change="changeImageProfile" id="inputImage">
                    </form>
                </a>
                <div class="ms-sm-3 ms-md-0 infoUser mt-2 mt-sm-0 mt-md-2 mt-lg-0">
                    <p class="mb-2">مرحبا بك,</p>
                    <h3 class="mb-0">
                        {{user.name}}
                    </h3>
                    <p  class="mb-0 editProfile" v-if="parseInt(partner.trust) && roles.includes('design') && !user.email_verified_at">
                        <router-link :to="{name:'profile',params:{lang:this.$i18n.locale}}">تعديل الحساب</router-link>
                    </p>
                    <p  class="mb-0 editProfile" v-if="parseInt(partner.trust) && roles.includes('company') && !user.email_verified_at">
                        <router-link  :to="{name:'profileCompany',params:{lang:this.$i18n.locale}}">تعديل الحساب</router-link>
                    </p>
                    <p  class="mb-0 editProfile" v-if="parseInt(partner.trust) && roles.includes('client') && !user.email_verified_at">
                        <router-link  :to="{name:'profileClient',params:{lang:this.$i18n.locale}}">تعديل الحساب</router-link>
                    </p>
                </div>
            </div>
            <div class="settings-menu">
                <ul>

                    <!-- start company  -->
                    <div class="mb-4"  v-if="roles.includes('company')">
                        <li class="nav-item">
                            <router-link
                                :to="{name:'dashboardCompany',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link',$route.name != 'dashboardCompany'? 'main-adver': '']"
                            >
                                <i class="material-icons">verified_user</i> الرئيسيه
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="!parseInt(partner.send) || !parseInt(partner.trust)">
                            <router-link
                                :to="{name:'trustCompany',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link',$route.name == 'trustCompany' ? 'active' : '']"
                                v-if="!parseInt(partner.send)"
                            >
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </router-link>

                            <a href="javascript:void(0);" @click="sendData"  class="nav-link" v-else>
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </a>
                        </li>
                    </div>
                    <!-- end company  -->

                    <!-- start design  -->

                    <div class="mb-4"  v-if="roles.includes('design')">

                        <li class="nav-item">
                            <router-link
                                :to="{name:'dashboardDesign',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link', $route.name != 'dashboardDesign'? 'main-adver': '']"
                            >
                                <i class="material-icons">verified_user</i> الرئيسيه
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="!parseInt(partner.send) || !parseInt(partner.trust)">
                            <router-link
                                :to="{name:'trust',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link',$route.name == 'trust' ? 'active' : '']"
                                v-if="!parseInt(partner.send)"
                            >
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </router-link>

                            <a href="javascript:void(0);" @click="sendData"  class="nav-link" v-else>
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </a>
                        </li>
                    </div>

                    <!--   end design  -->

                    <!--    start advertise    -->

                    <div class="mb-4" v-if="roles.includes('advertiser')">

                        <li class="nav-item">
                            <router-link
                                :to="{name:'dashboardAdvertise',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link', $route.name != 'dashboardAdvertise'? 'main-adver': '']"
                            >
                                <i class="material-icons">verified_user</i> الرئيسيه
                            </router-link>
                        </li>

                        <li class="nav-item" v-if="!user.email_verified_at">
                            <router-link
                                :to="{name:'packages',params: {lang:this.$i18n.locale}}"
                                :class="['nav-link',$route.name == 'packages' ? 'active' : '']"
                            >
                                <i class="material-icons">person_add</i> Packages
                            </router-link>
                        </li>

                    </div>

                    <!--    end advertise    -->

                    <!--    start client    -->

                    <div class="mb-4" v-if="roles.includes('client')">
                        <li class="nav-item">
                            <router-link
                                :to="{name:'dashboardClient',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link', $route.name != 'dashboardClient'? 'main-adver': '']"
                            >
                                <i class="material-icons">verified_user</i> الرئيسيه
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="!parseInt(partner.send) || !parseInt(partner.trust)">
                            <router-link
                                :to="{name:'trustClient',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link',$route.name == 'trustClient' ? 'active' : '']"
                                v-if="!parseInt(partner.send)"
                            >
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </router-link>

                            <a href="javascript:void(0);" @click="sendData"  class="nav-link" v-else>
                                <i class="material-icons">person_pin</i> تاكيد الحساب
                            </a>
                        </li>
                        <li
                            class="nav-item"
                            v-if="parseInt(partner.trust)"
                        >
                            <router-link
                                :to="{name:'addProject',params:{lang:this.$i18n.locale}}"
                                :class="['nav-link', $route.name == 'addProject'? 'active': '']"
                            >
                                <i class="material-icons">person_add</i> اضافه مشروع
                            </router-link>
                        </li>
                    </div>

                    <!--    end client    -->

                    <li class="nav-item">
                        <button @click="logout" type="submit"  class="nav-link">
                            <i class="material-icons">power_settings_new</i> Logout
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import {useStore} from "vuex";
import {ref, computed, onBeforeMount, onMounted} from 'vue';
import webApi from "../../api/webAxios";
import { useRoute } from 'vue-router'
import router from "../../router/webRoute";

export default {
    name: "Sidebar",
    setup(){
        const store = useStore();

        const partner = computed(() => store.getters['auth/partner']);
        const user = computed(() => store.getters['auth/user']);
        let roles = ref([]);

        let sendData = () => {
            Swal.fire({
                title: 'يتم الان مراجعه بيانات حسابك لتاكيد من صحتها!',
                icon: 'info',
                confirmButtonColor: '#fcb00c',
                confirmButtonText: 'موافق',
            });
        };

        let verify = function (){
            loading.value = true;
            webApi.get(`/v1/web/email/verification-notification`)
                .then((res) => {

                })
                .catch((err) => {
                    console.log(err.response)
                })
                .finally(() => {
                    loading.value = false;
                });
            console.log('ahmed')
        };

        onBeforeMount(() => {
            store.dispatch('auth/userUpdate');
            store.dispatch('auth/partnerUpdate');
        });

        onMounted(() => {
            roles.value = JSON.parse(localStorage.getItem('user')).role_name;
        });

        const file = ref({});
        const loading = ref(false);
        let image = () => {document.getElementById('inputImage').click()}
        let changeImageProfile = (e) => {

            loading.value = true;
            file.value = e.target.files[0];

            if(file.value){
                let formData = new FormData();
                formData.append('file',file.value);

                webApi.post(`/v1/web/changeImage`,formData)
                    .then((res) => {
                        let reader = new FileReader();

                        reader.onload = () => {
                            let img = document.getElementById('imgSrc');
                            img.setAttribute('src',reader.result);
                        }

                        reader.readAsDataURL(e.target.files[0]);

                        Swal.fire({
                            icon: 'success',
                            title: 'تم تغير الصوره بنجاح .',
                            showConfirmButton: false,
                            timer: 2000
                        })

                    })
                    .catch((err) => {
                        Swal.fire({
                            icon: 'error',
                            title: 'يوجد خطا في الصوره...',
                            text: 'اقصي ارتفاع للصوره يكون 500px و اقصي عرض 500px و ان حجمها لا يتعدي 2mb !',
                        });
                    })
                    .finally(() => {
                        loading.value = false;
                    });
            }

        };

        function logout(){
            store.dispatch('auth/logout');
        }

        return {logout,verify,partner,user,sendData,image,changeImageProfile,file,loading,roles}
    }
}
</script>

<style scoped>
.email-verify{
    text-align: center;
    font-size: 20px;
    color: #fcb00c;
    background: #fff;
    padding: 15px;
    margin-bottom: 15px;
    font-weight: 500;
    cursor: pointer;
    border: 1px solid;
    transition: all .3s ease-in-out;
}

.email-verify:hover{
    background: #fcb00c;
    color: #fff
}

.settings-menu ul li a i {
    margin-left: 8px;
}
.ms-lg-3 {
    margin-right: 1rem!important;
}
.imageUser{
    cursor: pointer;
    position: relative;
}
.imageUser input{
    position: absolute;
    opacity: 0;
    z-index: -1;
}
.imageUser a{
    display: inline-block;
    margin: auto;
}
.editProfile a{
    color: #fff;
}
.settings-header h3, .settings-header h3 a {
    font-size: 20px;
}
.infoUser{
    margin: 0 1rem!important;
    width: 100%;
}
.avatar-lg {
    width: 5rem;
    height: 5rem;
}

.settings-menu ul li a.main-adver {
    color: #000 !important;
    border: 0;
}

.settings-menu ul li a.main-adver:hover {
    color: #fcb00c !important;
    border: 0;
}

</style>
