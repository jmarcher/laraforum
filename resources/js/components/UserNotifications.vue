<template>
    <li class="nav-item dropdown" v-if="notifications.length">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item"
               :href="notification.data.path"
               v-for="notification in notifications"
               v-text="notification.data.message"
               @click="markAsRead"></a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {notifications: false};
        },
        created() {
            axios.get(`/profiles/${window.App.user.name}/notifications`)
                .then(response => this.notifications = response.data);
        },
        methods: {
            markAsRead(notification) {
                axios.delete(`/profiles/${window.App.user.name}/notifications/${notification.id}`);
            }
        }
    }
</script>
