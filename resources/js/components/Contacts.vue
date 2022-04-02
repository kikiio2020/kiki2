<template>

<div>

<b-container>
<b-row><b-col class="text-left">
<b-card title="Newsletter" class="bg-transparent">
<b-card-text>
Sign up for Kikiio News and get updates on my latest projects and activities.
</b-card-text>
<b-card-text>
<i class="far fa-newspaper"></i> <a class="text-white" href="#" @click="showSubscribeForm=true">Subscribe</a>
</b-card-text>
</b-card>

<b-card title="Email" class="bg-transparent">
<b-card-text>
Contact me directly through email
</b-card-text>
<b-card-text>
<a href="mailto:info@kikiio.com" class="text-white"><i class="far fa-envelope"></i> info@kikiio.com</a>
</b-card-text>
</b-card>

</b-col></b-row>
</b-container>

<b-modal 
	id="subscribeForm" 
	title="Subscribe to Kikiio News" 
	v-model="showSubscribeForm"
	header-class="subscribeForm"
	body-class="subscribeForm" 
	footer-class="subscribeForm"
	:ok-title="okText ? okText : 'Subscribe'"
	:ok-disabled="formInvalid || formSubmitting || formSubmitted"
	@ok="handleSubscribe"
	@hidden="handleHide"
	no-close-on-backdrop
>
	<div><small>All fields required</small></div>
    <ValidationObserver ref="formObserver" v-slot="formContext">
    	<b-form 
    		ref="subscribeForm" 
    		v-on="getFormValidationState(formContext)" 
    		@submit.stop.prevent="handleSubmit"
   		>
	      <b-form-group
	        id="name-group"
	        label="Name:"
	        label-for="name"
	      >
		      <ValidationProvider rules="required" v-slot="validationContext" name="Name">
				  <b-form-input
					  id="name"
					  name="name"
					  type="text"
					  v-model="name"
					  required
					  placeholder="Your name"
					  aria-describedby="feedback"
					  :state="getValidationState(validationContext)"
				  ></b-form-input>
				  <b-form-invalid-feedback id="feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
		      </ValidationProvider>
	      </b-form-group>
	      
	      <b-form-group
	        id="email-group"
	        label="Email address:"
	        label-for="email"
	      >
	        <template v-slot:description="">
	        	<div class="text-white">I will not share your email with anyone else.</div>
	        </template>
	        <ValidationProvider rules="required|email" v-slot="validationContext" name="Email">
		        <b-form-input
		          id="email"
		          name="email"
		          type="email"
		          v-model="email"
		          required
		          placeholder="Your email"
		          aria-describedby="feedback"
				  :state="getValidationState(validationContext)"
		        ></b-form-input>
		        <b-form-invalid-feedback id="feedback">{{ validationContext.errors[0] }}</b-form-invalid-feedback>
	        </ValidationProvider>
	      </b-form-group>
	      
	      <b-form-group
	        id="country-group"
	        label="Country:"
	        label-for="country"
	      >
	      	<ValidationProvider rules="required" v-slot="validationContext" name="Country">
	      		<country-select 
	      			id="country"
	      			name="country" 
	      			v-model="country" 
	      			:country="country"
	      			required
	      			:countryName="true"
				  	:state="getValidationState(validationContext, 'country')"
	     		/>
	     		<div class="text-danger "><small>{{ validationContext.errors[0] }}</small></div>
	     	</ValidationProvider>
	      </b-form-group>
	      
	      <b-form-group
	        id="region-group"
	        label="Region:"
	        label-for="region"
	      >
	      	<ValidationProvider rules="required" v-slot="validationContext" name="Region">
	      		<region-select 
	      			id="region" 
	      			name="region"
	      			v-model="region" 
	      			:country="country" 
	      			:region="region" 
	      			default-region=""
	      			:countryName="true"
	      			:regionName="true"
	      			required
				  	:state="getValidationState(validationContext)" 
	     		/>
	     		<div class="text-danger "><small>{{ validationContext.errors[0] }}</small></div>
	     	</ValidationProvider>
	      </b-form-group>
      
    	</b-form>
    	<b-toast id="successMessage" title="OK" static no-auto-hide variant="success">
      		{{successMessage}}
    	</b-toast>
    	<b-toast id="errorMessage" title="Error" static no-auto-hide variant="danger">
      		{{errorMessage}}
    	</b-toast>
    </ValidationObserver>
  </b-modal>

</div>

</template>
<script>
import Vue from 'vue';
import vueCountryRegionSelect from 'vue-country-region-select'; //https://github.com/gehrj/vue-country-region-select
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import { required, email } from 'vee-validate/dist/rules';

Vue.use(vueCountryRegionSelect);

extend('email', email);
extend('required', {
    ...required,
    message: "{_field_} is required"
});

export default {
    components: {ValidationProvider, ValidationObserver},
    props: [],
    data() {
        return {
        	formInvalid: true,
			formSubmitting: false,
			formSubmitted: false,
        	showSubscribeForm: false,
        	name: '',
        	email: '',
        	country: '',
            region: '',
            successMessage: '',
			errorMessage: '',
			okText: '',
        }
    },
    methods: {
		getFormValidationState({ invalid }) {
            this.formInvalid = invalid;                
        },
    	getValidationState({ dirty, validated, valid = null, invalid, errors }, name) {
        	return dirty || validated ? valid : null;
        },
        handleHide() {
        	this.name = '';
        	this.email = '';
        	this.country = '';
        	this.region = '';
        	this.formInvalid = true;
			this.formSubmitting = false;
			this.formSubmitted = false;
        	this.successMessage = '';
			this.errorMessage = '';
			this.okText = '';
        },
        handleSubscribe(bvModalEvt) {
        	bvModalEvt.preventDefault();
			if (!this.formInvalid) {
        		this.formSubmitting = true;
				this.okText = '...';
				axios.post('/webapi/subscribeNews', {
        			email: this.email,
        			name: this.name,
        			country: this.country,
        			region: this.region,
        		}).then(response => {
					this.okText = 'Submitted';
					this.formSubmitting =false;
					this.formSubmitted = true;
					this.successMessage = 'Thank you! Please check your email and follow instructions there to confirm';
					this.$bvToast.show('successMessage');
        		}).catch(error => {
					this.formSubmitting = false;
					this.formSubmitted = false;
					this.okText = '';
					this.errorMessage = error.response.data;
					if (this.errorMessage == 'CSRF token mismatch') {
						this.$bvToast.show('Please refresh your browser before proceeding');
					} else {
						this.$bvToast.show('errorMessage');
					}
        		}).finally(() => {
        			//this.formSubmitting = false;
        		});
			}
			
        }
    },
    computed: {},
    mounted() {
	}
}
</script>
<style>
.subscribeForm {
	background-color: #5650D0;
	color: #ffffff;
}
</style>