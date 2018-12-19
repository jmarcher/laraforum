<template>
    <button class="btn btn-default" @click="toggle">
        <i :class="heartClass"></i>
        <span v-text="count"></span>
    </button>
</template>
<script>
    export default {
        props: ['reply'],
        data() {
            return {
                count: this.reply.favorites_count,
                active: this.reply.is_favorited,
            };
        },
        computed: {
            heartClass() {
                return [this.active ? 'fas fa-heart' : 'far fa-heart'];
            },
            endpoint(){
                return `/replies/${this.reply.id}/favorites`;
            },
        },
        methods: {
            destroy() {
                axios.delete(this.endpoint);
                this.active = false;
                this.count--;
            },
            create() {
                axios.post(this.endpoint);
                this.count++;
                this.active = true;
            },
            toggle() {
                if (this.active) {
                    this.destroy();
                } else {
                    this.create();
                }
            },
        }
    }
</script>

