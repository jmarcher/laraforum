<template>
    <button class="btn" @click="subscribe" :class="active ? 'btn-primary' : 'btn-default'">{{ this.active ?
        'Unsubscribe' : 'Subscribe' }}
    </button>
</template>

<script>
    export default {
        props: ['active'],
        methods: {
            subscribe() {
                axios[this.active ? 'delete' : 'post'](`${location.pathname}/subscriptions`).then(() => {
                    this.active = !this.active;
                });
            }
        }
    }
</script>
