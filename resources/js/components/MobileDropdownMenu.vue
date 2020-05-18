<template>
<b-list-group flush>
   	<b-list-group-item 
		v-for="(item, key) in menuItems"
		:to="item.url"
		class="p-0 m-0"
		:key="'menu' + key"
	>
		<div class="p-1" style="background-color:#291fff">
			{{key}}
		</div>
	</b-list-group-item>
	<b-list-group-item 
		v-for="(item, key) in externalMenuItems"
		:href="item.url"
		target="_blank"
		class="p-0 m-0"
		:key="'extmenu' + key"
	>
		<div class="p-1" style="background-color:#291fff">
			<i :class="item.icon"></i>
		</div>
	</b-list-group-item>
</b-list-group>
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
    mounted() {}
}
</script>