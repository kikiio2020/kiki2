<template>
<b-container>
<b-row><b-col class="text-left ml-5 mr-5 pl-5 pr-5">
<h3 class="mt-5">Kikiio Newsletter Subscription</h3>
<p>I'm sorry to see you go <i class="far fa-frown"></i> but you can come back anytime! Please use the Unsubscribe button below to confirm. 
<p>
Unsubscribing: {{ $route.params.email }} 
</p>
<p>
	<b-toast id="successMessage" title="OK" static no-auto-hide variant="success">
    	{{successMessage}}
    </b-toast>
    <b-toast id="errorMessage" title="Error" static no-auto-hide variant="danger">
      	{{errorMessage}}
    </b-toast>
	<b-button variant="success" @click="unsubscribe" :disabled="processing">Unsubscribe</b-button>
</p>
</b-col></b-row>
</b-container>
</template>
<script>
export default {
    components: {},
    props: [],
    data() {
        return {
        	processing: false,
        	successMessage: '',
            errorMessage: '',
        }
    },
    methods: {
    	unsubscribe() {
    		this.processing = true;
    		axios.post('/webapi/unsubscribeNews', {
    			email: this.$route.params.email,
    		}).then(response => {
    			this.successMessage = 'Successfully unsubscribed';
    			this.$bvToast.show('successMessage');
    		}).catch(error => {
    			this.errorMessage = error.response.data;
    			this.$bvToast.show('errorMessage');
    		}).finally(() => {
    			this.processing = false;
    		});
    	}
    },
    computed: {},
    mounted() {
    }
}
</script>