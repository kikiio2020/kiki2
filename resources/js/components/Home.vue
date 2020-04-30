<template>
<b-container fluid >
    <b-row>
        <b-col 
        	class="d-flex align-items-center justify-content-center font-italic p-5" 
        >
        	<div class="d-md-none m-5 text-center" style="opacity: 0.2; position: absolute;">
        		<b-img fluid src="images/frontLogo.png"></b-img>
        	</div>
        	
        	<div class="m-5 text-left">
            	<p>{{randomQuote.text}}</p>
            	<p class="text-right">--{{randomQuote.author}}</p>
            	<p v-if="randomQuote.source" class="text-right"><a :href="randomQuote.source">source</a></p>
        	</div>
        </b-col>
        <b-col 
        	class="d-none d-md-flex align-items-center justify-content-center p-5"  
        	@mouseover="logoHover=true" 
        	@mouseleave="logoHover=false"
    	>
    		<div class="text-center m-5" style="position: absolute;">
    		 	<b-img fluid src="images/frontLogo.png"></b-img>
		 	</div>
        	<transition name="fade" mode="out-in">
        		<div v-if="logoHover" class="text-center m-5" style="position: absolute; z-index:2;" key="logoHeart">
        		 	<b-img fluid src="images/frontLogoHeart.png"></b-img>
    		 	</div>
    		</transition>
        </b-col>
    </b-row>
</b-container>
</template>
<script>
import quotes from '../quotes.js';

export default {
    components: {},
    props: [],
    data() {
        return {
        	logoHover: false,
        	quotes,
        }
    },
    methods: {
    },
    computed: {
    	randomQuote() {
    		return this.quotes[Math.floor(Math.random() * this.quotes.length)];
		}
    },
    mounted() {
    }
}
</script>
<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to {
    opacity: 0;
}
</style>