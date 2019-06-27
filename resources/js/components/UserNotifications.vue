<template>
    <li v-show="notifications.length" class="nav-item dropdown">
        <a id="notificationsDropdown" class="nav-link dropdown-toggle-split" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell"></i>
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationsDropdown">
            <a v-for="(notification, index) in notifications" class="dropdown-item" :href="notification.data.link" :key="notification.id" v-html="notification.data.message" @click="mark(notification, index)"></a>
        </div>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: []
            };
        },

        created() {
            axios.get(`/users/${this.user.id}/notifications`)
                .then(({data}) => this.notifications = data);
        },

        methods: {
            /**
             * 읽지 않은 알림을 읽은 상태로 마크 합니다.
             *
             * @param {object} notification
             * @param {int} index
             */
            mark(notification, index) {
                axios.delete(`/users/${this.user.id}/notifications/${notification.id}`)
                    .then(() => this.$delete(this.notifications, index));
            }
        }
    }
</script>