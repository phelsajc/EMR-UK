<template>
    <div class="container">
        <a href="#" class="d-block" >{{user}}</a>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                user: localStorage.getItem('user_type')
            }
        },
        watch: {
            user: function (val) {
                this.$root.bladeValue = val;
            }
        }
    }
</script>
