<template>
    <form @submit.prevent="Designsubmit" >

        <div class="form-group form-focus">
            <input type="text" v-model="v$.name.$model" class="form-control floating">
            <label class="focus-label">{{$t('register.full_name')}} </label>
        </div>
        <div v-if="v$.name.$error">
            <span class="text-danger" v-if="v$.name.required.$invalid">full name is required.<br /> </span>
            <span class="text-danger" v-if="v$.name.minLength.$invalid">full name is must have at least {{ v$.name.minLength.$params.min }} letters. <br /></span>
            <span class="text-danger" v-if="v$.name.maxLength.$invalid">full name is must have at most {{ v$.name.maxLength.$params.max }} letters. <br /></span>
        </div>

        <div class="form-group form-focus">
            <input type="email" v-model="v$.email.$model" class="form-control floating">
            <label class="focus-label">{{$t('register.email')}}</label>
        </div>
        <div v-if="v$.email.$error || errors.email">
            <span class="text-danger" v-if="v$.email.required.$invalid">email is required.<br /> </span>
            <span class="text-danger" v-if="v$.email.email.$invalid">must be a valid email address. </span>
            <span class="text-danger" v-if="errors.email">{{errors.email[0]}}</span>
        </div>

        <div class="form-group form-focus">
            <input type="password" v-model="v$.password.$model" class="form-control floating">
            <label class="focus-label">{{$t('register.password')}}</label>
        </div>
        <div v-if="v$.password.$error">
            <span class="text-danger" v-if="v$.password.required.$invalid">password is required.<br /> </span>
            <span class="text-danger" v-if="v$.password.alphaNum.$invalid">must be letters or numbers. <br /></span>
            <span class="text-danger" v-if="v$.password.minLength.$invalid">password is must have at least {{ v$.password.minLength.$params.min }} letters. <br /></span>
            <span class="text-danger" v-if="v$.password.maxLength.$invalid">password is must have at most {{ v$.password.maxLength.$params.max }} letters. </span>
        </div>

        <div class="form-group form-focus">
            <input type="password" v-model="v$.confirmtion.$model" class="form-control floating">
            <label class="focus-label">{{$t('register.confirm')}}</label>
        </div>
        <div v-if="v$.confirmtion.$error">
            <span class="text-danger" v-if="v$.confirmtion.required.$invalid">confirmtion is required.<br /> </span>
            <span class="text-danger" v-if="v$.confirmtion.sameAs.$invalid">confirmtion other must match. <br /></span>
        </div>

        <div class="row">

            <div class="col-md-6">
                <div class="form-group form-focus">
                    <input type="date" v-model="dataDesign.birth" class="form-control floating">
                    <label class="focus-label">{{$t('register.birth')}}</label>
                </div>
                <div v-if="v$.birth.$error">
                    <span class="text-danger" v-if="v$.birth.required.$invalid">birth is required.<br /> </span>
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group form-focus">
                    <select v-model="dataDesign.country" @change="conutryState" class="form-control floating">
                        <option :value="country.id" v-for="country in countries">
                            {{country.name}}
                        </option>
                    </select>
                    <label class="focus-label">{{$t('register.country')}}</label>
                </div>
                <div v-if="v$.country.$error">
                    <span class="text-danger" v-if="v$.country.required.$invalid">country is required.<br /> </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group form-focus">
                    <select v-model="dataDesign.state"  class="form-control floating">
                        <option v-if="states" :value="state.id" v-for="state in states">
                            {{state.name}}
                        </option>
                    </select>
                    <label class="focus-label">{{$t('register.state')}}</label>
                </div>
                <div v-if="v$.state.$error">
                    <span class="text-danger" v-if="v$.state.required.$invalid">state is required.<br /> </span>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group form-focus">
                    <input type="text" v-model.trim="dataDesign.phone" :class="['form-control','floating',dataDesign.country ? 'phone': '']">
                    <label class="focus-label">{{$t('register.phone')}}</label>
                    <span class="flag"  v-if="dataDesign.country" v-for="(count) in foucsCountry">
                        <img v-if="this.$i18n.locale == 'en'" :src="'/web/img/country/'+ count.media.file_name">
                        <span class="codeCountry">{{count.code}}</span>
                        <img v-if="this.$i18n.locale == 'ar'" :src="'/web/img/country/'+ count.media.file_name">
                    </span>
                </div>
                <div v-if="v$.phone.$error || errors.phone || !validPhone">
                    <span class="text-danger" v-if="v$.phone.required.$invalid">phone is required.<br /> </span>
                    <span class="text-danger" v-if="v$.phone.maxLength.$invalid">phone is must have at most {{ v$.phone.maxLength.$params.max }} numbers.<br/> </span>
                    <span class="text-danger" v-if="v$.phone.integer.$invalid">must be number.<br /> </span>
                    <span class="text-danger" v-if="!validPhone">phone is not valid.<br /> </span>
                    <span class="text-danger" v-if="errors.phone">{{errors.phone[0]}}</span>
                </div>
            </div>

            <div class="col-md-3 card">
                <div class="card-body text-center">
                    <p class="card-text f-12">{{$t('register.male')}}</p>
                </div>
                <div class="card-footer">
                    <label class="form-group toggle-switch mb-0" for="notification_switch1">
                        <input
                               type="radio"
                               class="toggle-switch-input"
                               id="notification_switch1"
                               value="male"
                               v-model="dataDesign.gender"
                        >
                        <span class="toggle-switch-label mx-auto">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>
                <div v-if="v$.gender.$error">
                    <span class="text-danger" v-if="v$.gender.required.$invalid">gender is required.<br /> </span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card-body text-center">
                    <p class="card-text f-12">{{$t('register.female')}}</p>
                </div>
                <div class="card-footer">
                    <label class="form-group toggle-switch mb-0" for="notification_switch2">
                        <input
                               type="radio"
                               class="toggle-switch-input"
                               id="notification_switch2"
                               value="female"
                               v-model="dataDesign.gender"
                        >
                        <span class="toggle-switch-label mx-auto">
                            <span class="toggle-switch-indicator"></span>
                        </span>
                    </label>
                </div>

                <div v-if="v$.gender.$error">
                    <span class="text-danger" v-if="v$.gender.required.$invalid">gender is required.<br /> </span>
                </div>
            </div>

        </div>

        <div class="dont-have">
            <label class="custom_check">
                <input type="checkbox" v-model="dataDesign.agree">
                <span class="checkmark"></span> {{$t('register.agree')}} <router-link :to="{name:'privacy',params: {lang:this.$i18n.locale}}"> {{$t('register.Privacy')}} </router-link>
                <div v-if="v$.agree.$error">
                    <span class="text-danger" v-if="v$.agree.mustBeCool.$invalid">You must agree to the terms and conditions.<br /> </span>
                </div>
            </label>
        </div>

        <button class="btn btn-primary btn-block btn-lg login-btn text-center btn-color" type="submit">{{$t('register.join')}}</button>
        <div class="row form-row forget-login">
            <div :class="['col-6','text-start','click-forget', this.$i18n.locale == 'ar'? 'forget-register' : '']">
                <router-link  :to="{name:'forgetPassword',params: {lang:this.$i18n.locale}}">{{$t('register.forget')}}</router-link>
            </div>
            <div :class="['col-6','text-end','click',this.$i18n.locale == 'ar'?'login-register': '']">{{$t('register.account')}}
                <router-link :to="{name:'loginPartiner',params: {lang:this.$i18n.locale}}">{{$t('register.click')}}</router-link>
            </div>
        </div>
    </form>
</template>

<script>
import {reactive, inject, toRefs, computed, ref,watch,onMounted} from "vue";
import { useStore } from 'vuex';
import { maxLength, minLength, required,email,sameAs,alphaNum,integer} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

export default {
    name: "designer",
    setup(){

        const store = useStore();
        const emitter = inject('emitter');

        let countries = computed(()=> store.getters['auth/country']);
        let states = computed(()=> store.getters['auth/newState']);
        let errors = computed(()=> store.getters['auth/errors']);
        let foucsCountry = ref({});

        let conutryState =  () => {

            foucsCountry.value = countries._value.filter(country => country.id == design.dataDesign.country);
            design.dataDesign.code = foucsCountry.value[0].code;
            store.dispatch('auth/stateRegister',design.dataDesign.country);
        };

        emitter.on('get_lang_web', () => {
            conutryState();
        });

        //start design
        let design =  reactive({
            dataDesign:{
                name:'',
                email:'',
                password:'',
                confirmtion:'',
                country: '',
                state: '',
                phone: '',
                birth: '',
                gender: '',
                code:'',
                agree: false
            }
        });

        const  validPhone = ref(true);

        watch(() => design.dataDesign.phone, (currentValue, oldValue) => {
            var re = /^\+(20\d{10}|971\d{8}|966\d{9}|964\d{8}|249\d{9}|218\d{8})$/;

            if (re.test(design.dataDesign.code+currentValue)) {
                validPhone.value = true;
            }else{
                validPhone.value = false;
            }
        });

        const mustBeCool = (value) => value ;

        const rules = computed(() => {
            return {
                name: {
                    minLength: minLength(3),
                    maxLength:maxLength(80),
                    required,
                },
                email: {
                    required,
                    email
                },
                password: {
                    required,
                    minLength: minLength(8),
                    maxLength:maxLength(16),
                    alphaNum
                }
                ,
                confirmtion: {
                    required,
                    sameAs: sameAs(design.dataDesign.password)
                },
                phone:{
                    required,
                    maxLength:maxLength(25),
                    integer
                },
                country:{
                    required
                },
                birth:{
                    required
                },
                state:{
                    required
                },
                gender:{
                    required
                },
                agree:{
                    mustBeCool
                }
            }
        });

        const v$ = useVuelidate(rules,design.dataDesign);

        return {v$,validPhone,...toRefs(design),countries,conutryState,states,foucsCountry,errors}
    },
    methods: {
        Designsubmit(){
            this.v$.$validate();

            if(!this.v$.$error && this.validPhone && this.dataDesign.phone){

                this.$store.dispatch('auth/DesignRegister', this.dataDesign);

            }else {
                var re = /^\+(20\d{10}|971\d{8}|966\d{9}|964\d{8}|249\d{9}|218\d{8})$/;

                if (!re.test(this.dataDesign.code+this.dataDesign.phone)) {
                    this.validPhone = false;
                }
            }

        }
    }
}
</script>

<style scoped>
    .card {
        border: none;
        box-shadow: none;
    }

    .card-body {
         padding: 0;
    }

    .card-footer {
        border-top: none;
    }

    .toggle-switch {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    .toggle-switch-input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }

    .toggle-switch-label {
        position: relative;
        display: block;
        width: 3rem;
        height: 30px;
        background-color: #e7eaf3;
        background-clip: content-box;
        border: 0.125rem solid transparent;
        border-radius: 6.1875rem;
        transition: .3s;
    }

    .toggle-switch-indicator {
        position: absolute;
        left: 0.125rem;
        bottom: 50%;
        width: 22px;
        height: 22px;
        background-color: #fff;
        transform: initial;
        box-shadow: 0 3px 6px 0 rgb(140 152 164 / 25%);
        border-radius: 50%;
        transform: translate3d(0, 50%, 0);
        transition: .3s;
    }

    #notification_switch1:checked ~ span{
        background-color: #fcb00c;
    }

    #notification_switch1:checked ~ span span{
        background-color: #fff;
        transform: translate(18px, 11px);
    }

    #notification_switch2:checked ~ span{
        background-color: #fcb00c;
    }

    #notification_switch2:checked ~ span span{
        background-color: #fff;
        transform: translate(18px, 11px);
    }

    img {
        width: 30px;
        height: 20px;
    }

    .flag{
        top: 34px;
        left: 10px;
        position: absolute;
    }

    .phone {
        padding-left: 70px;
        text-align: left;
    }

    .login-right .dont-have a, .click-forget a:hover ,.click a{
        color: #fcb00c;
    }

    .btn-color:hover{
        background-color: #fcb00c;
        border-color: #fcb00c ;
    }

</style>
