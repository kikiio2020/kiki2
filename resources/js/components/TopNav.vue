<template>
<b-nav align="right" class="d-none d-md-flex">
	<b-nav-item 
     	v-for="(item, key) in menuItems"
        :to="item.url"
        :key="'menu' + key"
    >
    	<i v-if="item.icon" :class="item.icon"></i>
    	<span v-else>{{key}}</span>
    </b-nav-item>
    <b-nav-item 
       	v-for="(item, key) in externalMenuItems"
       	:href="item.url"
       	target="_blank"
       	:key="'extmenu' + key"
    ><i :class="item.icon"></i></b-nav-item>
</b-nav>
</template>
<script>
export default {
    components: {},
    props: {
    	menuItems: {
    		default: () => {}
    	}, 
    	externalMenuItems: {
    		default: () => {}
    	}
    },
    data() {
        return {}
    },
    methods: {},
    computed: {},
    mounted() {
    }
}
</script>